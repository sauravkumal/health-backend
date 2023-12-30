<?php

namespace App\Http\Controllers;

use App\Http\Resources\TelegramUserResource;
use App\Models\TelegramUser;
use Illuminate\Http\Request;

class TelegramUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('fix.pagination')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = TelegramUser::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('display_name', 'like', "%$request->search%")
                    ->where('first_name', 'like', "%$request->search%")
                    ->where('last_name', 'like', "%$request->search%")
                    ->where('username', 'like', "%$request->search%")
                    ->where('telegram_id', 'like', "%$request->search%");

            });
        }

        if ($request->has('filters')) {
            $query = getQueryWithFilters(json_decode($request->filters, true), $query);
        }

        if ($request->filled('with')) {
            $query->with($request->with);
        }

        $query->orderBy($request->sortBy ?: 'created_at', $request->sortDesc == 'true' ? 'desc' : 'asc');
        return TelegramUserResource::collection($query->paginate($request->itemsPerPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\TelegramUser $telegramUser
     * @return TelegramUserResource
     */
    public function show(Request $request, TelegramUser $telegramUser)
    {
        if ($request->filled('with')) {
            $telegramUser->load($request->with);
        }
        return new TelegramUserResource($telegramUser);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TelegramUser $telegramUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TelegramUser $telegramUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\TelegramUser $telegramUser
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(TelegramUser $telegramUser)
    {
        $telegramUser->delete();
        return  response()->json(['message'=>'success']);
    }
}
