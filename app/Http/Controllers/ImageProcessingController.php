<?php

namespace App\Http\Controllers;

use App\Jobs\CompressImages;
use Illuminate\Http\Request;

class ImageProcessingController extends Controller
{
    public function scanAndCompress()
    {
        CompressImages::dispatch();
        return response()->json(['message' => 'Image compression started!'], 200);
    }
}
