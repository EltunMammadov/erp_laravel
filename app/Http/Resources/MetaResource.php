<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MetaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total' => $this->total(),
            'perPage' => $this->perPage(),
            'previousPageUrl' => $this->previousPageUrl(),
            'currentPage' => $this->currentPage(),
            'nextPageUrl' => $this->nextPageUrl(),
            'lastPage' => $this->lastPage()
        ];
    }
}
