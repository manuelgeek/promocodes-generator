<?php

namespace App\Transformers;

use App\Models\PromotionCode;
use League\Fractal\TransformerAbstract;

class PromoCodeTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(PromotionCode $code)
    {
        return [
            'id' => $code->id,
            'code' => $code->id,
            'status' => $code->status,
            'title' => $code->promotion->title,
            'event_name' => $code->promotion->event_name,
            'description' => $code->promotion->description,
            'event_location' => $code->promotion->event_location,
            'amount' => $code->promotion->amount,
            'expiry_date' => $code->promotion->expiry_date,
            'created_on' => $code->created_at
        ];
    }
}
