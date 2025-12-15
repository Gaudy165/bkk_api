<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\NewsStoreRequest;
use App\Http\Requests\NewsUpdateRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $newsQuery = News::with('category')
            ->search($request->query('search'))
            ->status($request->query('status')) // draft|published
            ->categorySlug($request->query('category')) // slug kategori
            ->orderByDesc('published_at')
            ->orderByDesc('id');

        $items = $newsQuery
            ->paginate($request->integer('per_page', 10))
            ->appends($request->query());

        return $this->ok(
            NewsResource::collection($items),
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

    public function store(NewsStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $request->file('thumbnail')->store('news', 'public');
        }

        $news = News::create($data);
        return $this->created(new NewsResource($news), 'Berita berhasil dibuat');
    }

    public function show(News $news): JsonResponse
    {
        return $this->ok(new NewsResource($news->load('category')));
    }

    public function update(NewsUpdateRequest $request, News $news): JsonResponse
    {
        $data = $request->validated();

        if (!empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }


        if ($request->hasFile('thumbnail')) {
            if ($news->thumbnail_path) {
                Storage::disk('public')->delete($news->thumbnail_path);
            }

            $data['thumbnail_path'] = $request->file('thumbnail')->store('news', 'public');
        }

        $news->update($data);
        return $this->ok(new NewsResource($news->fresh('category')), 'Berita berhasil diperbarui');
    }

    public function destroy(News $news): JsonResponse
    {
        $news->delete();
        return $this->ok(null, 'Berita berhasil dihapus');
    }
}
