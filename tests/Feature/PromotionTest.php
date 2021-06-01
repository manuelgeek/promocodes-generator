<?php

namespace Tests\Feature;

use App\Models\Promotion;
use App\Models\PromotionCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class PromotionTest extends TestCase
{
    const DATA =[
        "title" => "Laravel Conf Nai Tickets",
        "slug" => "uniquw",
        "event_name" => "Laravel Conf Nairobi",
        "description" => "This is a free ticket",
        "no_of_tickets" => 10,
        "amount" => 500,
        "event_location" => "iHub, Senteu Plaza",
        "latitude" => -1.2892173,
        "longitude" => 36.7809874,
        "radius" => 15,
        "expiry_date" => "31-05-2021 12:00:00",
        "status" => "active"
    ];
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_promotion_validations()
    {
        $response = $this->postJson('/api/v1/promotion/create');

        $response
            ->assertStatus(422);
    }

    public function test_create_promotion()
    {

        $response = $this->postJson('/api/v1/promotion/create', $this::DATA);

        $response
            ->assertStatus(200);
    }

    public function test_update_promotion()
    {
        $promo = Promotion::create($this::DATA);
        $response = $this->putJson('/api/v1/promotion/update/'.$promo->slug, $this::DATA);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Promo Updated successfully',
            ]);
    }

    public function test_update_promo_code_status()
    {
        $promo = PromotionCode::first();
        $response = $this->putJson('/api/v1/promotion/update/promocode/'.$promo->code. '/status');

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Promo Code status updated',
            ]);
    }

    public function test_update_promo_code_status_wrong_code()
    {
        $response = $this->putJson('/api/v1/promotion/update/promocode/1234/status');

        $response
            ->assertStatus(404);
    }

    public function test_update_all_promo_code_statuses()
    {
        $promo = Promotion::first();
        $response = $this->putJson('/api/v1/promotion/update/'.$promo->slug. '/status');

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Promotion status updated',
            ]);
    }

    public function test_update_all_promo_code_statuses_wrong_slug()
    {
        $response = $this->putJson('/api/v1/promotion/update/1233/status');

        $response
            ->assertStatus(404);
    }

}
