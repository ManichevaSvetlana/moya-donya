<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**Display a listing of the resource.*/
    public static function create($model, $number = null, $skip = null)
    {
        if ($number != null && $skip != null) return $model::skip($skip)->take($number)->orderBy('created_at')->get();
        elseif ($number != null) return $model::take($number)->orderBy('created_at')->get();
        else return $model::orderBy('created_at', 'desc')->get();
    }

    /**Store a newly created resource in storage.*/
    public static function store(Request $request, $model)
    {
        return $model::create($request->all());
    }

    /**Display the specified resource.*/
    public static function show($id, $model)
    {
        return $model::findOrFail($id);
    }


    /**Update the specified resource in storage.*/
    public static function update(Request $request, $id, $model)
    {
        $resource = $model::findOrFail($id);
        return $resource->fill($request->all())->save();
    }

    /**Remove the specified resource from storage.*/
    public static function destroy($id, $model)
    {
        return $model::findOrFail($id)->delete();
    }

    public static function destroyRelated($model, $pivot = null)
    {
        if($pivot === null){
            foreach ($model as $element) {
                $element->delete();
            }
        }
        else{
            foreach ($model as $element) {
                $element->pivot->delete();
            }
        }
    }

}
