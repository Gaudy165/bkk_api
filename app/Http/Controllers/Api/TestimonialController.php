<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\TestimonialStoreRequest;
use App\Http\Requests\TestimonialUpdateRequest;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $testimonialQuery = Testimonial::query()
            ->search($request->query('search'))
            ->status($request->query('status')) // published|unpublished|1|0
            ->orderByDesc('created_at')
            ->orderByDesc('id');

        $items = $testimonialQuery
            ->paginate($request->integer('per_page', 10))
            ->appends($request->query());

        return $this->ok(
            TestimonialResource::collection($items),
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

    public function store(TestimonialStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $data['avatar_path'] = $request->file('avatar')->store('testimonials', 'public');
        }

        $testimonial = Testimonial::create($data);
        return $this->created(new TestimonialResource($testimonial), 'Testimoni berhasil ditambahkan');
    }

    public function show(Testimonial $testimonial): JsonResponse
    {
        return $this->ok(new TestimonialResource($testimonial), 'OK');
    }

    public function update(TestimonialUpdateRequest $request, Testimonial $testimonial): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar_path) {
                Storage::disk('public')->delete($testimonial->avatar_path);
            }

            $data['avatar_path'] = $request->file('avatar')->store('testimonials', 'public');
        }

        $testimonial->update($data);
        return $this->ok(new TestimonialResource($testimonial), 'Testimoni berhasil diperbarui');
    }

    public function destroy(Testimonial $testimonial): JsonResponse
    {
        $testimonial->delete();
        return $this->ok(null, 'Testimoni berhasil dihapus');
    }
}
