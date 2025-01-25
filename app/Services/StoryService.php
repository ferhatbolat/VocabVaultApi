<?php

// app/Services/StoryService.php
namespace App\Services;

use App\Models\Story;

class StoryService
{
    public function getAll()
    {
        return Story::all();
    }

    public function create(array $data)
    {
        return Story::create($data);
    }

    public function find($id)
    {
        return Story::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $story = $this->find($id);
        $story->update($data);
        return $story;
    }

    public function delete($id)
    {
        $story = $this->find($id);
        return $story->delete();
    }
}
