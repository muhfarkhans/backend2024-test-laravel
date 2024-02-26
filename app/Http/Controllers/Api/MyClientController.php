<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MyClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Validator;
use Str;

class MyClientController extends Controller
{
    public function index()
    {
        return MyClient::get();
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => 'required',
            'client_prefix' => 'required',
            'client_logo' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $slug = Str::slug($request->name);

        $newData = [
            'name' => $request->name,
            'slug' => $slug,
            'client_prefix' => $request->client_prefix,
            'client_logo' => $request->client_logo,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'city' => $request->city,
        ];

        $create = MyClient::create($newData);

        Redis::set($slug, json_encode($create));

        return response()->json(['create' => $create]);
    }

    public function update(Request $request, $id)
    {
        $findData = MyClient::where('id', $id)->first();
        if ($findData == null)
            return response()->json('data not found');

        $rules = [
            'name' => 'required',
            'client_prefix' => 'required',
            'client_logo' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $slug = Str::slug($request->name);

        $newData = [
            'name' => $request->name,
            'slug' => $slug,
            'client_prefix' => $request->client_prefix,
            'client_logo' => $request->client_logo,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'city' => $request->city,
        ];

        $update = MyClient::where('id', $id)->update($newData);
        $updated = MyClient::where('id', $id)->first();

        Redis::set($slug, json_encode($updated));

        return response()->json(['update' => $update]);
    }

    public function delete($id)
    {
        $myClient = MyClient::where('id', $id)->first();
        $myClient->delete();
        Redis::del($myClient->slug);

        return $myClient;
    }
}
