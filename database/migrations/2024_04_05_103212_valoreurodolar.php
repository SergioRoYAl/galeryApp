<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {

        if (!Schema::hasTable('cuadro')) {
            Schema::create('valoreurodolar', function (Blueprint $table) {
                $table->id();
                $table->double('valored');
            });
        }

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuadro');
    }
};
