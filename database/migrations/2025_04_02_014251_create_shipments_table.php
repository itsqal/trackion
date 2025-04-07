<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\NullableType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('truck_id');
            $table->integer('delivery_order_price');
            $table->string('client');
            $table->string('load_type');
            $table->string('departure_waybill_number');
            $table->string('return_waybill_number');
            $table->decimal('departure_latitude', 10, 8);
            $table->decimal('departure_longitude', 11, 8);
            $table->string('final_location')->nullable();
            $table->float('distance_traveled')->nullable();
            $table->enum('status', ['perjalanan', 'selesai']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};