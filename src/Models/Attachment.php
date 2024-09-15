<?php

namespace BamboleeDigital\EventUserManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['file_path', 'file_name', 'file_type'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('event-user-manager.tables.attachments', 'attachments');
    }

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }
}