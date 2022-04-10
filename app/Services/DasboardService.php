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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IdeaExport;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
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

    public function exportCategory(int $category_id) {
        $csvContents = [];
        $cate = $this->categoryRepository->find($category_id);
        $headers = [
            "category_id",
            "category_topic",
            "idea_id",
            "idea_contents",
            "download_attatch_file"
        ];
        $csvContents[] = $headers;
        $ideas = $this->categoryRepository->ideaInCategory($category_id);
        $row = [];
        foreach ($ideas as $key => $idea) {
            $row[] = [
                $cate->id,
                $cate->topic_name,
                $idea->id,
                $idea->contents,
                env('APP_URL') . "/api/idea/download?idea_id=" . $idea->id
            ];
            $csvContents[] = $row;
        }

        return Excel::download(new IdeaExport($csvContents), "category.xlsx");
    }

    public function downloadAttatchFiles($idea_id) {
        if(!Storage::exists("export")) {
            Storage::makeDirectory("export");
        }
        $zip_file = 'ideaAttatchFile.zip';
        $zip = new ZipArchive();
        $zip->open(Storage::path("export" . '/' . $zip_file), ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $idea = $this->ideaRepository->find($idea_id);
        foreach ($idea->files as $key => $file) {
            $path = Storage::path($file->path);
            $zip->addFile($path, str_replace("ideafiles/", "", $file->path));
        }
        $zip->close();
        return response()->download(Storage::path("export" . '/' . $zip_file));
    }
}
