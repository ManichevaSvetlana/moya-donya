<?php

namespace App\Http\Controllers;

use App\Colour;
use App\Item;
use Illuminate\Http\Request;

class ColourController extends Controller
{
    public function index()
    {
        return view('admin-resource.resource', [
            'resource' => 'colour'
        ]);
    }

    public function create()
    {
        return ResourceController::create(Colour::class);
    }

    public function store(Request $request)
    {
        ResourceController::store($request, Colour::class);
        return 'Colour was added';
    }

    public function update(Request $request, $id)
    {
        ResourceController::update($request, $id, Colour::class);
        return 'Colour was updated';
    }

    public function destroy($id)
    {
        ResourceController::destroy($id, Colour::class);
        return 'Colour was deleted';
    }

    public static function storePivot($itemId, $request)
    {
        foreach ($request->colours as $colour) {
            Item::findOrFail($itemId)->colour()->attach($colour);
        }
    }

}
