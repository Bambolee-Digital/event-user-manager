<?php

namespace BamboleeDigital\EventUserManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class EventNote extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'content'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('event-user-manager.tables.event_notes', 'event_notes');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(config('event-user-manager.models.event'));
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(config('event-user-manager.models.attachment'), 'attachable');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(config('event-user-manager.models.image'), 'imageable');
    }
}