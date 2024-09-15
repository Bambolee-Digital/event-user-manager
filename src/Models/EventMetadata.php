<?php

namespace BamboleeDigital\EventUserManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventMetadata extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'key', 'value'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('event-user-manager.tables.event_metadata', 'event_metadata');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(config('event-user-manager.models.event'));
    }
}