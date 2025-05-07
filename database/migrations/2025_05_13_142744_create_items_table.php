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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wishlist_id')->constrained('wishlists')->onDelete('cascade'); 
            $table->foreignId('category_id')->nullable()->constrained('item_categories')->onDelete('set null');   
            $table->string('name');
            $table->text('website_link')->nullable();
            $table->text('note')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('quantity')->default(1);
            $table->string('image')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
