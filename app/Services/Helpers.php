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


    public function getDistance($latitude1, $longitude1, $latitude2, $longitude2) {
        $earth_radius = 6371;

        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;

        return $d;
    }

}
