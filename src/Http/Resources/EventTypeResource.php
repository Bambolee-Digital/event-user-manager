<?php

namespace BamboleeDigital\EventUserManager\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class EventTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->getTranslation('name', app()->getLocale()),
            'icon' => $this->icon,
            'is_custom' => $this->is_custom,
            'user_id' => $this->when($this->is_custom, $this->user_id),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}