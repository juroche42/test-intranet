<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use OpenApi\Annotations as OA;

use App\Traits\FiltersTrait;

class UserController extends Controller
{

    use FiltersTrait;
    /**
     * @OA\Get(
     *     path="/users",
     *     tags={"Users"},
     *     summary="Get all users",
     *     description="Get all users",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = User::with('services:name')
            ->select(['id','prenom', 'nom', 'poste']);

        $users = $this->applyFilters($request, $query);
        return response()->json($users);
    }


    /**
     * @OA\Put(
     *     path="/users/{userId}",
     *     tags={"Users"},
     *     summary="Update a user",
     *     description="Update a user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     * *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="ID of user to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     ),
     * *   @OA\Response(
     *         response=404,
     *         description="User not found",
     *        @OA\JsonContent(
     *            type="object",
     *            @OA\Property(property="error", type="string")
     *       )
     *     )
     * )
     */
    public function update(Request $request, int $userId)
    {
        $validator = Validator::make($request->all(), [
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'poste' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'statut' => 'required|int|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->update($request->all());

        return response()->json($user, 200);
    }

    /**
     * @OA\Delete(
     *     path="/users/{userId}",
     *     tags={"Users"},
     *     summary="Delete a user",
     *     description="Delete a user",
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="ID of user to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *        @OA\JsonContent(
     *            type="object",
     *            @OA\Property(property="error", type="string")
     *       )
     *     )
     * )
     */
    public function delete(int $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted'], 200);
    }
}
