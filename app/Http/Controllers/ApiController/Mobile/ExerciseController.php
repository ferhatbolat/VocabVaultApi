<?php

namespace App\Http\Controllers\ApiController\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetExerciseRequest;
use App\Http\Resources\ExerciseResource;
use App\Models\Word;
use App\Services\ExerciseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Tag(
 *     name="Exercises",
 *     description="API Endpoints for Exercise Management"
 * )
 */
class ExerciseController extends Controller
{
    protected ExerciseService $exerciseService;

    public function __construct(ExerciseService $exerciseService)
    {
        $this->exerciseService = $exerciseService;
    }

    /**
     * @OA\Get(
     *     path="/exercises",
     *     summary="Get random exercise questions",
     *     tags={"Exercises"},
     *     @OA\Parameter(
     *         name="language",
     *         in="query",
     *         description="Language selection (0: Turkish, 1: English)",
     *         required=true,
     *         @OA\Schema(type="integer", enum={0, 1})
     *     ),
     *     @OA\Parameter(
     *         name="question_count",
     *         in="query",
     *         description="Number of questions to generate",
     *         required=true,
     *         @OA\Schema(type="integer", default=4)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of exercise questions"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     )
     * )
     */
    public function getExercises(GetExerciseRequest $request): AnonymousResourceCollection
    {
        $exercises = $this->exerciseService->generateExercises(
            $request->input('language'),
            $request->input('question_count', 4)
        );

        return ExerciseResource::collection($exercises);
    }
}


