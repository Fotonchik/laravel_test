<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id(); // идентификатор группы
            $table->unsignedBigInteger('id_parent')->default(0); // идентификатор «родительской» группы
            $table->string('name'); // название группы
            $table->timestamps();
            
            // Внешний ключ на саму себя (иерархия)
            $table->foreign('id_parent')->references('id')->on('groups')->onDelete('cascade');
        });                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
    }

    public function down()
    {
        Schema::dropIfExists('groups');
    }
};