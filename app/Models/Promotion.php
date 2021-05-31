<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    const ACTIVE = 'active';
    const INACTIVE = 'inactive';
    const DEACTIVATED = 'deactivated';

    protected $fillable = ['title', 'event_name', 'description', 'no_of_tickets', 'amount', 'event_location', 'longitude', 'latitude', 'expiry_date', 'status'];

    public function promotionCodes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PromotionCode::class);
    }
}
