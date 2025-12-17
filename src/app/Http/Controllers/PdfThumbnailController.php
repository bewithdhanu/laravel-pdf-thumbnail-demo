<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Shishima\Thumbnail\Facade\Thumbnail;
use Throwable;

class PdfThumbnailController extends Controller
{
    public function create()
    {
        return view('pdf-thumbnail', [
            'result' => session('pdf_thumbnail_result'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:20480'],
        ]);

        try {
            $result = Thumbnail::setFile($validated['pdf'])
                // Preserve aspect ratio: set only one dimension, let Imagick calculate the other.
                // (Avoids forcing a square/warped thumbnail.)
                ->setWidth(256)
                ->setHeight(0)
                ->setFormat('png')
                ->create();

            return redirect()
                ->route('pdf-thumbnail.create')
                ->with('pdf_thumbnail_result', $result);
        } catch (Throwable $e) {
            return redirect()
                ->route('pdf-thumbnail.create')
                ->withErrors(['pdf' => $e->getMessage()]);
        }
    }
}


