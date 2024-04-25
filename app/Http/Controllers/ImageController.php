<?php

namespace App\Http\Controllers;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function create()
    {
        return view('upload');
    }

    public function update(Request $request, $id)
    {
        $tag = $request->input('tag');
        $image = Image::find($id);
        $image->tag = $tag;
        $image->save();

        return redirect('/gallery')->with('success', 'Image tag updated successfully!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|file|image|max:5000',
        ]);

        $imageName = time() . '.' . $request->image->extension();

        $request->image->storeAs('public/images', $imageName);

        $image = new Image;
        $image->filename = $imageName;
        $image->save();

        return back()
            ->with('success','Image uploaded successfully.')
            ->with('image',$imageName);
    }

    public function gallery(Request $request)
    {
        $tag = $request->input('tag');

        if ($tag) {
            $images = Image::where('tag', $tag)->get();
        } else {
            $images = Image::all();
        }
        return view('gallery', ['images' => $images]);
    }
}
