<?php

namespace Database\Seeders;

use App\Models\Promotion;
use App\Services\Helpers;
use Illuminate\Database\Seeder;

class PromotionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $promotion  = Promotion::create([
            'title' => 'Laravel Free Tickets',
            'event_name' => 'Laravel Conf Nairobi',
            'description' => 'Biggest Event free tickets',
            'no_of_tickets' => 20,
            'amount' => 500,
            'event_location' => 'iHub, Senteu Plaza',
            'latitude' => -1.2892173,
            'longitude' => '36.7809874',
            'expiry_date' => '31-06-2021',
            'status' => Promotion::ACTIVE
        ]);

        $statuses = [Promotion::ACTIVE, Promotion::DEACTIVATED];
        for ($i = 0; $i < $promotion->no_of_tickets; $i++)
        {
            $promotion->promotionCodes()->create([
                'code' => (new Helpers())->generateCode(),
                'status' => $statuses[array_rand($statuses)]
            ]);
        }

    }
}
