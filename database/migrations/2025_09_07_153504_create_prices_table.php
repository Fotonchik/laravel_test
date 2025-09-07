<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id(); // идентификатор записи
            $table->unsignedBigInteger('id_product'); // идентификатор товара
            $table->decimal('price', 10, 2); // цена товара
            $table->timestamps();
            
            // Внешний ключ на products
            $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
            
            // Индекс для быстрого поиска
            $table->index('id_product');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prices');
    }
};