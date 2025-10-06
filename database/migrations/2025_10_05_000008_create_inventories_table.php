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
        Schema::create('inventories', function (Blueprint $table) {
            $table->unsignedBigInteger('id_medication');
            $table->unsignedBigInteger('id_branch');
            $table->char('id_pharmacy', 3);
            
            $table->integer('max_stock');
            $table->integer('min_stock');
            $table->integer('current_stock');

            $table->primary(['id_medication', 'id_branch', 'id_pharmacy'], 'pk_inventories');


            $table->foreign('id_medication', 'fk_inventories_medication')
                  ->references('id_medication')
                  ->on('medications');

            $table->foreign('id_branch', 'fk_inventories_branch')
                  ->references('id_branch')
                  ->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
