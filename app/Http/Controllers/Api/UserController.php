<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-03-01
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Services\Contracts\UserServiceInterface;
class UserController extends Controller
{

     /**
     * var Repository
     */
    protected $service;

    public function __construct(UserServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Infor(),
     * @OA\Get(
     *   path="/api/users",
     *   tags={"User"},
     *   summary="List user",
     *   operationId="user_index",
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{{"id": 1,"name": "..........."}}}
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="page",
     *     in="query",
     *     @OA\Schema(
     *      type="integer",
     *     ),
     *   ),
     *   @OA\Parameter(
     *     name="per_page",
     *     in="query",
     *     @OA\Schema(
     *      type="integer",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Login false",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={
     *   "status": 200,
     *   "data": {
     *       {
     *           "id": 1,
     *           "name": "Admin",
     *           "email": "admin@gmail.com",
     *           "birth": "2000-05-27",
     *           "created_at": "2022-03-08T06:23:13.000000Z",
     *           "updated_at": "2022-03-08T06:23:13.000000Z",
     *           "roles": {
     *               {
     *                   "id": 1,
     *                   "name": "QAM",
     *                   "guard_name": "api",
     *                   "created_at": "2022-03-08T06:23:13.000000Z",
     *                   "updated_at": "2022-03-08T06:23:13.000000Z",
     *                   "pivot": {
     *                       "model_id": 1,
     *                       "role_id": 1,
     *                       "model_type": "App\\Models\\User"
     *                   }
     *               }
     *           }
     *       },
     *       {
     *           "id": 2,
     *           "name": "QAM",
     *           "email": "aqm@gmail.com",
     *           "birth": "2000-05-27",
     *           "created_at": "2022-03-08T06:23:13.000000Z",
     *           "updated_at": "2022-03-08T06:23:13.000000Z",
     *           "roles": {
     *               {
     *                   "id": 1,
     *                   "name": "QAM",
     *                   "guard_name": "api",
     *                   "created_at": "2022-03-08T06:23:13.000000Z",
     *                   "updated_at": "2022-03-08T06:23:13.000000Z",
     *                   "pivot": {
     *                       "model_id": 2,
     *                       "role_id": 1,
     *                       "model_type": "App\\Models\\User"
     *                   }
     *               }
     *           }
     *       },
     *       {
     *           "id": 3,
     *           "name": "QAC",
     *           "email": "aqc@gmail.com",
     *           "birth": "2000-05-27",
     *           "created_at": "2022-03-08T06:23:13.000000Z",
     *           "updated_at": "2022-03-08T06:23:13.000000Z",
     *           "roles": {
     *               {
     *                   "id": 2,
     *                   "name": "QAC",
     *                   "guard_name": "api",
     *                   "created_at": "2022-03-08T06:23:13.000000Z",
     *                   "updated_at": "2022-03-08T06:23:13.000000Z",
     *                   "pivot": {
     *                       "model_id": 3,
     *                       "role_id": 2,
     *                       "model_type": "App\\Models\\User"
     *                   }
     *               }
     *           }
     *       },
     *       {
     *           "id": 4,
     *           "name": "STAFF",
     *           "email": "staff@gmail.com",
     *           "birth": "2000-05-27",
     *           "created_at": "2022-03-08T06:23:13.000000Z",
     *           "updated_at": "2022-03-08T06:23:13.000000Z",
     *           "roles": {
     *               {
     *                   "id": 3,
     *                   "name": "STAFF",
     *                   "guard_name": "api",
     *                   "created_at": "2022-03-08T06:23:13.000000Z",
     *                   "updated_at": "2022-03-08T06:23:13.000000Z",
     *                   "pivot": {
     *                       "model_id": 4,
     *                       "role_id": 3,
     *                       "model_type": "App\\Models\\User"
     *                   }
     *               }
     *           }
     *       },
     *       {
     *           "id": 7,
     *           "name": "Admin",
     *           "email": "admin12@gmail.com",
     *           "birth": "2000-05-27",
     *           "created_at": "2022-03-08T13:12:58.000000Z",
     *           "updated_at": "2022-03-08T13:12:58.000000Z",
     *           "roles": {
     *               {
     *                   "id": 1,
     *                   "name": "QAM",
     *                   "guard_name": "api",
     *                   "created_at": "2022-03-08T06:23:13.000000Z",
     *                   "updated_at": "2022-03-08T06:23:13.000000Z",
     *                   "pivot": {
     *                       "model_id": 7,
     *                       "role_id": 1,
     *                       "model_type": "App\\Models\\User"
     *                   }
     *               }
     *           }
     *       },
     *       {
     *           "id": 9,
     *           "name": "Admin",
     *           "email": "admin132@gmail.com",
     *           "birth": "2000-05-27",
     *           "created_at": "2022-03-08T13:14:52.000000Z",
     *           "updated_at": "2022-03-08T13:14:52.000000Z",
     *           "roles": {
     *               {
     *                   "id": 1,
     *                   "name": "QAM",
     *                   "guard_name": "api",
     *                   "created_at": "2022-03-08T06:23:13.000000Z",
     *                   "updated_at": "2022-03-08T06:23:13.000000Z",
     *                   "pivot": {
     *                       "model_id": 9,
     *                       "role_id": 1,
     *                       "model_type": "App\\Models\\User"
     *                   }
     *               }
     *           }
     *       }
     *   }
     *   }
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UserRequest $request)
    {
       //return $request->per_page;
        $data = $this->service->paginate($request->per_page);
        return $this->responseJson(200, UserResource::collection($data));
    }

    /**
     * @OA\Infor(),
     * @OA\Post(
     *   path="/api/users",
     *   tags={"User"},
     *   summary="Add new user",
     *   operationId="user_create",
     * @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          example={
     *       "name": "Nguyen Nam 2222",
     *       "email": "namnt@gmail.com",
     *       "password": "paSSWORD",
     *       "birth": "2000-05-27",
     *       "role": 2
     *   },
     *        @OA\Schema(
     *            required={},
     *            @OA\Property(
     *              property="name",
     *              format="string",
     *            ),
     *         )
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"status":200}
     *     )
     *   ),
     *   security={},
     * )
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(UserRequest $request)
    {
        try {
            $data = $this->service->create($request->all());
            return $this->responseJson($data['status'], new UserResource($data['data']));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @OA\Infor(),
     * @OA\Get(
     *   path="/api/users/{id}",
     *   tags={"User"},
     *   summary="Detail User",
     *   operationId="user_show",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={
     *        "status": 200,
     *       "data": {
     *               "id": 1,
     *               "name": "Admin",
     *               "email": "admin@gmail.com",
     *               "email_verified_at": "2022-03-01T17:07:32.000000Z",
     *               "created_at": "2022-03-01T17:07:32.000000Z",
     *               "updated_at": "2022-03-01T17:07:32.000000Z",
     *               "roles": {
     *                   {
     *                       "id": 4,
     *                       "name": "ADMIN",
     *                       "guard_name": "api",
     *                       "created_at": "2022-03-01T17:07:32.000000Z",
     *                       "updated_at": "2022-03-01T17:07:32.000000Z",
     *                       "pivot": {
     *                           "model_id": 1,
     *                           "role_id": 4,
     *                           "model_type": "App\\Models\\User"
     *                       }
     *                   }
     *               }
     *       }
     *   }
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Login false",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"status":401,"message":"Username or password invalid"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $user = $this->service->find($id);
            return $this->responseJson($user['status'], new UserResource($user['profile']));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @OA\Infor(),
     * @OA\Put(
     *   path="/api/users/{id}",
     *   tags={"User"},
     *   summary="Update User",
     *   operationId="user_update",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
      * @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          example={
     *       "name": "Nguyen Nam 2222",
     *       "new_password": "new_paSSWORD",
     *       "birth": "2000-05-27",
     *       "role": 2
     *   },
     *        @OA\Schema(
     *            required={},
     *            @OA\Property(
     *              property="name",
     *              format="string",
     *            ),
     *         )
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"status":200}
     *     ),
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Access Deny permission",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"status":403,"message":"Access Deny permission"}
     *     ),
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, $id)
    {
        $attributes = $request->except([]);
        $data = $this->service->update($attributes, $id);
        return $this->responseJson(200, new BaseResource($data));
    }

    /**
     * @OA\Infor(),
     * @OA\Delete(
     *   path="/api/users/{id}",
     *   tags={"User"},
     *   summary="Delete User",
     *   operationId="user_delete",
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"status":200}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->service->delete($id);
        return $this->responseJson(200, null, trans('messages.mes.delete_success'));
    }


    /**
     * @OA\Infor(),
     * @OA\Get(
     *   path="/api/roles",
     *   tags={"Role"},
     *   summary="List Roles",
     *   operationId="user_roles",
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={
     *       {
     *           "id": 1,
     *           "name": "QAM",
     *           "guard_name": "api",
     *           "created_at": "2022-03-05T18:01:41.000000Z",
     *           "updated_at": "2022-03-05T18:01:41.000000Z"
     *       },
     *       {
     *           "id": 2,
     *           "name": "QAC",
     *           "guard_name": "api",
     *           "created_at": "2022-03-05T18:01:41.000000Z",
     *           "updated_at": "2022-03-05T18:01:41.000000Z"
     *       },
     *       {
     *           "id": 3,
     *           "name": "STAFF",
     *           "guard_name": "api",
     *           "created_at": "2022-03-05T18:01:41.000000Z",
     *           "updated_at": "2022-03-05T18:01:41.000000Z"
     *       },
     *       {
     *           "id": 4,
     *           "name": "ADMIN",
     *           "guard_name": "api",
     *           "created_at": "2022-03-05T18:01:41.000000Z",
     *           "updated_at": "2022-03-05T18:01:41.000000Z"
     *       }
     *   }
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Login false",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"status": 403}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function roles() {
        return Role::all();
    }
}
