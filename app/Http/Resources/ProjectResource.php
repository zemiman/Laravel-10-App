<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\TaskResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            // 'tasks'=>TaskResource::collection($this->tasks),
            'tasks'=>TaskResource::collection($this->whenLoaded('tasks')),
            'members'=>TaskResource::collection($this->whenLoaded('members')),
            'createdAt'=>$this->created_at,
            'updatedAt'=>$this->updated_at,
        ];
    }
}
