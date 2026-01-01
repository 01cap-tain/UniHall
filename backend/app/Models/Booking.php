<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'venue_id',
        'booking_date',
        'start_time',
        'end_time',
        'purpose',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function venues(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function scopeByVenue(Builder $query, int $venueId): Builder
    {
        return $query->where('venue_id', $venueId);
    }

    public function scopeByDate(Builder $query, string $date): Builder
    {
        return $query->where('booking_date', $date);
    }

    public function scopeByUser(Builder $query, int $user): Builder
    {
        return $query->where('user_id', $user);
    }

    public static function isAvailable($venueId, $date, $startTime, $endTime, $ignoreBookingId = null)
    {
        $query = self::where('venue_id', $venueId)
            ->where('booking_date', $date)
            // The conflict condition: New start time is BEFORE existing end time
            ->where('start_time', '<', $endTime)
            // AND New end time is AFTER existing start time
            ->where('end_time', '>', $startTime);

        // Allow ignoring an existing booking ID (useful for updates/edits)
        if ($ignoreBookingId) {
            $query->where('id', '!=', $ignoreBookingId);
        }

        // Returns true if no conflicts are found, false otherwise
        return $query->doesntExist();
    }
}
