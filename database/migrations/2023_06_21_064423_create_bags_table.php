<?php

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
        Schema::create('bags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('season_id');
            $table->decimal('bag_amount', 10, 2);
            $table->string('bag_size');
            $table->float('per_bag_price');
            $table->date('date');
            $table->decimal('total', 10, 2)->default(0.00);
            $table->timestamps();
            $table->foreign('season_id')->references('id')->on('seasons');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bags');
    }
};
