<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('fix.pagination')->only('index');
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('filters')) {
            $query = getQueryWithFilters(json_decode($request->filters, true), $query);
        }

        if ($request->filled('with')) {
            $query->with($request->with);
        }

        if (auth()->user()->role == 'vendor') {
            $query->where('vendor_id', auth()->id());
        }
        $query->orderBy($request->sortBy ?: 'created_at', $request->sortDesc == 'true' ? 'desc' : 'asc');
        return UserResource::collection($query->paginate($request->itemsPerPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return UserResource
     */
    public function store(Request $request)
    {
        if ($request->password) {
            $request->merge(['password' => Hash::make($request->input('password'))]);
        } else {
            $request->request->remove('password');
        }
        if (auth()->user()->role == 'vendor' || auth()->user()->role == 'customer') {
            $request->merge(['vendor_id' => auth()->id()]);
        }
        $user = User::create($request->all());

        if ($request->file('image')) {
            $fileName = $request->file('image')->getFilename() . '.' . $request->file('image')->getExtension();
            $ext = $request->file('image')->getExtension();
            $user->addMediaFromRequest('image')
                ->usingFileName(md5($fileName) . '.' . $ext)
                ->toMediaCollection('image');
        }

        if ($request->filled('with')) {
            $user->load($request->with);
        }
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return UserResource
     */
    public function show(Request $request, User $user)
    {
        if ($request->filled('with')) {
            $user->load($request->with);
        }
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return UserResource
     */
    public function update(Request $request, User $user)
    {
        if ($request->password) {
            $request->merge(['password' => Hash::make($request->input('password'))]);
        } else {
            $request->request->remove('password');
        }
        if (auth()->user()->role == 'vendor' || auth()->user()->role == 'customer') {
            $request->merge(['vendor_id' => auth()->id()]);
        }
        $user->update($request->all());

        if ($request->file('image')) {
            $user->clearMediaCollection('image');
            $fileName = $request->file('image')->getFilename() . '.' . $request->file('image')->getExtension();
            $ext = $request->file('image')->getExtension();
            $user->addMediaFromRequest('image')
                ->usingFileName(md5($fileName) . '.' . $ext)
                ->toMediaCollection('image');
        }

        if ($request->filled('with')) {
            $user->load($request->with);
        }
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'success']);
    }
}
