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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('mechanic_charge')->nullable();
            $table->text('description_maintenance');
            $table->date('date_maintenance');
            $table->date('date_next_maintenance')->nullable();
            $table->string('status');
            $table->string('factura')->nullable();
            $table->foreignId('id_vehicle')->constrained('vehicles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
