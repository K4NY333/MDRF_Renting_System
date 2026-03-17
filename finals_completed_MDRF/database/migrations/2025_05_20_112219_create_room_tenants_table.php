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
            Schema::create('room_tenants', function (Blueprint $table) {
            $table->id();
                $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('cascade');
                $table->foreignId('tenant_id')->nullable()->constrained('users')->onDelete('set null');
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->decimal('monthly_rent', 10, 2)->nullable();
                $table->enum('status', ['pending', 'renting', 'terminated'])->default('pending');
                $table->timestamps();
    });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_tenants');
    }
};
