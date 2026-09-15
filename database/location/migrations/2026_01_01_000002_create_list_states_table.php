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
        Schema::create('list_states', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('list_country_id');
            $table->string('name');
            $table->string('s_name');
            $table->timestamps();

            $table->primary('id');
            $table->fullText('s_name');
            $table->unique('name');
            $table->index('list_country_id');
            $table->foreign('list_country_id')->references('id')->on('list_countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_states');
    }
};
