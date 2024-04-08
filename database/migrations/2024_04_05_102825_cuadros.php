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
            Schema::create('cuadro', function (Blueprint $table) {
                $table->id();
                $table->string('nombre', 64);
                $table->string('autor', 64);
                $table->string('descripcion', 64)->nullable();
                $table->float('precio');
                $table->string('ubicacion', 256)->nullable();
                $table->string('imagen', 1024)->nullable();
                $table->string('qr', 128)->nullable();
                $table->float('valoracion')->nullable();
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
