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
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('set null');
             $table->foreignId('tenant_id')->nullable()->constrained('users')->onDelete('set null');

            // New: Optional assigned staff member
            $table->foreignId('staff_id')->nullable()->constrained('staffs')->onDelete('set null');

            // New: Service type of the request
            $table->enum('service_type', [
                'housekeeping',
                'laundry',
                'electric_maintenance',
                'water_maintenance',
                'repair',
                'security_system',
                'waste_management'
            ]);

            $table->text('description'); // maintenance issue description
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->timestamps();
    });

    

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
