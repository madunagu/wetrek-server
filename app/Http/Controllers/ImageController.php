<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Intervention\Image\ImageManagerStatic as ImageManager;

use App\Image;

class ImageController extends Controller
{
    public function create(Request $request)
    {
        $type = $request['type'];
        $id = $request['parent_id'];

        $userId = Auth::user()->id;
        $data = [];

        foreach ($request['photos'] as $photo) {
            // $name = time() . '.' . $photo->getClientOriginalExtension();
            $name = time() . '.jpg';
            Storage::put('public/images/full' . $name, $photo);
            $image_resize = ImageManager::make($photo);

            $image_resize->resize(500, 500);
            $image_resize->save('images/replacer');
            $save = Storage::putFileAs("public/images/large", new File('images/replacer'), $name);

            $image_resize->resize(200, 200);
            $image_resize->save('images/replacer');
            $save = Storage::putFileAs("public/images/medium", new File('images/replacer'), $name);

            $image_resize->resize(100, 100);
            $image_resize->save('images/replacer');

            $save = Storage::putFileAs("public/images/small", new File('images/replacer'), $name);

            $image = Image::create([
                'photo' => $photo,
                'full' => 'images/full/' . $name,
                'large' => 'images/large/' . $name,
                'medium' => 'images/medium/' . $name,
                'small' => 'images/small/' . $name,
                'user_id' => $userId,
                'imageable_type' => $type,
                'imageable_id' => $id,
            ]);

            $data[] = $image;
        }



        if ($data) {
            return response()->json(['data' => $data], 201);
        } else {
            return response()->json(['data' => false, 'errors' => 'unknown error occured'], 400);
        }
    }
}
