<?php

namespace App\Http\Controllers\ApiController\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoryRequest;
use App\Http\Requests\UpdateStoryRequest;
use App\Http\Resources\StoryResource;
use App\Services\StoryService;
use Illuminate\Http\Request;
/**
 * @OA\Tag(
 *     name="Stories",
 *     description="API Endpoints of Stories"
 * )
 */
class StoryController extends Controller
{
    protected $storyService;

    public function __construct(StoryService $storyService)
    {
        $this->storyService = $storyService;
    }

    /**
     * @OA\Get(
     *     path="/stories",
     *     summary="List all stories",
     *     tags={"Stories"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all stories",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="content", type="string"),
     *                 @OA\Property(property="current_page", type="integer"),
     *                 @OA\Property(property="created_at", type="string", format="datetime"),
     *                 @OA\Property(property="updated_at", type="string", format="datetime")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $stories = $this->storyService->getAll();
        return StoryResource::collection($stories);
    }

    /**
     * @OA\Post(
     *     path="/stories",
     *     summary="Create a new story",
     *     tags={"Stories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="current_page", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Story created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="current_page", type="integer"),
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
    public function store(StoreStoryRequest $request)
    {
        $story = $this->storyService->create($request->validated());
        return new StoryResource($story);
    }

    /**
     * @OA\Get(
     *     path="/stories/{id}",
     *     summary="Get a specific story",
     *     tags={"Stories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Story ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Story details",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(property="created_at", type="string", format="datetime"),
     *             @OA\Property(property="updated_at", type="string", format="datetime")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Story not found"
     *     )
     * )
     */
    public function show($id)
    {
        $story = $this->storyService->find($id);
        return new StoryResource($story);
    }

    /**
     * @OA\Put(
     *     path="/stories/{id}",
     *     summary="Update a specific story",
     *     tags={"Stories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Story ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="current_page", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Story updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Story not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdateStoryRequest $request, $id)
    {
        $story = $this->storyService->update($id, $request->validated());
        return new StoryResource($story);
    }

    /**
     * @OA\Delete(
     *     path="/stories/{id}",
     *     summary="Delete a specific story",
     *     tags={"Stories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Story ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Story deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Story not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $this->storyService->delete($id);
        return response()->json(['message' => 'Story deleted successfully']);
    }
}
