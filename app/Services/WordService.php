<?php
// app/Services/WordService.php
namespace App\Services;

use App\Models\Word;

class WordService
{
    public function getAll()
    {
        return Word::all();
    }

    public function create(array $data)
    {
        return Word::create($data);
    }

    public function find($id)
    {
        return Word::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $word = $this->find($id);
        $word->update($data);
        return $word;
    }

    public function delete($id)
    {
        $word = $this->find($id);
        return $word->delete();
    }
}
