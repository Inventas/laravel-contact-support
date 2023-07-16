<?php

namespace Inventas\ContactSupport\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Inventas\ContactSupport\Database\Factories\SupportCaseFactory;
use Inventas\ContactSupport\Events\SupportCaseCreated;

class SupportCase extends Model
{
    use HasFactory;

    protected $casts = [
        'extras' => 'array',
        'closed_at' => 'timestamp',
    ];

    protected $dispatchesEvents = [
        'created' => SupportCaseCreated::class,
    ];

    protected static function newFactory()
    {
        return SupportCaseFactory::new();
    }

    protected $guarded = ['id'];

    public function scopeClosed($query)
    {
        return $query->whereNotNull('closed_at');
    }

    public function scopeOpen($query)
    {
        return $query->whereNull('closed_at');
    }
}
