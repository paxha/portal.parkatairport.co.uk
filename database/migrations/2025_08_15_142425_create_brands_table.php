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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('day_1')->nullable();
            $table->double('day_2')->nullable();
            $table->double('day_3')->nullable();
            $table->double('day_4')->nullable();
            $table->double('day_5')->nullable();
            $table->double('day_6')->nullable();
            $table->double('day_7')->nullable();
            $table->double('day_8')->nullable();
            $table->double('day_9')->nullable();
            $table->double('day_10')->nullable();
            $table->double('day_11')->nullable();
            $table->double('day_12')->nullable();
            $table->double('day_13')->nullable();
            $table->double('day_14')->nullable();
            $table->double('day_15')->nullable();
            $table->double('day_16')->nullable();
            $table->double('day_17')->nullable();
            $table->double('day_18')->nullable();
            $table->double('day_19')->nullable();
            $table->double('day_20')->nullable();
            $table->double('day_21')->nullable();
            $table->double('day_22')->nullable();
            $table->double('day_23')->nullable();
            $table->double('day_24')->nullable();
            $table->double('day_25')->nullable();
            $table->double('day_26')->nullable();
            $table->double('day_27')->nullable();
            $table->double('day_28')->nullable();
            $table->double('day_29')->nullable();
            $table->double('day_30')->nullable();
            $table->double('after_30')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
