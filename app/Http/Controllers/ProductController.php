<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->productService->getAll(
            page: request()->query('page', 1),
            limit: request()->query('limit', 10),
            sortBy: request()->query('sortBy', 'id'),
            desc: request()->query('desc', false)
        );

        $products = ProductResource::collection($data['data']);

        return response()->json([
            'data' => $products,
            'page' => (int) $data['page'],
            'limit' => (int) $data['limit'],
            'total' => $data['total'],
            'sort_by' => $data['sort_by'],
            'desc' => (bool) $data['desc'],
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
