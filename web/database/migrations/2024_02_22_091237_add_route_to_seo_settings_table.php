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
        Schema::table('seo_settings', function (Blueprint $table) {
            $table->string('route')->nullable(); // Добавляем поле route, делаем его nullable, если маршрут не обязателен для всех записей
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('seo_settings', function (Blueprint $table) {
            $table->dropColumn('route'); // Удаляем поле route
        });
    }
};
