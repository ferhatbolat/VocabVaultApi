<?php

namespace App\Services;

use App\Models\Word;
use Illuminate\Support\Collection;

class ExerciseService
{
    /**
     * Generate random exercise questions based on language selection
     *
     * @param int $language
     * @param int $questionCount
     * @return Collection
     */
    public function generateExercises(int $language, int $questionCount = 4): Collection
    {
        // Get words based on the selected language
        $words = $this->getRandomWords($language, $questionCount);

        return $words->map(function ($word) use ($language) {

            return $this->formatQuestion($word, $language);
        });
    }

    /**
     * Get random words from the database
     *
     * @param int $language
     * @param int $questionCount
     * @return Collection
     */
    private function getRandomWords(int $language, int $questionCount): Collection
    {
        $columns = $language == 0 ? ['id','turkish', 'english'] : ['id','english', 'turkish'];
        return Word::select($columns)->inRandomOrder()->limit($questionCount)->get();
    }

    /**
     * Format a single question with options
     *
     * @param Word $word
     * @param int $language
     * @return array
     */
    private function formatQuestion($word, int $language): array
    {
        $correctAnswer = $language == 0 ? $word->english : $word->turkish;
        $incorrectAnswers = $this->getIncorrectAnswers($word->id, $language);

        $allAnswers = $this->ensureUniqueAnswers($incorrectAnswers, $correctAnswer, $language);

        return [
            'id' =>  $word->id,
            'question' => $language == 0 ? $word->turkish : $word->english,
            'correct_answer' => $correctAnswer,
            'options' => $allAnswers->shuffle()->values()->toArray(),
        ];
    }

    /**
     * Get incorrect answers for a question
     *
     * @param int $wordId
     * @param int $language
     * @return Collection
     */
    private function getIncorrectAnswers(int $wordId, int $language): Collection
    {
        $column = $language == 0 ? 'english' : 'turkish';
        return Word::where('id', '!=', $wordId)
            ->inRandomOrder()
            ->limit(3)
            ->get()
            ->pluck($column);
    }

    /**
     * Ensure we have enough unique answers
     *
     * @param Collection $incorrectAnswers
     * @param string $correctAnswer
     * @param int $language
     * @return Collection
     */
    private function ensureUniqueAnswers(Collection $incorrectAnswers, string $correctAnswer, int $language): Collection
    {
        $allAnswers = $incorrectAnswers->push($correctAnswer)->unique()->values();

        while ($allAnswers->count() < 4) {
            $column = $language == 0 ? 'english' : 'turkish';
            $additionalAnswers = Word::whereNotIn('id', $allAnswers->keys())
                ->inRandomOrder()
                ->limit(1)
                ->get()
                ->pluck($column);

            $allAnswers = $allAnswers->merge($additionalAnswers)->unique()->values();
        }

        return $allAnswers;
    }
}
