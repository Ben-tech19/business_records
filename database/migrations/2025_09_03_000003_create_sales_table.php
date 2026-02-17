<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('good_id')->constrained();
            $table->integer('quantity_sold');
            $table->dateTime('sale_date')->useCurrent();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->decimal('profit', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
