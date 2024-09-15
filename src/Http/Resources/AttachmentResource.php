<?php

namespace BamboleeDigital\EventUserManager\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'file_path' => $this->file_path,
            'file_name' => $this->file_name,
            'file_type' => $this->file_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}