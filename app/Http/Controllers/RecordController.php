<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecordResource;
use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
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
        $query = Record::query();

        if ($request->has('filters')) {
            $query = getQueryWithFilters(json_decode($request->filters, true), $query);
        }

        if ($request->filled('with')) {
            $query->with($request->with);
        }

        $query->orderBy($request->sortBy ?: 'created_at', $request->sortDesc == 'true' ? 'desc' : 'asc');
        return RecordResource::collection($query->paginate($request->itemsPerPage));
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
     * @param \App\Models\Record $record
     * @return RecordResource
     */
    public function show(Request $request, Record $record)
    {
        if ($request->filled('with')) {
            $record->load($request->with);
        }
        return new RecordResource($record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Record $record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Record $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Record $record)
    {
        $record->delete();
        return response()->json(['message' => 'success']);
    }
}
