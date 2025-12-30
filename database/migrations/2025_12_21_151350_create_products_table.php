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
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('stock')->default(0);
            $table->decimal('base_price', 10, 2)->default(0);
            $table->boolean('has_variant')->default(false);
            $table->boolean('status')->default(true);
            $table->boolean('show_home')->default(false);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('added_by');
            $table->timestamps();

            $table->foreign('added_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')
                ->on('product_categories')
                ->onDelete('cascade');
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
