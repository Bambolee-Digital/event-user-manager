<?php

namespace BamboleeDigital\EventUserManager\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecurrencePatternResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->getTranslation('name', app()->getLocale()),
            'frequency_type' => $this->frequency_type,
            'interval' => $this->interval,
            'days' => $this->days,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}