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
        Schema::create('branches', function (Blueprint $table) {
            $table->unsignedBigInteger('id_branch');
            $table->char('id_pharmacy', 3);
            $table->string('name', 50);

            $table->primary(['id_branch', 'id_pharmacy'], 'pk_branches');

            $table->foreign('id_pharmacy', 'fk_branches_pharmacy')
                  ->references('id_pharmacy')
                  ->on('pharmacies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
