<?php

namespace BamboleeDigital\EventUserManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'event_type_id', 'recurrence_pattern_id', 'name', 'description',
        'start_date', 'end_date', 'duration_minutes', 'status', 'frequency_count', 'frequency_type'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    const FREQUENCY_TYPES = ['minute', 'hourly', 'daily', 'weekly', 'monthly', 'yearly'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('event-user-manager.tables.events', 'events');
    }

    public function getDurationAttribute()
    {
        $hours = $this->duration_hours ?? 0;
        $minutes = $this->duration_minutes ?? 0;
        return $hours * 60 + $minutes;
    }

    public function setDurationAttribute($value)
    {
        $this->attributes['duration_hours'] = floor($value / 60);
        $this->attributes['duration_minutes'] = $value % 60;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('event-user-manager.user_model'));
    }

    public function eventType(): BelongsTo
    {
        return $this->belongsTo(config('event-user-manager.models.event_type'));
    }

    public function recurrencePattern(): BelongsTo
    {
        return $this->belongsTo(config('event-user-manager.models.recurrence_pattern'));
    }

    public function notes(): HasMany
    {
        return $this->hasMany(config('event-user-manager.models.event_note'));
    }

    public function metadata(): HasMany
    {
        return $this->hasMany(config('event-user-manager.models.event_metadata'));
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(config('event-user-manager.models.attachment'), 'attachable');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(config('event-user-manager.models.image'), 'imageable');
    }

    public function generateRecurrences(Carbon $until)
    {
        if (!$this->recurrencePattern) {
            return;
        }

        $start = Carbon::parse($this->start_date);
        $end = $this->end_date ? Carbon::parse($this->end_date) : null;
        $duration = $end ? $end->diffInMinutes($start) : null;

        $dates = $this->getRecurrenceDates($start, $until);

        $maxInstances = config('event-user-manager.recurrence.max_instances', 100);
        $dates = array_slice($dates, 0, $maxInstances);

        foreach ($dates as $date) {
            $newEvent = $this->replicate()->fill([
                'start_date' => $date,
                'end_date' => $duration ? $date->copy()->addMinutes($duration) : null,
                'recurrence_pattern_id' => null,
            ]);
            $newEvent->save();
        }
    }

    private function getRecurrenceDates(Carbon $start, Carbon $until): array
    {
        $dates = [];
        $current = $start->copy();

        while ($current->lte($until)) {
            if ($this->isValidRecurrenceDate($current)) {
                $dates[] = $current->copy();
            }

            switch ($this->recurrencePattern->frequency_type) {
                case 'minute':
                    $current->addMinute();
                    break;
                case 'hourly':
                    $current->addHour();
                    break;
                case 'daily':
                    $current->addDay();
                    break;
                case 'weekly':
                    $current->addWeek();
                    break;
                case 'monthly':
                    $current->addMonth();
                    break;
                case 'yearly':
                    $current->addYear();
                    break;
            }

            // Verificar se atingimos o número máximo de ocorrências
            if ($this->frequency_count && count($dates) >= $this->frequency_count) {
                break;
            }
        }

        return $dates;
    }

    private function isValidRecurrenceDate(Carbon $date): bool
    {
        if ($this->recurrencePattern->frequency_type === 'weekly') {
            $dayName = strtolower($date->format('l'));
            $days = is_array($this->recurrencePattern->days) 
                ? $this->recurrencePattern->days 
                : json_decode($this->recurrencePattern->days, true);
            return in_array($dayName, $days);
        }

        // Para outros tipos de frequência, consideramos válido por padrão
        return true;
    }
}