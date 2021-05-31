<?php


namespace App\Services;


use App\Models\PromotionCode;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Helpers
{
    /**
     * @return Helpers
     */
    public static function init(): Helpers
    {
        return new self();
    }

    public function promoCodeIsValid($date): bool
    {
        return Carbon::parse($date)->greaterThanOrEqualTo(now());
    }

    public function generateCode(): string
    {
        $code = Str::random(5);
        if (PromotionCode::where('code', $code)->count() > 0) $this->generateCode();
        return strtoupper($code);
    }

}
