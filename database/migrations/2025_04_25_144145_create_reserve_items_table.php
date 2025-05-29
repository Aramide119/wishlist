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
        Schema::create('reserve_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('quantity')->nullable();
            $table->string('note')->nullable();
            $table->string('amount')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('money_id')->nullable();
            $table->boolean('accepted_terms')->default(false);
            $table->string('status')->nullable();
            $table->string('reference_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserve_items');
    }
};
