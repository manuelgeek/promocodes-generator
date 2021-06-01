<?php

namespace App\Models;

use App\Services\Helpers;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Promotion extends Model
{
    use HasFactory;

    const ACTIVE = 'active';
    const INACTIVE = 'inactive';
    const DEACTIVATED = 'deactivated';

    protected $fillable = ['title', 'event_name', 'description', 'no_of_tickets', 'amount', 'event_location', 'longitude', 'latitude', 'expiry_date', 'status', 'slug', 'radius'];

    public function promotionCodes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PromotionCode::class);
    }

    public function createPromo($request)
    {
        $data = $request->all();
        $data['expiry_date'] = Carbon::parse($request->expiry_date);
        $data['slug'] = Str::slug($request->title);
        $promo = $this::create($data);
        for ($i = 0; $i < $request->no_of_tickets; $i++)
        {
            $promo->promotionCodes()->create([
                'code' => (new Helpers())->generateCode(),
                'status' => $request->status === $this::ACTIVE ? PromotionCode::ACTIVE : PromotionCode::INACTIVE
            ]);
        }

        return $promo;
    }
}
