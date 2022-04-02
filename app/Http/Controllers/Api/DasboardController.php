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
        return $this->service->chartDonut($request->category_id);
    }
}
