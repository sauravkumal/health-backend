<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('fix.pagination')->only('index');
        $this->authorizeResource(Product::class, 'product');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('filters')) {
            $query = getQueryWithFilters(json_decode($request->filters, true), $query);
        }

        if ($request->filled('with')) {
            $query->with($request->with);
        }

        $query->orderBy($request->sortBy ?: 'created_at', $request->sortDesc == 'true' ? 'desc' : 'asc');
        return ProductResource::collection($query->paginate($request->itemsPerPage));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return ProductResource
     */
    public function store(Request $request)
    {
        $product = Product::create($request->all());
        if ($request->file('image')) {
            $fileName = $request->file('image')->getFilename() . '.' . $request->file('image')->getExtension();
            $ext = $request->file('image')->getExtension();
            $product->addMediaFromRequest('image')
                ->usingFileName(md5($fileName) . '.' . $ext)
                ->toMediaCollection('image');
        }

        if ($request->filled('with')) {
            $product->load($request->with);
        }

        return new ProductResource($product);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return ProductResource
     */
    public function show(Request $request, Product $product)
    {
        if ($request->filled('with')) {
            $product->load($request->with);
        }
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return ProductResource
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        if ($request->file('image')) {
            $product->clearMediaCollection('image');
            $fileName = $request->file('image')->getFilename() . '.' . $request->file('image')->getExtension();
            $ext = $request->file('image')->getExtension();
            $product->addMediaFromRequest('image')
                ->usingFileName(md5($fileName) . '.' . $ext)
                ->toMediaCollection('image');
        }

        if ($request->filled('with')) {
            $product->load($request->with);
        }
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'success']);
    }
}
