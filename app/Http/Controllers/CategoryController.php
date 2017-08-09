<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin-resource.resource',[
            'resource' => 'category'
        ]);
    }

    public function create()
    {
        return ResourceController::create(Category::class);
    }

    public function store(Request $request)
    {
        ResourceController::store($request, Category::class);
        return 'Category was added';
    }

    public function update(Request $request, $id)
    {
        ResourceController::update($request, $id, Category::class);
        return 'Category was updated';
    }

    public function destroy($id)
    {
        ResourceController::destroy($id, Category::class);
        return 'Category was deleted';
    }
}
