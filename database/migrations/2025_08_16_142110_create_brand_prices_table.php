<?php

use App\Models\Brand;
use App\Models\Service;
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
        Schema::create('brand_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Service::class)->constrained()->cascadeOnDelete();
            $table->integer('month')->nullable();
            $table->integer('year')->nullable();
            $table->foreignIdFor(Brand::class, 'day_1')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_2')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_3')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_4')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_5')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_6')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_7')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_8')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_9')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_10')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_11')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_12')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_13')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_14')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_15')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_16')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_17')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_18')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_19')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_20')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_21')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_22')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_23')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_24')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_25')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_26')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_27')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_28')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_29')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_30')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class, 'day_31')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     *
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_prices');
    }
};
