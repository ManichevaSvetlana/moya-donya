<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{

    public function setPhotos(Request $request){
       if ($request->session()->exists('i')) {
           $i = $request->session()->get('i') + 1;
            $request->session()->put('i', $i);
        }
        else {
            $i = 0;
            $request->session()->put('i', $i);
        }
        foreach ($request->all() as $photo) {
            $request->session()->put('photos['.$i.']', $photo);
            $i++;
        }
        $request->session()->put('i', $i);
       $lol = $request->all();
       //dd($lol);
        dd($lol);
    }

    public function getPhotos(Request $request){
        $i = $request->session()->get('i');
        $request->session()->forget('i');
        $request->session()->forget('photos');
        return $i;
    }

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


    public static function test(){
        return('Everything is ok');
    }

}
