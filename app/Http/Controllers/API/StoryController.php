<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Http\Requests\StoryRequest;

class StoryController extends Controller
{
      public function index()
      {
            $stories = Story::orderBy('created_at', 'desc')->get();
            return response()->json($stories);
      }

      public function store(StoryRequest $request)
      {
            $story = Story::create($request->validated());
            return response()->json($story, 201);
      }

      public function show(Story $story)
      {
            return response()->json($story);
      }

      public function update(StoryRequest $request, Story $story)
      {
            $story->update($request->validated());
            return response()->json($story);
      }

      public function destroy(Story $story)
      {
            $story->delete();
            return response()->json(null, 204);
      }
}
