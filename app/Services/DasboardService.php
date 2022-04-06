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
use Illuminate\Http\Client\Request;
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
        // Staff/manager: Xem 3 bài viết có lượt like và comment nhiều nhất, trả cho t tổng số lượt like,comment của 3 bài post đó
        // Admin: những chủ đề được mọi người quan tâm đóng góp ý kiến nhiều nhất(3 cái ) trả ra chủ đề và tổng bài viết trong chủ đề đó.
        // $this->ideaRepository->model->where('category_id' => $request->category_id)
    }

    public function chartWave() {

    }

    public function categoryByOwner($owner_id) {
        $categories = $this->categoryRepository->categoryByOwner($owner_id);
        return $categories;
    }
}
