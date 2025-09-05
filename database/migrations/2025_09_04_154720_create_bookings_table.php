<?php

use App\Models\Airport;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\Terminal;
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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Airport::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Supplier::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Service::class)->constrained()->restrictOnDelete();
            $table->string('reference');
            $table->string('status');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('departure')->nullable();
            $table->timestamp('arrival')->nullable();
            $table->foreignIdFor(Terminal::class, 'departure_terminal_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Terminal::class, 'arrival_terminal_id')->nullable()->constrained()->nullOnDelete();
            $table->string('departure_flight_number')->nullable();
            $table->string('arrival_flight_number')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('color')->nullable();
            $table->integer('passengers')->nullable();
            $table->bigInteger('amount');
            $table->bigInteger('supplier_cost')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
