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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // table_name
            $table->string('name');

            // table_description
            $table->string('description');

            // table_price
            $table->integer('price');

            // table_stock
            $table->integer('stock');

            // table_isAvailable
            $table->boolean('is_available')->default(true);

            // table_isFavorite
            $table->boolean('is_favorite')->default(false);

            // image
            $table->string('image');

            // table_userId
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
