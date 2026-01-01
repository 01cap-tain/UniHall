<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venue extends Model
{
    use HasFactory;

    protected $table = 'venues';

    protected $fillable = [
        'user_id',
        'faculty_id',
        'name',
        'location',
        'features'
    ];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeByFaculty(Builder $query, int $facultyId): Builder
    {
        return $query->where('faculty_id', $facultyId);
    }

    public function getScheduleForDate(string $date): Collection
    {
        return $this->bookings()
            ->where('booking_date', $date)
            ->orderBy('start_time')
            ->get([
                'id',
                'booking_date',
                'start_time',
                'end_time',
                'user_id'
            ]);
    }
}
