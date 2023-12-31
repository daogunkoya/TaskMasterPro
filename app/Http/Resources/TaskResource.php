<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'task_id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'project_id' => $this->deadline,
            'created_at' => $this->created_at,
        ];
    }
}
