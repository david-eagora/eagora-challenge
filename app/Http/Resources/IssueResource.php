<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IssueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'title' => $this->title,
            'state' => $this->state,
            'user' => [
                'login' => $this->user['login'],
                'avatar_url' => $this->user['avatar_url'],
            ],
            'labels' => $this->labels,
            'created_at' => $this->created_at,
        ];
    }
}
