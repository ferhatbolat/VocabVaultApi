<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Word;
use App\Http\Requests\WordRequest;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public function index()
    {
        $words = Word::orderBy('created_at', 'desc')->get();
        return response()->json($words);
    }

    public function store(WordRequest $request)
    {
        $word = Word::create($request->validated());
        return response()->json($word, 201);
    }

    public function show(Word $word)
    {
        return response()->json($word);
    }

    public function update(WordRequest $request, Word $word)
    {
        $word->update($request->validated());
        return response()->json($word);
    }

    public function destroy(Word $word)
    {
        $word->delete();
        return response()->json(null, 204);
    }

    public function updateLearningStatus(Request $request, Word $word)
    {
        $request->validate([
            'status' => 'required|integer|min:0|max:2'
        ]);

        $word->update(['learning_status' => $request->status]);
        return response()->json($word);
    }
}
