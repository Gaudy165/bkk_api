<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\JobApplicationStoreRequest;
use App\Http\Requests\JobApplicationUpdateRequest;
use App\Http\Resources\JobApplicationResource;
use App\Models\JobApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $applicationQuery = JobApplication::query()
            ->forJob($request->integer('job_vacancy_id'))
            ->status($request->query('status'))
            ->search($request->query('search'))
            ->orderByDesc('created_at')
            ->orderByDesc('id');

        $items = $applicationQuery
            ->paginate($request->integer('per_page', 10))
            ->appends($request->query());

        return $this->ok(
            JobApplicationResource::collection($items),
            'OK',
            [
                'pagination' => [
                    'total' => $items->total(),
                    'per_page' => $items->perPage(),
                    'current_page' => $items->currentPage(),
                    'total_page' => $items->lastPage(),
                ],
            ]
        );
    }

    public function store(JobApplicationStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data = $this->handleUploads($request, $data);

        $application = JobApplication::create($data);
        return $this->created([
            'id' => $application->id,
        ], 'Lamaran berhasil dikirim');
    }

    public function show(JobApplication $jobApplication): JsonResponse
    {
        return $this->ok(new JobApplicationResource($jobApplication), 'OK');
    }

    public function destroy(JobApplication $jobApplication): JsonResponse
    {
        $this->deleteUploads($jobApplication);
        $jobApplication->delete();

        return $this->ok(null, 'Lamaran berhasil dihapus');
    }

    private function handleUploads(Request $request, array $data, ?JobApplication $existing = null): array
    {
        $data['resume_path'] = $this->storeFile($request, 'resume', $existing?->resume_path);
        $data['certificate_path'] = $this->storeFile($request, 'certificate', $existing?->certificate_path);
        $data['photo_path'] = $this->storeFile($request, 'photo', $existing?->photo_path);
        $data['cover_letter_path'] = $this->storeFile($request, 'cover_letter', $existing?->cover_letter_path);

        unset($data['resume'], $data['certificate'], $data['photo'], $data['cover_letter']);

        return $data;
    }

    private function storeFile(Request $request, string $key, ?string $oldPath = null): ?string
    {
        if (!$request->hasFile($key)) {
            return $oldPath;
        }

        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $request->file($key)->store('job-applications', 'public');
    }

    private function deleteUploads(JobApplication $jobApplication): void
    {
        collect([
            $jobApplication->resume_path,
            $jobApplication->certificate_path,
            $jobApplication->photo_path,
            $jobApplication->cover_letter_path,
        ])->filter()->each(fn ($path) => Storage::disk('public')->delete($path));
    }
}
