<?php

namespace BamboleeDigital\EventUserManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class RecurrencePattern extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = ['name', 'frequency_type', 'interval', 'days'];
    protected $translatable = ['name'];

    protected $casts = [
        'days' => 'array',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('event-user-manager.tables.recurrence_patterns', 'recurrence_patterns');
    }

    public function events(): HasMany
    {
        return $this->hasMany(config('event-user-manager.models.event'));
    }
}