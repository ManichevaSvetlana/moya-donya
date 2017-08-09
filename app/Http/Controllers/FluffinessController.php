<?php

namespace App\Http\Controllers;

use App\Fluffiness;
use Illuminate\Http\Request;

class FluffinessController extends Controller
{
    public function index()
    {
        return view('admin-resource.resource',[
            'resource' => 'fluffiness'
        ]);
    }

    public function create()
    {
        return ResourceController::create(Fluffiness::class);
    }

    public function store(Request $request)
    {
        ResourceController::store($request, Fluffiness::class);
        return 'Fluffiness was added';
    }

    public function update(Request $request, $id)
    {
        ResourceController::update($request, $id, Fluffiness::class);
        return 'Fluffiness was updated';
    }

    public function destroy($id)
    {
        ResourceController::destroy($id, Fluffiness::class);
        return 'Fluffiness was deleted';
    }
}
