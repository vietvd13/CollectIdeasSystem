<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-03-01
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\AuthResource;
use App\Services\Contracts\AuthServiceInterface;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{

     /**
     * var Repository
     */
    protected $service;

    public function __construct(AuthServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Info(
     *   title="Auth Api",
     *   version="v1"
     * ),
     * @OA\Post(
     *   path="/api/auth/login",
     *   tags={"Auth"},
     *   summary="Login by email and password",
     *   operationId="login",
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"status": 200,
     *   "data": {
     *       "token": "3|bWQR273WWwDSlClqhhAYzDj3GSyd1mZpQQlYcmmA",
     *       "profile": {
     *           "id": 1,
     *           "name": "Admin",
     *           "email": "admin@gmail.com",
     *           "email_verified_at": "2022-03-01T17:07:32.000000Z",
     *           "created_at": "2022-03-01T17:07:32.000000Z",
     *           "updated_at": "2022-03-01T17:07:32.000000Z",
     *          "roles": {
     *               {
     *                   "id": 4,
     *                   "name": "ADMIN",
     *                   "guard_name": "api",
     *                   "created_at": "2022-03-01T17:07:32.000000Z",
     *                   "updated_at": "2022-03-01T17:07:32.000000Z",
     *                   "pivot": {
     *                       "model_id": 1,
     *                       "role_id": 4,
     *                       "model_type": "App\\Models\\User"
     *                   }
     *               }
     *          }
     *       },
     *      "roles": {
     *           "ADMIN"
     *        }
     *  }}
     *     )
     *   ),
     * @OA\Response(
     *     response=403,
     *     description="Login false",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={
     *   "status": 403,
     *   "message": "message.error.unauthenticate",
     *   "internal_message": null,
     *   "data_error": null
     *   }
     *     )
     *   ),
     *   security={},
     * )
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function login(AuthRequest $request)
    {
        try {
            $login = $this->service->login($request->email, $request->password);
            if ($login['status'] == 200) {
                return $this->responseJson($login['status'], new AuthResource($login['data']));
            } else {
                return $this->responseJsonError($login['status'], $login['message']);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @OA\Get(
     *   path="/api/auth/user",
     *   tags={"Auth"},
     *   summary="Detail Auth",
     *   operationId="auth_show",
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={
     *    "status": 200,
     *   "data": {
     *       "profile": {
     *           "id": 1,
     *           "name": "Admin",
     *           "email": "admin@gmail.com",
     *           "email_verified_at": "2022-03-01T17:07:32.000000Z",
     *           "created_at": "2022-03-01T17:07:32.000000Z",
     *           "updated_at": "2022-03-01T17:07:32.000000Z",
     *           "roles": {
     *               {
     *                   "id": 4,
     *                   "name": "ADMIN",
     *                   "guard_name": "api",
     *                   "created_at": "2022-03-01T17:07:32.000000Z",
     *                   "updated_at": "2022-03-01T17:07:32.000000Z",
     *                  "pivot": {
     *                       "model_id": 1,
     *                       "role_id": 4,
     *                       "model_type": "App\\Models\\User"
     *                   }
     *               }
     *           }
     *       },
     *       "roles": {
     *           "ADMIN"
     *       }
     *   }
     *}
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Login false",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Username or password invalid"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(AuthRequest $request)
    {
        try {
            $auth = $this->service->authUser($request->user());
            if ($auth['status'] == 200) {
                return $this->responseJson($auth['status'], new AuthResource($auth['data']));
            } else {
                return $this->responseJsonError($auth['status'], $auth['message']);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
