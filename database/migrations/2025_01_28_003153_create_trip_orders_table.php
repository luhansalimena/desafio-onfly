<?php

use App\OrderStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trip_orders', function (Blueprint $table) {
            $table->id();
            $table->string('requester_name');
            $table->enum('status', array_column(OrderStatus::cases(), 'name'))->default(OrderStatus::REQUESTED->value);
            $table->string('from');
            $table->string('to');
            $table->dateTime('trip_date');
            $table->string('trip_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_orders');
    }
};
