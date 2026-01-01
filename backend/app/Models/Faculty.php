<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    protected $table = 'faculties';

    protected $fillable = [
        'faculty_name',
        'location'
    ];

    public function venues(): HasMany
    {
        return $this->hasMany(Venue::class);
    }

    protected function venueCount(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->venues()->count(),
        );
    }
}
