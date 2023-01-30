<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubCategoryResource;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Spiral\Goridge\RPC\RPC;

class SubCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('fix.pagination')->only('index');
        $this->authorizeResource(SubCategory::class, 'subCategory');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = SubCategory::query();
        $query->orderBy($request->sortBy ?: 'created_at', $request->sortDesc == 'true' ? 'desc' : 'asc');
        return SubCategoryResource::collection($query->paginate($request->itemsPerPage));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return SubCategoryResource
     */
    public function store(Request $request)
    {
        $subCategory = SubCategory::create($request->all());
        return new SubCategoryResource($subCategory);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\SubCategory $subCategory
     * @return SubCategoryResource
     */
    public function show(SubCategory $subCategory)
    {
        return new SubCategoryResource($subCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubCategory $subCategory
     * @return SubCategoryResource
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        $subCategory->update($request->all());
        $subCategory->refresh();
        return new SubCategoryResource($subCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\SubCategory $subCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();
        return response()->json(['message' => 'success']);
    }
}
