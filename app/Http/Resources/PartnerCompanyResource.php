<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerCompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'logo_url'=>$this->logo_path ? asset('storage/' . $this->logo_path) : null,
            'industry'=>$this->industry,
            'status'=>$this->status,
            'partnership_date'=>$this->partnership_date?->toISOString(),
            'website'=>$this->website,
            'description'=>$this->description,
            'created_at'=>$this->created_at->toISOString(),
        ];
    }
}
