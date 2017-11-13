<?php

namespace App\Http\Controllers;

use App\Item;
use App\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        return view('admin.table-basic', [
            'resource' => 'size'
        ]);
    }

    public function create()
    {
        return ResourceController::create(Size::class);
    }

    public function store(Request $request)
    {
        ResourceController::store($request, Size::class);
        return 'Size was added';
    }

    public function update(Request $request, $id)
    {
        ResourceController::update($request, $id, Size::class);
        return 'Size was updated';
    }

    public function destroy($id)
    {
        ResourceController::destroy($id, Size::class);
        return 'Size was deleted';
    }

    public static function storePivot($itemId, $request, $indexes)
    {
        foreach ($request->sizes as $i => $size) {
            Item::findOrFail($itemId)->size()->attach($size, [
                'price' => $request->prices[$indexes[$i]],
                'quantity' => $request->quantity[$indexes[$i]]
            ]);
        }
    }

    public static function destroyPivot($itemId, $request, $indexes)
    {

    }
}
