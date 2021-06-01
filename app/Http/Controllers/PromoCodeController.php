<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromotionRequest;
use App\Http\Requests\UsePromoCodeRequest;
use App\Models\Promotion;
use App\Models\PromotionCode;
use App\Services\Helpers;
use App\Transformers\PromoCodeTransformer;
use Carbon\Carbon;
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

    public function updatePromotion(PromotionRequest $request, Promotion $promotion)
    {
        $data = $request->all();
        $data['expiry_date'] = Carbon::parse($request->expiry_date);
        if ($promo = $promotion->update($data)) {
            return response()->json([
                'message' => 'Promo Updated successfully',
                'data' => $promotion
            ]);
        }
        return response()->json([
            'message' => 'An error occurred, try again !'
        ], 400);
    }
    public function updatePromoCodeStatus($promocode): \Illuminate\Http\JsonResponse
    {
        $code = PromotionCode::whereCode($promocode)->firstOrFail();
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

        return response()->json([
            'message' => 'Promotion status updated'
        ]);
    }

    public function getPromoCodes(Request $request, Promotion $promotion): \Illuminate\Http\JsonResponse
    {
        $codes = PromotionCode::query();
        if($request->has('active') && $request->active !== null) {
            $codes->whereHas('promotion', function ($q) {
                $q->whereStatus(PromotionCode::ACTIVE)
                    ->whereDate('expiry_date', '>=', now());
            });
        }
        $codes = $codes->with('promotion')->where('promotion_id', $promotion->id);

        return response()->json([
            'data' => fractal($codes->get(), new PromoCodeTransformer())
        ]);
    }

    public function usePromoCode(UsePromoCodeRequest $request, $promocode)
    {
        $code = PromotionCode::whereCode($promocode)->firstOrFail();
        $promo = $code->promotion;
        $radius = $promo->radius;

        if($code->status !== PromotionCode::ACTIVE || $promo->status !== $promo::ACTIVE) {
            return $this->errorResponse('Promo Code is not active');
        } else if (!(new Helpers())->promoCodeIsValid($promo->expiry_date)) {
            return $this->errorResponse('Promo Code is expired');
        }

        $destination_distance = (new Helpers())->getDistance($request->destination['latitude'], $request->destination['longitude'], $promo->latitude, $promo->longitude);
        $origin_distance = (new Helpers())->getDistance($request->origin['latitude'], $request->origin['longitude'], $promo->latitude, $promo->longitude);

        if($destination_distance > $radius && $origin_distance > $radius) {
            return $this->errorResponse('Origin or destination is out of Event range');
        }

        $polyline = [['lat' => $request->origin['latitude'], 'lng' =>$request->origin['longitude']], ['lat' => $request->destination['latitude'], 'lng' => $request->destination['longitude']]];

        return response()->json([
            'promocode' => fractal($code, new PromoCodeTransformer()),
            'polyline' => $polyline
        ]);
    }

    private function errorResponse($message, $code = 403)
    {
        return response()->json(['message' => $message], $code);
    }
}
