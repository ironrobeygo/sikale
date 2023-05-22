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
        Schema::create('line_item_quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id');
            $table->text('description')->nullable();
            $table->unsignedInteger('quantity');
            $table->decimal('price', $precision = 8, $scale = 2);
            $table->decimal('disc', $precision = 8, $scale = 2);
            $table->unsignedInteger('discount')->nullable();
            $table->decimal('vat', $precision = 8, $scale = 2);
            $table->decimal('amount', $precision = 8, $scale = 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_item_quotes');
    }
};
