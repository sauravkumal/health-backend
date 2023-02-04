<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuResource;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('fix.pagination')->only('index');
        $this->authorizeResource(Menu::class, 'menu');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = Menu::query();

        if ($request->has('filters')) {
            $query = getQueryWithFilters(json_decode($request->filters, true), $query);
        }

        if ($request->filled('with')) {
            $query->with($request->with);
        }
        $query->orderBy($request->sortBy ?: 'created_at', $request->sortDesc == 'true' ? 'desc' : 'asc');
        return MenuResource::collection($query->paginate($request->itemsPerPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return MenuResource
     */
    public function store(Request $request)
    {
        $menu = Menu::create($request->all());
        if ($request->filled('with')) {
            $menu->load($request->with);
        }
        return new MenuResource($menu);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Menu $menu
     * @return MenuResource
     */
    public function show(Request $request, Menu $menu)
    {
        if ($request->filled('with')) {
            $menu->load($request->with);
        }
        return new MenuResource($menu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return MenuResource
     */
    public function update(Request $request, Menu $menu)
    {
        $menu->update($request->all());
        if ($request->filled('with')) {
            $menu->load($request->with);
        }
        return new MenuResource($menu);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return response()->json(['message' => 'success']);
    }
}
