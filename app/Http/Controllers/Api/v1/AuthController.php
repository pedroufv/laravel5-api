<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    /**
     * Get token JWT
     *
     * @OA\Post(
     *     tags={"auth"},
     *     summary="authenticate user by credentials",
     *     description="the user informs their credentials with email and password to get the access token",
     *     path="/login",
     *     @OA\RequestBody(
     *          required=true,
     *       @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="email", type="string"),
     *          @OA\Property(property="password", type="string"),
     *       )
     *     ),
     *     @OA\Response(
     *      response="200", description="Token JWT"
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
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }
}
