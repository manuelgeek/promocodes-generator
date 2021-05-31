<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\PromotionCode;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function updatePromoCodeStatus(PromotionCode $code)
    {
        $code->status = $code->status === $code::ACTIVE ? $code::DEACTIVATED : $code::ACTIVE;
        return response()->json([
            'message' => 'Promo Code status updated'
        ]);
    }

    public
}
