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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('link'); // Ссылка
            $table->unsignedBigInteger('parent_id')->nullable(); // Родительский пункт меню (опционально)
            $table->integer('priority')->default(0); // Приоритет
            $table->timestamps();

            // Внешний ключ для родительского пункта меню
            $table->foreign('parent_id')->references('id')->on('menu_items')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};