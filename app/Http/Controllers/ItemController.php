<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Colour;
use App\Fluffiness;
use App\Item;
use App\Photo;
use App\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Exception\ErrorException;

class ItemController extends Controller
{
    public function index()
    {
        //dd(Item::findOrFail('1')->category->name);
        return view('admin-resource.item-resource', [
            'categories' => Category::all(),
            'sizes' => Size::all(),
            'brands' => Brand::all(),
            'fluffinesses' => Fluffiness::all(),
            'colours' => Colour::all(),
            'items' => ResourceController::create(Item::class, 12)
        ]);
    }

    public function create()
    {
        return ResourceController::create(Item::class, 12);
    }


    public function store(Request $request)
    {
        $success = false;
        DB::beginTransaction();
        try {
            if (PhotoController::checkImage($request)) {  // Check is file an image
                ItemController::save($request); // Create new record in table Items
                $id = ItemController::getId(); // Get max Id in table Items
                PhotoController::storeAll($id, $request); // Create new records in table Item_photos
                ColourController::storePivot($id, $request); // Create new records in table Item_colours
                $indexes = ItemController::getKeysWithoutNull($request->prices); // Get indexes of prices, where value is exist
                SizeController::storePivot($id, $request, $indexes); // Create new records in table Item_sizes
                $success = true;
            }
        } catch (\Error $e) {
            dd('Something went wrong');
        }
        if ($success) DB::commit();
        else {
            DB::rollback();
        }
        return redirect('/item');
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        ItemController::updateItem($request, $item);
        if (PhotoController::checkImage($request)) {
            PhotoController::storeAll($id, $request);
        }
        ResourceController::destroyRelated($item->colour, true);
        ColourController::storePivot($id, $request);
        ResourceController::destroyRelated($item->size, true);
        $indexes = ItemController::getKeysWithoutNull($request->prices); // Get indexes of prices, where value is exist
        SizeController::storePivot($id, $request, $indexes); // Create new records in table Item_sizes
        dd($item);
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        ResourceController::destroyRelated($item->photo);
        ResourceController::destroyRelated($item->colour, true);
        ResourceController::destroyRelated($item->size, true);
        $item->delete();
        return redirect('/item');
    }

    protected static function save(Request $request)
    {
        Item::create([
            'category_id' => $request->category,
            'brand_id' => $request->brand,
            'fluffiness_id' => $request->fluffiness,
            'name' => $request->name,
        ]);
    }

    protected static function updateItem(Request $request, $item)
    {
        $item->update([
            'category_id' => $request->category,
            'brand_id' => $request->brand,
            'fluffiness_id' => $request->fluffiness,
            'name' => $request->name,
        ]);
    }

    protected static function getId()
    {
        return Item::max('id');
    }

    protected static function getArrayWithoutNull($array)
    {
        return $indexes = array_filter($array, function ($el) {
            return ($el != null);
        });
    }

    protected static function getKeysWithoutNull($array)
    {
        return $indexes = array_keys(ItemController::getArrayWithoutNull($array));
    }

}