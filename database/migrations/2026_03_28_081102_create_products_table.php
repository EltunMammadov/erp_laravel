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
            $table->string('name', 150)->unique();
            $table->string('sku', 50)->unique();
            $table->text('description')->nullable();
            $table->enum('category', ['raw_material', 'finished_good', 'service']);
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity_in_stock')->default(0);
            $table->integer('reorder_level')->nullable()->default(10);
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->softDeletes();
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
