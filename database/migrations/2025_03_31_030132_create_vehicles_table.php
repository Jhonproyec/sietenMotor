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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id(); 
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->string('registration');
            $table->string('vin')->nullable();
            $table->string('no_chasis')->nullable();
            $table->string('no_motor')->nullable();
            $table->string('fuel_type')->nullable();
            $table->foreignId('id_client')->constrained('clients');
            $table->foreignId('id_user')->constrained('users');
            $table->date('date_entered');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
