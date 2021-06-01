<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromotionRequest;
use App\Models\Promotion;
use App\Models\PromotionCode;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function createPromotion(PromotionRequest $request)
    {
        if ($promo = (new Promotion)->createPromo($request)) {
            return response()->json([
                'message' => 'Promo Created successfully',
                'data' => $promo
            ]);
        }
        return response()->json([
            'message' => 'An error occurred, try again !'
        ], 400);
    }
    public function updatePromoCodeStatus(PromotionCode $code): \Illuminate\Http\JsonResponse
    {
        $code->status = $code->status === $code::ACTIVE ? $code::DEACTIVATED : $code::ACTIVE;
        $code->save();

        return response()->json([
            'message' => 'Promo Code status updated'
        ]);
    }

    public function updateAllPromoCodeStatuses(Promotion $promotion)
    {
        $promotion->status = $promotion->status === $promotion::ACTIVE ? $promotion::DEACTIVATED : $promotion::ACTIVE;
        $promotion->save();

        $promotion->promotionCodes()->update(['status' => $promotion->status === $promotion::ACTIVE ? PromotionCode::ACTIVE : PromotionCode::DEACTIVATED]);
    }

    public function getPromoCodes(Request $request): \Illuminate\Http\JsonResponse
    {
        $codes = PromotionCode::query();
        if($request->has('active') && $request->active !== null) {
            $codes = $codes->whereStatus(PromotionCode::ACTIVE)
                ->whereDate('expiry_date', '>=', now());
        }

        return response()->json([
            'data' => $codes->get()
        ]);
    }
}
