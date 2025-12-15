<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\ContactMessageStoreRequest;
use App\Http\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactMessageController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $messageQuery = ContactMessage::query()
            ->search($request->query('search'))
            ->status($request->query('status')) // unread|read
            ->orderByDesc('created_at')
            ->orderByDesc('id');

        $items = $messageQuery
            ->paginate($request->integer('per_page', 10))
            ->appends($request->query());

        return $this->ok(
            ContactMessageResource::collection($items),
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactMessageStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $message = ContactMessage::create($data);

        return $this->created(new ContactMessageResource($message), 'Pesan berhasil dikirim');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactMessage $contactMessage): JsonResponse
    {
        return $this->ok(new ContactMessageResource($contactMessage), 'OK');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactMessage $contactMessage): JsonResponse
    {
        $data = $request->validate([
            'status' => 'required|in:unread,read',
            'read_at' => 'sometimes|nullable|date',
        ]);

        // Otomatis set read_at jika status menjadi read dan belum dikirimkan
        if (($data['status'] ?? null) === 'read' && !array_key_exists('read_at', $data)) {
            $data['read_at'] = now();
        }

        // Jika dikembalikan ke unread, bersihkan read_at
        if (($data['status'] ?? null) === 'unread') {
            $data['read_at'] = null;
        }

        $contactMessage->update($data);
        return $this->ok(new ContactMessageResource($contactMessage), 'Status pesan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactMessage $contactMessage): JsonResponse
    {
        $contactMessage->delete();
        return $this->ok(null, 'Pesan berhasil dihapus');
    }
}
