<?php

namespace App\Http\Controllers\Api\v1;

use App\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;

class NotificationController extends Controller
{
    public function saveFile($file)
    {
        $image = $file;
        $hash = sha1_file($file);
        $urlChunked = str_split($hash, 2);
        $fileName = array_pop($urlChunked) . '.' . $image->extension();
        $path = '/public/files/' . implode('/', $urlChunked);
        $storagePath = Storage::putFileAs($path, $image, $fileName);

        return $storagePath;
    }

    public function index()
    {
        $all = Notification::query()->with('user')->orderBy('id', 'DESC')->get();
        return response()->json(['success' => $all], 200);
    }

    public function dashboard(Request $request)
    {
        if (isset($request->limit)) {
            $all = Notification::query()->with('user')->where('status', 1)->orderBy('id', 'DESC')->limit($request->limit)->get();

        } else {
            $all = Notification::query()->with('user')->where('status', 1)->orderBy('id', 'DESC')->get();

        }
        return response()->json(['success' => $all], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'text' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        if ($request->file) {
            $file = $this->saveFile($request->file('file'));
            Notification::create(['text' => $request->text, 'title' => $request->title, 'user_id' => Auth::id(), 'file' => $file, 'status' => $request->status]);
            return response()->json(['success' => 'Создано'], 200);
        } else {
            Notification::create(['text' => $request->text, 'title' => $request->title, 'user_id' => Auth::id(), 'status' => $request->status]);
            return response()->json(['success' => 'Создано'], 200);
        }
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $find = Notification::where('id', $request->id)->with('user')->first();
        return response()->json(['success' => $find], 200);

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'text' => 'required',
            'status' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $find = Notification::find($request->id);
        $find->title = $request->title;
        $find->text = $request->text;
        $find->status = $request->status;
        $find->save();
        return response()->json(['success' => 'Запись обновлена'], 200);
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $find = Notification::destroy($request->id);
        return response()->json(['success' => $find], 200);
    }
}
