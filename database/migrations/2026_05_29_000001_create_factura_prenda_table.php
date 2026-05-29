<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('factura_prenda', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fkpk_id_factura');
            $table->string('fkpk_codigo_barras');
            $table->string('nombre_prend');
            $table->string('talla_prend')->nullable();
            $table->string('nom_color')->nullable();
            $table->decimal('precio_unitario', 12, 2)->default(0);
            $table->unsignedInteger('cantidad')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('factura_prenda');
    }
};
