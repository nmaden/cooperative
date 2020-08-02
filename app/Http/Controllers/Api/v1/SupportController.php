<?php

namespace App\Http\Controllers\api\v1;

use App\Support;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;

class SupportController extends Controller
{

    public function saveFile($file)
    {
        $image = $file;
        $hash = sha1_file($file);
        $urlChunked = str_split($hash, 2);
        $fileName = array_pop($urlChunked) . '.' . $image->extension();
        $path = '/public/files/'.implode('/', $urlChunked);
        $storagePath = Storage::putFileAs($path, $image, $fileName);

        return  $storagePath;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'ask' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        if ($request->file) {
            $file = $this->saveFile($request->file('file'));
            Support::create(['subject'=>$request->subject,'ask'=>$request->ask,'file'=>$file,'user_id'=>Auth::id()]);
        }
        else {
            Support::create(['subject'=>$request->subject,'ask'=>$request->ask,'user_id'=>Auth::id()]);
        }

        return response()->json(['success' => 'Отправлено'], 200);
    }
}
