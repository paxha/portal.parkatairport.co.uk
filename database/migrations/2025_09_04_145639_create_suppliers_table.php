<?php

use App\Models\Airport;
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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Airport::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('address')->nullable();
            $table->float('commission');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
