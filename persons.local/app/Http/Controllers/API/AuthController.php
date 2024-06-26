<?php
declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Resources\UserTokenResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      description="Authentication enpoint description",
 *      title="Authentication enpoint title",
 *      @OA\Contact(
 *          email=""
 *      ),
 *     @OA\License(
 *         name="",
 *         url=""
 *     )
 * )
 *
 * @OA\Tag(
 *     name="Authentication",
 *     description="Everything about Authentication",
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url=""
 *     )
 * )
 *
 * @OA\ExternalDocumentation(
 *     description="Find out more about Swagger and OpenApi",
 *     url="https://swagger.io"
 * )
 *
 * @OA\Schema(
 *  schema="Message",
 *  title="Message Schema",
 * 	@OA\Property(
 * 		property="message",
 * 		type="string"
 * 	)
 * )
 *
 * @OA\Schema(
 *  schema="Token",
 *  title="Token Schema",
 * 	@OA\Property(
 *   property="data",
 *   type="object",
 *     @OA\Property(
 *          property="token",
 *          type="string"
 *     )
 * 	)
 * )
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/auth",
     *     tags={"Authentication"},
     *     summary="Autentificate a new user and return user tocken with one Of examples",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"email": "test@gmail.com", "password": "password"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(ref="#/components/schemas/AuthSucceeded"),
     *                 @OA\Schema(ref="#/components/schemas/AuthFailed"),
     *             },
     *                @OA\Examples(example="AuthSucceeded", value={
     *                    "access_token": "ey76Fdt5pRsOMoJ27f7AOiEjj66HYEZB"
     *                }, summary="An result token."),
     *             @OA\Examples(example="AuthFailed", value={ "message": "Invalid Credentials" }, summary="Login failed"),
     *         )
     *     )
     * )
     *
     * @OA\Schema(
     *  schema="AuthSucceeded",
     *  title="Sample schema for using references",
     * 	@OA\Property(
     *   property="data",
     *   type="object"
     * 	)
     * )
     *
     * @OA\Schema(
     *  schema="AuthFailed",
     *  title="Sample schema for using references",
     * 	@OA\Property(
     * 		property="message",
     * 		type="string"
     * 	)
     * )
     */
    public function auth(AuthRequest $request): JsonResponse
    {
        $validated = $request->safe()->only(['email','password']);

        $user = User::query()->where('email', $validated['email'])->first(); // can be used firstOrFail with try/catch

        if(!$user || !Hash::check($validated['password'], $user->password)){
            return response()->json(['message' => 'Invalid Credentials'],Response::HTTP_UNAUTHORIZED);
        }

        /** @var User $user */

        //remove all tokens and create & return new one token
        $user->tokens()?->delete();

        $token = $user->createToken(
            name: $user->name.'-AuthToken',
//            expiresAt: now()->addHours(4) // may be created cron task for renewing token each 4 hours
        )->plainTextToken;

        return (new UserTokenResource([
            'token' => $token,
        ]))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
