<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-02-26
 */

namespace Service;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\IdeaRepositoryInterface;
use App\Services\Contracts\DasboardServiceInterface;
class DasboardService extends BaseService implements DasboardServiceInterface
{

    protected $categoryRepository;
    protected $ideaRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository, IdeaRepositoryInterface $ideaRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->ideaRepository = $ideaRepository;
    }

    public function chartDonut($request) {
        $userDepartment = $request->user()->department_id;
        if ($request->user()->getRoleNames() == ROLES['ADMIN']) {
            $data = $this->ideaRepository->dataChartDonut($request->category_id, $request->limit, $userDepartment);
            return $data;
        } else {
            $data = $this->categoryRepository->dataChartDonut($request->limit, $userDepartment);
            return $data;
        }
    }

    public function chartCollumns($request) {
        $userDepartment = $request->user()->department_id;
        $data = $this->categoryRepository->dataChartDonut($request->limit, $userDepartment);
        return $data;
    }

    public function total($request) {
        $userDepartment = $request->user()->department_id;
        $total = $this->ideaRepository->total($userDepartment);
        return [
            'total_category' => $this->categoryRepository->countInDepartment($userDepartment),
            'total_idea' => $this->ideaRepository->countInDepartment($userDepartment),
            'total_likes' => $total['total_like'],
            'total_dislike' => $total['total_dislike'],
            'total_comment' => $total['total_comment']
        ];
    }

    public function categoryByOwner($owner_id) {
        $categories = $this->categoryRepository->categoryByOwner($owner_id);
        return $categories;
    }
}
