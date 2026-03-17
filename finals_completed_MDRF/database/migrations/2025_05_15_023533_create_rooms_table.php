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
      Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('place_id')->nullable()->constrained('places')->onDelete('set null');

            $table->string('name'); // Room name
            $table->enum('type', ['bedspacer', 'private', 'shared']);
            $table->integer('capacity');
            $table->decimal('price', 10, 2);

            // Additional features
            $table->enum('status', ['Available', 'Occupied', 'Under Maintenance'])->default('Available');
            $table->text('kitchen_equipment')->nullable(); // or use json
            $table->boolean('cctv')->default(false);
            $table->boolean('laundry_area')->default(false);
            $table->boolean('allowed_pets')->default(false);
            $table->boolean('has_wifi')->default(false);
            $table->text('furniture_equipment')->nullable(); // or use json

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
