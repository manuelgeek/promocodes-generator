<?php

namespace Tests\Feature;

use App\Models\Promotion;
use App\Models\PromotionCode;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PromoCodesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_promo_codes()
    {
        $promo = Promotion::first();
        $response = $this->getJson('/api/v1/promotion/'.$promo->slug.'/promocodes');

        $response
            ->assertStatus(200);
    }

    public function test_use_promo_code_failing_validation()
    {
        $promo = PromotionCode::first();
        $response = $this->postJson('/api/v1/promotion/promocode/'.$promo->code.'/use');

        $response
            ->assertStatus(422);
    }

    public function test_use_promo_code_deactivated()
    {
        $data = [
            "origin" => [
                "latitude" => -1.2750734,
                "longitude" => 36.9057369
            ],
            "destination" => [
                "latitude" => -1.3124627,
                "longitude" => 36.7818808
            ]
        ];
        $promo = PromotionCode::first();
        $promo->status = PromotionCode::DEACTIVATED;
        $promo->save();
        $response = $this->postJson('/api/v1/promotion/promocode/'.$promo->code.'/use', $data);

        $response
            ->assertStatus(403)
            ->assertJson([
                'message' => 'Promo Code is not active',
            ]);
    }

    public function test_use_promo_code_expired()
    {
        $data = [
            "origin" => [
                "latitude" => -1.2750734,
                "longitude" => 36.9057369
            ],
            "destination" => [
                "latitude" => -1.3124627,
                "longitude" => 36.7818808
            ]
        ];
        $promo = PromotionCode::first();
        $promo->status = PromotionCode::ACTIVE;
        $promo->save();
        $promo->promotion->expiry_date  = Carbon::parse('2020-12-12');
        $promo->promotion->save();
        $response = $this->postJson('/api/v1/promotion/promocode/'.$promo->code.'/use', $data);

        $response
            ->assertStatus(403)
            ->assertJson([
                'message' => 'Promo Code is expired',
            ]);
    }

    public function test_use_promo_code_distance_out_of_range()
    {
        $data = [
            "origin" => [
                "latitude" => -11.2750734,
                "longitude" => 36.9057369
            ],
            "destination" => [
                "latitude" => -11.3124627,
                "longitude" => 36.7818808
            ]
        ];
        $promo = PromotionCode::first();
        $promo->status = PromotionCode::ACTIVE;
        $promo->save();
        $promo->promotion->expiry_date  = Carbon::parse('2030-12-12');
        $promo->promotion->save();
        $response = $this->postJson('/api/v1/promotion/promocode/'.$promo->code.'/use', $data);

        $response
            ->assertStatus(403)
            ->assertJson([
                'message' => 'Origin or destination is out of Event range',
            ]);
    }

    public function test_use_promo_code_valid()
    {
        $data = [
            "origin" => [
                "latitude" => -1.2750734,
                "longitude" => 36.9057369
            ],
            "destination" => [
                "latitude" => -1.3124627,
                "longitude" => 36.7818808
            ]
        ];
        $promo = PromotionCode::first();
        $promo->status = PromotionCode::ACTIVE;
        $promo->save();
        $promo->promotion->expiry_date  = Carbon::parse('2030-12-12');
        $promo->promotion->save();
        $response = $this->postJson('/api/v1/promotion/promocode/'.$promo->code.'/use', $data);

        $response
            ->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->has('promocode');
                $json->has('polyline');
            });
    }
}
