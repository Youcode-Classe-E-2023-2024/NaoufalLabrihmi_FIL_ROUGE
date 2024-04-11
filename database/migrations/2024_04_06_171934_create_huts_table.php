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
        Schema::create('huts', function (Blueprint $table) {
            $table->id();
            $table->integer('huttype_id');
            $table->string('total_adult')->nullable();
            $table->string('total_child')->nullable();
            $table->string('hut_capacity')->nullable();
            $table->string('image')->nullable();
            $table->string('price')->nullable();
            $table->string('size')->nullable();
            $table->string('view')->nullable();
            $table->string('bed_style')->nullable();
            $table->integer('discount')->default(0);
            $table->text('short_desc')->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('huts');
    }
};
