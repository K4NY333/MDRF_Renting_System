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
            Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('room_tenant_id')->nullable()->constrained('room_tenants')->onDelete('set null');
            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
            $table->enum('method', ['gcash', 'cash'])->default('gcash');
            $table->string('qr_proof')->nullable(); // if cash
            $table->string('tenant_name')->nullable(); 
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->onDelete('set null'); // owner/admin
            $table->timestamps();   
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
