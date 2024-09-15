<?php

namespace BamboleeDigital\EventUserManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class EventType extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = ['name', 'icon', 'is_custom', 'user_id'];
    protected $translatable = ['name'];

    protected $casts = [
        'is_custom' => 'boolean',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('event-user-manager.tables.event_types', 'event_types');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('event-user-manager.user_model'));
    }

    public function events(): HasMany
    {
        return $this->hasMany(config('event-user-manager.models.event'));
    }
}