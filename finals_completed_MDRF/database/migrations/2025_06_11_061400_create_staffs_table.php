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
                Schema::create('staffs', function (Blueprint $table) {
            $table->id(); // staff_id
            $table->unsignedBigInteger('owner_id'); // FK to users table where role = 'owner'

            $table->string('name');
            $table->string('email')->unique();
            $table->string('contact_number')->nullable();
            
            $table->enum('service_type', [
                'housekeeping',
                'laundry',
                'electric_maintenance',
                'water_maintenance',
                'repair',
                'security_system_maintenance',
                'waste_management'
            ]);

            $table->string('image_path')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staffs');
    }
};
