<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Jobs\UpdateImage;
use Illuminate\Http\Request;

class UploadAvatarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        return Inertia::render('Upload');
    }

    public function update(Request $request)
    {
        if ($request->file('image')) {
            $file = $request->file('image');

            $file->move(storage_path() . '/uploads', $id = uniqid());
            $this->dispatch(new UpdateImage($request->user(), $id));
        }


        return redirect()->back();
    }
}
