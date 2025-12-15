<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\PartnerCompanyStoreRequest;
use App\Http\Requests\PartnerCompanyUpdateRequest;
use App\Http\Resources\PartnerCompanyResource;
use App\Models\PartnerCompany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerCompanyController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $partnerQuery = PartnerCompany::query()
            ->search($request->query('search'))
            ->status($request->query('status')) // active|inactive
            ->orderByDesc('partnership_date')
            ->orderByDesc('created_at')
            ->orderByDesc('id');

        $items = $partnerQuery
            ->paginate($request->integer('per_page', 10))
            ->appends($request->query());

        return $this->ok(
            PartnerCompanyResource::collection($items),
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

    public function store(PartnerCompanyStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('partner-companies', 'public');
        }

        $partnerCompany = PartnerCompany::create($data);
        return $this->created(new PartnerCompanyResource($partnerCompany), 'Perusahaan mitra berhasil ditambahkan');
    }

    public function update(PartnerCompanyUpdateRequest $request, PartnerCompany $partnerCompany): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            if ($partnerCompany->logo_path) {
                Storage::disk('public')->delete($partnerCompany->logo_path);
            }

            $data['logo_path'] = $request->file('logo')->store('partner-companies', 'public');
        }

        $partnerCompany->update($data);
        return $this->ok(new PartnerCompanyResource($partnerCompany), 'Perusahaan mitra berhasil diperbarui');
    }

    public function destroy(PartnerCompany $partnerCompany): JsonResponse
    {
        $partnerCompany->delete();
        return $this->ok(null, 'Perusahaan mitra berhasil dihapus');
    }
}
