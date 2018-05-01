<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Colour;
use App\Fluffiness;
use App\Item;
use App\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index()
    {
        $array = [
            'Размеры:' => Size::all(),
            'Классы пышности:' => Fluffiness::all(),
            'Бренды:' => Brand::all(),
            'Цвета:' => Colour::all()
        ];

        return view('admin.items', [
            'categories' => Category::all(),
            'array' => $array
        ]);
    }

    public function create()
    {
        $items = ResourceController::create(Item::class, 12);
        foreach ($items as $item) {
            $item->category_id = $item->category->name;
            $item->size_id = $item->size;
            $item->price_min = $item->size()->min('price');
            $item->price_max = $item->size()->max('price');
            $item->photo_id = $item->photo->where('is_main', 1)->pluck('photo')->toArray()[0];
        }
        return $items;
    }

    public function show($id)
    {
        if ($id === 'new-item') {
            $id = 0;
            return view('admin.pages-profile', [
                'categories' => Category::all(),
                'sizes' => Size::all(),
                'fluffinesses' => Fluffiness::all(),
                'brands' => Brand::all(),
                'colours' => Colour::all(),
                'item_id'  => $id
            ]);
        }else{
            return view('admin.pages-profile', [
                'categories' => Category::all(),
                'sizes' => Size::all(),
                'fluffinesses' => Fluffiness::all(),
                'brands' => Brand::all(),
                'colours' => Colour::all(),
                'item_id'  => $id,
                'item' => Item::findOrFail($id),
                'item_size' => DB::table('item_sizes')->where('item_id', $id)->get(),
            ]);
        }

    }

    public function edit($id)
    {
        //todo
    }

    public function store(Request $request)
    {
        ItemController::storeWithRelative($request);
        return redirect('/item');
    }

    public function update(Request $request, $id)
    {
        ItemController::updateWithRelative($request, $id);
        return redirect('/item');
    }

    public function destroy($id)
    {
        ItemController::destroyWithRelative($id);
        return 'Item was deleted';
    }


    protected static function save(Request $request)
    {
        Item::insert([
            'category_id' => $request->category,
            'brand_id' => $request->brand,
            'fluffiness_id' => $request->fluffiness,
            'description' => $request->description,
            'name' => $request->name
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

    public static function getId()
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

    protected static function storeWithRelative($request)
    {
        $success = false;
        DB::beginTransaction();
        try {
            ItemController::save($request); // Create new record in table Items
            $id = ItemController::getId(); // Get max Id in table Items
            PhotoController::storeWithRelative($id); // Create new records in table Item_photos
            ColourController::storePivot($id, $request); // Create new records in table Item_colours
            $indexes = ItemController::getKeysWithoutNull($request->prices); // Get indexes of prices, where value is exist
            SizeController::storePivot($id, $request, $indexes); // Create new records in table Item_sizes
            $success = true;

        } catch (\Error $e) {
            dd('Something went wrong');
        }
        if ($success) DB::commit();
        else {
            DB::rollback();
        }
    }

    protected static function updateWithRelative($request, $id)
    {
        $item = Item::findOrFail($id);
        ItemController::updateItem($request, $item);
        ResourceController::destroyRelated($item->photo, true);
        PhotoController::storeWithRelative($id); // Create new records in table Item_photos
        ResourceController::destroyRelated($item->colour, true);
        ColourController::storePivot($id, $request);
        ResourceController::destroyRelated($item->size, true);
        $indexes = ItemController::getKeysWithoutNull($request->prices); // Get indexes of prices, where value is exist
        SizeController::storePivot($id, $request, $indexes); // Create new records in table Item_sizes
    }

    protected static function destroyWithRelative($id)
    {
        $item = Item::findOrFail($id);
        ResourceController::destroyRelated($item->photo, true);
        ResourceController::destroyRelated($item->colour, true);
        ResourceController::destroyRelated($item->size, true);
        $item->delete();
    }
}
