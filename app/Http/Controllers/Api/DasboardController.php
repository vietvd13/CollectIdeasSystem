<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Contracts\DasboardServiceInterface;
class DasboardController extends Controller
{
    protected $service;
    function __construct(DasboardServiceInterface $service) {
        $this->service = $service;
    }

    public function categoriesByOwner(Request $request) {
        return $this->service->categoryByOwner($request->user()->id);
    }

    public function chartDonut(Request $request) {
        return $this->service->chartDonut($request);
    }

    public function total(Request $request) {
        return $this->service->total($request);
    }

    public function exportCategory(Request $request) {
        return $this->service->exportCategory($request->category_id);
    }

    public function downloadAttatchFiles(Request $request) {
        return $this->service->downloadAttatchFiles($request->idea_id);
    }
}
