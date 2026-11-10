<?php

namespace App\Models;

use App\Services\SlugService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    protected $fillable = [
        'name',
        'code',
        'address',
        'city',
        'state',
        'zip',
        'unit_count',
        'property_type',
        'status',
        'notes',
        'slug',
    ];

    protected static function booted(): void
    {
        static::creating(function (Property $property) {
            if (blank($property->slug)) {
                $property->slug = app(SlugService::class)->unique($property->name, 'properties');
            }
        });
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function jobTickets(): HasMany
    {
        return $this->hasMany(JobTicket::class);
    }
}
