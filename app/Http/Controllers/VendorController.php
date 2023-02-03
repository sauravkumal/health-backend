<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\StaffResource;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('fix.pagination')->only('staff');
    }

    public function vendorMenu(Request $request)
    {
        $this->authorize('access-vendor-menu');

        $menu = Category::query()->with(['products' => function ($qu) {
            $qu->orderBy('position');
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

    public function staff(Request $request): AnonymousResourceCollection
    {
        $query = User::query()->where('vendor_id', auth()->id());
        if ($request->search) {
            $query->where('name', '%like%', $request->search);
        }

        $query->orderBy($request->sortBy ?: 'created_at', $request->sortDesc == 'true' ? 'desc' : 'asc');

        return StaffResource::collection($query->paginate($request->itemsPerPage));
    }
}
