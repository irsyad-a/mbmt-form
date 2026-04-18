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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('nrp', 10)->unique();
            $table->string('faculty');
            $table->string('department');
            $table->string('major');
            $table->string('ukm', 100);
            $table->string('phone', 30);
            $table->boolean('has_allergy')->default(false);
            $table->text('allergy_description')->nullable();
            $table->timestamp('integrity_accepted_at');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};