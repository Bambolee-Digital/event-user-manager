<?php

namespace BamboleeDigital\EventUserManager\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'event_type' => new EventTypeResource($this->eventType),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'duration' => [
                'hours' => $this->duration_hours,
                'minutes' => $this->duration_minutes,
            ],
            'status' => $this->status,
            'recurrence_pattern' => $this->when($this->recurrencePattern, new RecurrencePatternResource($this->recurrencePattern)),
            'frequency_count' => $this->frequency_count,
            'frequency_type' => $this->frequency_type,
            'notes' => EventNoteResource::collection($this->whenLoaded('notes')),
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'metadata' => EventMetadataResource::collection($this->whenLoaded('metadata')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}