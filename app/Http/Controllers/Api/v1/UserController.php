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

    public function __construct(UserRepository $repository){
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
}
