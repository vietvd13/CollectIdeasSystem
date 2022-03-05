<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-03-01
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
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
     * "status": 200,
     * "data": {
     *    "current_page": 1,
     *  "data": {
     *       {
     *          "id": 1,
     *           "name": "Admin",
     *           "email": "admin@gmail.com",
     *           "email_verified_at": "2022-03-01T17:07:32.000000Z",
     *           "created_at": "2022-03-01T17:07:32.000000Z",
     *           "updated_at": "2022-03-01T17:07:32.000000Z"
     *       },
     *       {
     *           "id": 2,
     *           "name": "QAM",
     *           "email": "aqm@gmail.com",
     *           "email_verified_at": "2022-03-01T17:07:32.000000Z",
     *           "created_at": "2022-03-01T17:07:32.000000Z",
     *           "updated_at": "2022-03-01T17:07:32.000000Z"
     *       },
     *       {
     *           "id": 3,
     *           "name": "QAC",
     *           "email": "aqc@gmail.com",
     *           "email_verified_at": "2022-03-01T17:07:32.000000Z",
     *           "created_at": "2022-03-01T17:07:32.000000Z",
     *           "updated_at": "2022-03-01T17:07:32.000000Z"
     *       },
     *       {
     *           "id": 4,
     *           "name": "STAFF",
     *           "email": "staff@gmail.com",
     *           "email_verified_at": "2022-03-01T17:07:32.000000Z",
     *           "created_at": "2022-03-01T17:07:32.000000Z",
     *           "updated_at": "2022-03-01T17:07:32.000000Z"
     *       }
     *   },
     *   "first_page_url": "http://127.0.0.1:8000/api/users?per_page=10&page=1",
     *   "from": 1,
     *   "last_page": 1,
     *   "last_page_url": "http://127.0.0.1:8000/api/users?per_page=10&page=1",
     *   "links": {
     *       {
     *           "url": null,
     *           "label": "&laquo; Previous",
     *           "active": false
     *       },
     *       {
     *           "url": "http://127.0.0.1:8000/api/users?per_page=10&page=1",
     *           "label": "1",
     *           "active": true
     *       },
     *       {
     *           "url": null,
     *           "label": "Next &raquo;",
     *           "active": false
     *       }
     *   },
     *   "next_page_url": null,
     *   "path": "http://127.0.0.1:8000/api/users",
     *   "per_page": "10",
     *   "prev_page_url": null,
     *   "to": 4,
     *   "total": 4
     * }
     * }
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
        return $this->responseJson(200, new UserResource($data));
    }

    /**
     * @OA\Infor(),
     * @OA\Post(
     *   path="/api/users",
     *   tags={"User"},
     *   summary="Add new user",
     *   operationId="user_create",
     *   @OA\Parameter(name="name", in="query", required=true,
     *     @OA\Schema(type="string"),
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"id": 1,"name": "......"}}
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
            $data = $this->repository->create($request->all());
            return $this->responseJson(200, new UserResource($data));
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
     *           "status": 200,
     *           "profile": {
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
     *           },
     *           "roles": {
     *               "ADMIN"
     *           }
     *       }
     *   }
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
    public function show($id)
    {
        try {
            $user = $this->service->find($id);
            return $this->responseJson(200, new UserResource($user));
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
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          example={"name":"string"},
     *          @OA\Schema(
     *            required={"name"},
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
     *      example={"code":200,"data":{"id": 1,"name":  "............."}}
     *     ),
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Access Deny permission",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":403,"message":"Access Deny permission"}
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
        $data = $this->repository->update($attributes, $id);
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
     *      example={"code":200,"data":"Send request success"}
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
        $this->repository->delete($id);
        return $this->responseJson(200, null, trans('messages.mes.delete_success'));
    }
}
