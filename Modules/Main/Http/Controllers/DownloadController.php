<?php

namespace Modules\Main\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class DownloadController extends Controller
{
    //

    public function createLink(Request $request)
    {
        if ($this->checkDownload($request) && $this->checkFile($request)) {
            return URL::temporarySignedRoute('download.link', now()->addMinutes(30), ['user' => auth()->user->id, 'file' => $request->file]);
        }
        return false;
    }

    public function checkDownload($request)
    {
        return $request->user()->download();
    }

    public function checkFile($request)
    {
        return Storage::exists('' . $request->file);
    }

    public function downloadLink($request, User $user)
    {
        if (auth()->user()->id === $user->id) {
            $user->dowanloaded();
            return Storage::download('files/' . $request->file);
        }
        return false;
    }
}
