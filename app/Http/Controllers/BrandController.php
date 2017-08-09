<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        return view('admin-resource.resource',[
            'resource' => 'brand'
        ]);
    }

    public function create()
    {
        return ResourceController::create(Brand::class);
    }

    public function store(Request $request)
    {
        ResourceController::store($request, Brand::class);
        return 'Brand was added';
    }

    public function update(Request $request, $id)
    {
        ResourceController::update($request, $id, Brand::class);
        return 'Brand was updated';
    }

    public function destroy($id)
    {
        ResourceController::destroy($id, Brand::class);
        return 'Brand was deleted';
    }
}
