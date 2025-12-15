<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\GalleryStoreRequest;
use App\Http\Requests\GalleryUpdateRequest;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $galleryQuery = Gallery::query()
            ->search($request->query('search'))
            ->status($request->query('status')) // published|unpublished|1|0
            ->orderByDesc('created_at')
            ->orderByDesc('id');

        $items = $galleryQuery
            ->paginate($request->integer('per_page', 10))
            ->appends($request->query());

        return $this->ok(
            GalleryResource::collection($items),
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(GalleryStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('galleries', 'public');
        }

        $gallery = Gallery::create($data);
        return $this->created(new GalleryResource($gallery), 'Galeri berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery): JsonResponse
    {
        return $this->ok(new GalleryResource($gallery), 'OK');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GalleryUpdateRequest $request, Gallery $gallery): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($gallery->image_path) {
                Storage::disk('public')->delete($gallery->image_path);
            }

            $data['image_path'] = $request->file('image')->store('galleries', 'public');
        }

        $gallery->update($data);
        return $this->ok(new GalleryResource($gallery), 'Galeri berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery): JsonResponse
    {
        $gallery->delete();
        return $this->ok(null, 'Galeri berhasil dihapus');
    }
}
