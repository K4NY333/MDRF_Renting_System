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
         Schema::create('landowner_applications', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('contact_number')->nullable();
        $table->string('password');
        $table->string('pdf_path');    
        $table->string('image_path'); 
        $table->enum('status', ['pending', 'approved', 'rejected','activated'])->default('pending');
        $table->string('activation_code')->nullable();
        $table->timestamps();
    });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('landowner_applications');
    }
};
