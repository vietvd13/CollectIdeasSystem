<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-03-07
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\Contracts\CategoryServiceInterface;
class CategoryController extends Controller
{

     /**
     * var Repository
     */
    protected $service;

    public function __construct(CategoryServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *   path="/api/category",
     *   tags={"Category"},
     *   summary="List category",
     *   operationId="category_index",
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
     *                   "topic_name": "Topic name deo gi dai the",
     *                   "description": "All member, please note your idea here before 2022-11-11",
     *                   "owner": 1,
     *                   "start_collect_date": "2022-10-01 19:00:00",
     *                   "end_collect_date" : "2022-11-11",
     *                   "created_at": "2022-03-07T05:51:17.000000Z",
     *                   "updated_at": "2022-03-07T05:51:17.000000Z",
     *                  "user": {
     *                       "id": 1,
     *                       "name": "Admin",
     *                       "email": "admin@gmail.com",
     *                       "birth": "2000-05-27",
     *                       "created_at": "2022-03-08T06:23:13.000000Z",
     *                       "updated_at": "2022-03-08T06:23:13.000000Z"
     *                   }
     *               }
     *           },
     *           "first_page_url": "http://127.0.0.1:8000/api/category?page=1",
     *           "from": 1,
     *           "last_page": 1,
     *           "last_page_url": "http://127.0.0.1:8000/api/category?page=1",
     *           "links": {
     *               {
     *                   "url": null,
     *                   "label": "&laquo; Previous",
     *                   "active": false
     *                },
     *               {
     *                   "url": "http://127.0.0.1:8000/api/category?page=1",
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
     *           "path": "http://127.0.0.1:8000/api/category",
     *           "per_page": 15,
     *           "prev_page_url": null,
     *           "to": 1,
     *           "total": 1
     *       }
     *  }
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
    public function index(CategoryRequest $request)
    {
        $data = $this->service->paginate($request->per_page);
        return $this->responseJson(200, new CategoryResource($data));
    }

    /**
     * @OA\Post(
     *   path="/api/category",
     *   tags={"Category"},
     *   summary="Add new category",
     *   operationId="category_create",
     * @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          example={
     *       "topic_name": "name",
     *       "description": "description",
     *       "start_collect_date": "2022-11-11",
     *       "end_collect_date": "2023-01-01"
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
     *      example={"code":200,"data":{"id": 1,"name": "......"}}
     *     )
     *   ),
     *   security={},
     * )
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(CategoryRequest $request)
    {
        try {
            $attributes = $request->all();
            $attributes = array_merge($attributes, ["owner" => $request->user()->id]);
            $data = $this->service->create($attributes);
            return $this->responseJson(200, new CategoryResource($data));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @OA\Get(
     *   path="/api/category/{id}",
     *   tags={"Category"},
     *   summary="Detail Category",
     *   operationId="category_show",
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
            return $this->responseJson(200, new CategoryResource($department));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @OA\Put(
     *   path="/api/category/{id}",
     *   tags={"Category"},
     *   summary="Update Category",
     *   operationId="category_update",
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
     *       "topic_name": "name",
     *       "description": "description",
     *       "start_collect_date": "2022-11-11",
     *       "end_collect_date": "2023-01-01"
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
    public function update(CategoryRequest $request, $id)
    {
        $attributes = $request->all();
        $attributes = array_merge($attributes, ["owner" => $request->user()->id]);
        $data = $this->service->update($attributes, $id);
        return $this->responseJson(200, new CategoryResource($data));
    }

    /**
     * @OA\Delete(
     *   path="/api/category/{id}",
     *   tags={"Category"},
     *   summary="Delete Category",
     *   operationId="category_delete",
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
