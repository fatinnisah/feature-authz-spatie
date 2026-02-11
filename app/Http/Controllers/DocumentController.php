<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $document = Document::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'author_id' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document created successfully',
            'document' => $document,
        ], 201);
    }
}
