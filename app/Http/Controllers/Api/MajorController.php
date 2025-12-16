<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Models\Major;
use Illuminate\Http\JsonResponse;

class MajorController extends ApiController
{
    public function publicIndex(): JsonResponse
    {
        $majors = Major::query()
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        return $this->ok($majors, 'OK');
    }
}
