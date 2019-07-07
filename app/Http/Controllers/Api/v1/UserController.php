<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserRepository;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @OA\Get(
     *     tags={"users"},
     *     summary="get all user",
     *     description="get all user on database and paginate then",
     *     path="/users",
     *     @OA\Response(
     *      response="200", description="List of users"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
     *         @OA\XmlContent(ref="#/components/schemas/ErrorModel"),
     *         @OA\MediaType(
     *             mediaType="text/xml",
     *             @OA\Schema(ref="#/components/schemas/ErrorModel")
     *         ),
     *         @OA\MediaType(
     *             mediaType="text/html",
     *             @OA\Schema(ref="#/components/schemas/ErrorModel")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return $this->repository->paginate();
    }

    /**
     * @OA\Post(
     *     tags={"users"},
     *     summary="store a user",
     *     description="store a new user on database",
     *     path="/users",
     *     @OA\RequestBody(
     *          required=true,
     *       @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="name", type="string"),
     *          @OA\Property(property="email", type="string"),
     *          @OA\Property(property="password", type="string"),
     *       )
     *     ),
     *     @OA\Response(
     *      response="201", description="New user created"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
     *         @OA\XmlContent(ref="#/components/schemas/ErrorModel"),
     *         @OA\MediaType(
     *             mediaType="text/xml",
     *             @OA\Schema(ref="#/components/schemas/ErrorModel")
     *         ),
     *         @OA\MediaType(
     *             mediaType="text/html",
     *             @OA\Schema(ref="#/components/schemas/ErrorModel")
     *         )
     *     )
     * )
     */
    public function store()
    {
        return $this->repository->create(request()->all());
    }
}
