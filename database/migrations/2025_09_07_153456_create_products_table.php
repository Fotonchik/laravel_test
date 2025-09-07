<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // идентификатор товара
            $table->unsignedBigInteger('id_group'); // идентификатор группы товаров
            $table->string('name'); // название товара
            $table->timestamps();
            
            // Внешний ключ на groups
            $table->foreign('id_group')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};