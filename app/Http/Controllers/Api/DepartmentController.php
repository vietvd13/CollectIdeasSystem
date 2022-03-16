<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-03-16
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Services\Contracts\DepartmentServiceInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\DepartmentResource;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

     /**
     * var Repository
     */
    protected $service;

    public function __construct(DepartmentServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *   path="/api/department",
     *   tags={"Department"},
     *   summary="List department",
     *   operationId="department_index",
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={
     *       "status": 200,
     *       "data": {
     *           "current_page": 1,
     *           "data": {
     *               {
     *                   "id": 2,
     *                   "name": "IT Ha Noi uPDATE",
     *                   "deleted_at": null,
     *                   "created_at": "2022-03-16T15:28:38.000000Z",
     *                   "updated_at": "2022-03-16T15:31:41.000000Z"
     *               },
     *               {
     *                   "id": 3,
     *                   "name": "Marketing",
     *                   "deleted_at": null,
     *                   "created_at": "2022-03-16T15:28:38.000000Z",
     *                   "updated_at": "2022-03-16T15:28:38.000000Z"
     *               },
     *               {
     *                   "id": 4,
     *                   "name": "Security",
     *                   "deleted_at": null,
     *                   "created_at": "2022-03-16T15:28:38.000000Z",
     *                   "updated_at": "2022-03-16T15:28:38.000000Z"
     *               }
     *           },
     *           "first_page_url": "http://127.0.0.1:8000/api/department?page=1",
     *           "from": 1,
     *           "last_page": 1,
     *           "last_page_url": "http://127.0.0.1:8000/api/department?page=1",
     *           "links": {
     *               {
     *                   "url": null,
     *                   "label": "&laquo; Previous",
     *                   "active": false
     *               },
     *               {
     *                   "url": "http://127.0.0.1:8000/api/department?page=1",
     *                   "label": "1",
     *                   "active": true
     *               },
     *               {
     *                   "url": null,
     *                   "label": "Next &raquo;",
     *                   "active": false
     *               }
     *           },
     *           "next_page_url": null,
     *           "path": "http://127.0.0.1:8000/api/department",
     *           "per_page": 15,
     *           "prev_page_url": null,
     *           "to": 3,
     *           "total": 3
     *       }
     *   }
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
     *      example={"code":401,"message":"Username or password invalid"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(DepartmentRequest $request)
    {
        $data = $this->service->paginate($request->per_page);
        return $this->responseJson(200, new DepartmentResource($data));
    }

    /**
     * @OA\Post(
     *   path="/api/department",
     *   tags={"Department"},
     *   summary="Add new department",
     *   operationId="department_create",
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
    public function store(DepartmentRequest $request)
    {
        try {
            $data = $this->service->create($request->all());
            return $this->responseJson(200, new DepartmentResource($data));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @OA\Get(
     *   path="/api/department/{id}",
     *   tags={"Department"},
     *   summary="Detail Department",
     *   operationId="department_show",
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
     *      example={"code":200,"data":{"id": 1,"name":"......"}}
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
            $department = $this->service->find($id);
            return $this->responseJson(200, new BaseResource($department));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @OA\Put(
     *   path="/api/department/{id}",
     *   tags={"Department"},
     *   summary="Update Department",
     *   operationId="department_update",
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
    public function update(DepartmentRequest $request, $id)
    {
        $attributes = $request->except([]);
        $data = $this->service->update($attributes, $id);
        return $this->responseJson(200, new BaseResource($data));
    }

    /**
     * @OA\Delete(
     *   path="/api/department/{id}",
     *   tags={"Department"},
     *   summary="Delete Department",
     *   operationId="department_delete",
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
        $this->service->delete($id);
        return $this->responseJson(200, null, trans('messages.mes.delete_success'));
    }
}
