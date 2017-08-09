<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public static function checkImage(Request $request)
    {
        foreach ($request->photos as $photo) {
            if ($photo->extension() != 'png' && $photo->extension() != 'jpg' && $photo->extension() != 'jpeg') return false;
        }
        return true;
    }

    public static function saveFile($photo)
    {
       return $filename = $photo->store('images/products');
    }

    public static function store($itemId, $filename){
        Photo::insert([
            'item_id' => $itemId,
            'photo' => $filename
        ]);
    }

    public static function storeAll($itemId, $request){
        foreach ($request->photos as $photo) {
            $filename = PhotoController::saveFile($photo); // Save image and put new file name on the server to $filename
            PhotoController::store($itemId, $filename); // Create new record in table Photo
        }
    }

    public static function destroy($id){
        Photo::findOrFail($id)->delete();
    }

}
