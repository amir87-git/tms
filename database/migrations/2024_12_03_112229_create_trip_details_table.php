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
        Schema::create('trip_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained()->onDelete('cascade'); // Create a relationship with the shipments table
            $table->string('location'); // Location of the trip
            $table->date('in_date'); // In date
            $table->time('in_time'); // In time
            $table->date('out_date'); // Out date
            $table->time('out_time'); // Out time
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_details');
    }
};
