<?php

namespace App\Http\Controllers\ApiController\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWordRequest;
use App\Http\Requests\UpdateWordRequest;
use App\Http\Resources\WordResource;
use App\Services\WordService;
use Illuminate\Http\Request;
/**
 * @OA\Tag(
 *     name="Words",
 *     description="API Endpoints of Words"
 * )
 */
class WordController extends Controller
{
    protected $wordService;

    public function __construct(WordService $wordService)
    {
        $this->wordService = $wordService;
    }
    /**
     * @OA\Get(
     *     path="/words",
     *     summary="List all words",
     *     tags={"Words"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="List of all words",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="turkish", type="string"),
     *                 @OA\Property(property="english", type="string"),
     *                 @OA\Property(property="learning_status", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="datetime"),
     *                 @OA\Property(property="updated_at", type="string", format="datetime")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $words = $this->wordService->getAll();
        return WordResource::collection($words);
    }

    /**
     * @OA\Post(
     *     path="/words",
     *     summary="Create a new word",
     *     tags={"Words"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="turkish", type="string"),
     *             @OA\Property(property="english", type="string"),
     *             @OA\Property(property="learning_status", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Word created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="turkish", type="string"),
     *             @OA\Property(property="english", type="string"),
     *             @OA\Property(property="learning_status", type="string"),
     *             @OA\Property(property="created_at", type="string", format="datetime"),
     *             @OA\Property(property="updated_at", type="string", format="datetime")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreWordRequest $request)
    {
        $word = $this->wordService->create($request->validated());
        return new WordResource($word);
    }

    /**
     * @OA\Get(
     *     path="/words/{id}",
     *     summary="Get a specific word",
     *     tags={"Words"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Word ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Word details",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="turkish", type="string"),
     *             @OA\Property(property="english", type="string"),
     *             @OA\Property(property="learning_status", type="string"),
     *             @OA\Property(property="created_at", type="string", format="datetime"),
     *             @OA\Property(property="updated_at", type="string", format="datetime")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Word not found"
     *     )
     * )
     */
    public function show($id)
    {
        $word = $this->wordService->find($id);
        return new WordResource($word);
    }

    /**
     * @OA\Put(
     *     path="/words/{id}",
     *     summary="Update a specific word",
     *     tags={"Words"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Word ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="turkish", type="string"),
     *             @OA\Property(property="english", type="string"),
     *             @OA\Property(property="learning_status", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Word updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Word not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdateWordRequest $request, $id)
    {
        $word = $this->wordService->update($id, $request->validated());
        return new WordResource($word);
    }

    /**
     * @OA\Delete(
     *     path="/words/{id}",
     *     summary="Delete a specific word",
     *     tags={"Words"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Word ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Word deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Word not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $this->wordService->delete($id);
        return response()->json(['message' => 'Word deleted successfully']);
    }
}
