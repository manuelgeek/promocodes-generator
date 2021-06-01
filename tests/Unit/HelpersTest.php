<?php

namespace Tests\Unit;

use App\Services\Helpers;
use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_promo_code_is_valid()
    {
        $response = (new Helpers())->promoCodeIsValid('2030-12-12');
        $this->assertTrue($response);
    }

    public function test_promo_code_is_invalid()
    {
        $response = (new Helpers())->promoCodeIsValid('2020-12-12');
        $this->assertFalse($response);
    }

    public function test_get_distance()
    {
        $response = (new Helpers())->getDistance(-1.2750734, 6.9057369, -1.3124627, 36.7818808);
        $this->assertIsFloat($response);
    }
}
