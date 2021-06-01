<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('event_name');
            $table->text('description')->nullable();
            $table->integer('no_of_tickets');
            $table->integer('amount');
            $table->string('event_location');
            $table->double('latitude');
            $table->double('longitude');
            $table->double('radius');
            $table->dateTime('expiry_date');
            $table->string('status')->default(\App\Models\Promotion::ACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotions');
    }
}
