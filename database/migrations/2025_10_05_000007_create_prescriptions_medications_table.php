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
        Schema::create('prescriptions_medications', function (Blueprint $table) {
            $table->unsignedBigInteger('id_prescription');
            $table->unsignedBigInteger('id_medication');
            
            $table->primary(['id_prescription', 'id_medication'], 'pk_prescriptions_medications');

            $table->foreign('id_prescription', 'fk_prescriptions_medications_prescription')
                ->references('id_prescription')
                ->on('prescriptions');

            $table->foreign('id_medication', 'fk_prescriptions_medications_medication')
                ->references('id_medication')
                ->on('medications');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions_medications');
    }
};
