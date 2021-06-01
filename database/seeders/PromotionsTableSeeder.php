<?php

namespace Database\Seeders;

use App\Models\Promotion;
use App\Services\Helpers;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PromotionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $title = 'Laravel Free Tickets';
        $promotion  = Promotion::create([
            'title' => $title,
            'slug' => Str::slug($title),
            'event_name' => 'Laravel Conf Nairobi',
            'description' => 'Biggest Event free tickets',
            'no_of_tickets' => 20,
            'amount' => 500,
            'event_location' => 'iHub, Senteu Plaza',
            'latitude' => -1.2892173,
            'longitude' => 36.7809874,
            'radius' => 25,
            'expiry_date' => Carbon::parse('2021-06-31 12:00:00'),
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
