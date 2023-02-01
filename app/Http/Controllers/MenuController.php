<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function vendorMenu(Request $request)
    {
        $this->authorize('access-vendor-menu');

        $menu = Category::query()->with(['subCategories' => function ($q) {
            $q->with(['products' => function ($qu) {
                $qu->orderBy('position');
            }])
                ->orderBy('position');
        }])
            ->where('vendor_id', auth()->id())
            ->orderBy('position')->get();
        return CategoryResource::collection($menu);
    }

    public function publishMenu(Request $request)
    {
        auth()->user()->update(['publish_menu' => $request->publish]);
        return response()->json(['message' => 'success']);
    }
}
