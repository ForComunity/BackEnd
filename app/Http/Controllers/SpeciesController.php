<?php

namespace App\Http\Controllers;

use App\Models\ArticleSpeciesModel;
use App\Models\ContactModel;
use App\Models\SpeciesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpeciesController extends Controller
{
    public function index()
    {
        $contact = SpeciesModel::all();
        return response()->json($contact->sortByDesc('id')->values(), 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'spe_cat_id' => 'required',
            'cat_id' => 'required',
            'description' => 'required',
            'description_seo' => 'required',
            'title' => 'required',
            'title_seo' => 'required',
            'content1' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $species = new SpeciesModel();
        $species->name = $request['name'];
        $species->slug = str_slug( $request['name']);
        $species->spe_cat_id = $request['spe_cat_id'];
        $species->cat_id = $request['cat_id'];
        $species->user_id = $request['user_id'];
        $species->description = $request['description'];
        $species->description_seo = $request['description_seo'];
        $species->title = $request['title'];
        $species->title_seo = $request['title_seo'];
        $species->content1 = $request['content1'];
        $species->content2 = $request['content2'];
        $species->content3 = $request['content3'];
        $species->status = $request['status'];
        if ($request->hasFile('image1')) {
            $file = upload_image('image1');
            if (isset($file['name'])) {
                $species->image1 = $file['name'];
            }
        }
        if ($request->hasFile('image2')) {
            $file = upload_image('image2');
            if (isset($file['name'])) {
                $species->image2 = $file['name'];
            }
        }
        if ($request->hasFile('image3')) {
            $file = upload_image('image3');
            if (isset($file['name'])) {
                $species->image3 = $file['name'];
            }
        }
        $species->save();
        return response()->json($species, 201);
    }



    public function show($id)
    {
        $species = SpeciesModel::find($id);
        if (is_null($species)) {
            return response()->json(["message" => "Record not found!!"], 404);
        }
        return response()->json($species, 200);
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'spe_cat_id' => 'required',
            'cat_id' => 'required',
            'description' => 'required',
            'description_seo' => 'required',
            'title' => 'required',
            'title_seo' => 'required',
            'content1' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $species = new SpeciesModel();
        if ($id) $species = SpeciesModel::find($id);
        $species->name = $request['name'];
        $species->slug = str_slug( $request['name']);
        $species->spe_cat_id = $request['spe_cat_id'];
        $species->cat_id = $request['cat_id'];
        $species->user_id = $request['user_id'];
        $species->description = $request['description'];
        $species->description_seo = $request['description_seo'];
        $species->title = $request['title'];
        $species->title_seo = $request['title_seo'];
        $species->content1 = $request['content1'];
        $species->content2 = $request['content2'];
        $species->content3 = $request['content3'];
        $species->status = $request['status'];
        if ($request->hasFile('image1')) {
            $file = upload_image('image1');
            if (isset($file['name'])) {
                $species->image1 = $file['name'];
            }
        }
        if ($request->hasFile('image2')) {
            $file = upload_image('image2');
            if (isset($file['name'])) {
                $species->image2 = $file['name'];
            }
        }
        if ($request->hasFile('image3')) {
            $file = upload_image('image3');
            if (isset($file['name'])) {
                $species->image3 = $file['name'];
            }
        }
        $species->update($request->all());
//        $species->save();
        return response()->json($species, 200);
    }


    public function destroy($id)
    {
        $species = SpeciesModel::find($id);
        if (is_null($species)) {
            return Response()->json(["message" => "Record not found!!"], 404);
        }

        $species->delete();
        return response()->json(null, 204);
    }

    public function changeStatus($id)
    {
        $species = SpeciesModel::find($id);
        if (is_null($species)) {
            return Response()->json(["message" => "Record not found!!"], 404);
        }
        $species->spe_status = $species->spe_status ? 0 : 1;
        $species->save();
        return response()->json($species, 200);
    }

    public function changeHot($id)
    {
        $species = SpeciesModel::find($id);
        if (is_null($species)) {
            return Response()->json(["message" => "Record not found!!"], 404);
        }
        $species->spe_hot = $species->spe_hot ? 0 : 1;
        $species->save();
        return response()->json($species, 200);
    }
}
