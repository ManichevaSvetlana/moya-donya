<?php

namespace App\Http\Controllers;

use App\Item;
use App\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::all();
        $id = ItemController::getId() + 1;
        $photos = $photos->where('item_id', $id);
        $mainPhoto = $photos->where('is_main', 1);
        return [
            'photos' => $photos,
            'mainPhoto' => $mainPhoto
        ];
    }

    public function store(Request $request)
    {
        $itemId = ItemController::getId() + 1;
        if ($request->mainPhoto != null) {
            $id = PhotoController::isMainExists();
            if ($id != false) PhotoController::destroy($id);
            PhotoController::storeOne($itemId, $request->mainPhoto, 1);
        } else {
            PhotoController::storeAll($itemId, $request, 0);
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        ResourceController::destroy($id, Photo::class);
        return;
    }

    public static function checkImage($photo)
    {
        if ($photo->extension() != 'png' && $photo->extension() != 'jpg' && $photo->extension() != 'jpeg') return false;
        return true;
    }

    public static function saveFile($photo)
    {
        return $filename = $photo->store('images/products');
    }

    public static function saveRecord($itemId, $filename, $isMain)
    {
        Photo::insert([
            'item_id' => $itemId,
            'photo' => $filename,
            'is_main' => $isMain
        ]);
    }

    public static function storeOne($itemId, $photo, $isMain)
    {
        if (PhotoController::checkImage($photo)) {
            $filename = PhotoController::saveFile($photo); // Save an image and put a new file name on the server to $filename
            PhotoController::saveRecord($itemId, $filename, $isMain); // Create new record in the table Photo
        }
    }

    public static function storeAll($itemId, $request, $isMain)
    {
        foreach ($request->photos as $photo) {
            PhotoController::storeOne($itemId, $photo, $isMain); // Create a new record in the table Photo
        }
    }

    public static function isMainExists()
    {
        $photos = Photo::all();
        $itemId = ItemController::getId() + 1;
        $id = $photos->where('item_id', $itemId)->where('is_main', 1)->pluck('id');
        if (!$id->isEmpty()) return $id->toArray()[0];
        else return false;
    }


    public static function storeWithRelative()
    {
        $itemId = ItemController::getId();
        $photos = Photo::all();
        $photos = $photos->where('item_id', $itemId);
        $table = \Illuminate\Support\Facades\DB::table('item_photos');
        foreach ($photos as $photo) {
            $table->insert([
                'item_id' => $itemId,
                'photo_id' => $photo->id,
                'is_main' => $photo->is_main
            ]);
        }

    }

}
