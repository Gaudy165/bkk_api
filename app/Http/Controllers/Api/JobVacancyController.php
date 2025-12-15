<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\JobVacancyStoreRequest;
use App\Http\Requests\JobVacancyUpdateRequest;
use App\Http\Resources\JobVacancyResource;
use App\Models\JobVacancy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobVacancyController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $jobQuery = JobVacancy::query()
            ->search($request->query('search'))
            ->orderByDesc('date_posted')
            ->orderByDesc('id');

        $items = $jobQuery
            ->paginate($request->integer('per_page', 10))
            ->appends($request->query());

        return $this->ok(
            JobVacancyResource::collection($items),
            'OK',
            [
                'pagination' => [
                    'total' => $items->total(),
                    'per_page' => $items->perPage(),
                    'current_page' => $items->currentPage(),
                    'total_page' => $items->lastPage(),
                ]
            ]
        );
    }

    public function store(JobVacancyStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('job-vacancies', 'public');
        }

        $data['date_posted'] = now();
        $data['views'] = 0;

        $jobVacancy = JobVacancy::create($data);
        return $this->created([
            'id' => $jobVacancy->id,
        ], 'Lowongan berhasil dibuat');
    }

    public function show(JobVacancy $jobVacancy): JsonResponse
    {
        return $this->ok(new JobVacancyResource($jobVacancy), 'OK');
    }

    public function update(JobVacancyUpdateRequest $request, JobVacancy $jobVacancy): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($jobVacancy->image_path) {
                Storage::disk('public')->delete($jobVacancy->image_path);
            }
            $data['image_path'] = $request->file('image')->store('job-vacancies', 'public');
        }

        $jobVacancy->update($data);
        return $this->ok(new JobVacancyResource($jobVacancy->fresh()), 'Lowongan berhasil diperbarui');
    }

    public function destroy(JobVacancy $jobVacancy): JsonResponse
    {
        $jobVacancy->delete();
        return $this->ok(null, 'Lowongan berhasil dihapus');
    }
}
