<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('seo_setting_descriptions', function (Blueprint $table) {
            // Удаление уникального ограничения для пары seo_setting_id и locale
            $table->dropUnique(['seo_setting_id', 'locale']);

            // Добавляем внешний ключ language_id и устанавливаем связь с таблицей languages
            $table->unsignedBigInteger('language_id')->after('seo_setting_id'); // Добавляем после seo_setting_id
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');

            // Удаление поля locale
            $table->dropColumn('locale');
        });
    }

    public function down()
    {
        Schema::table('seo_setting_descriptions', function (Blueprint $table) {
            // Добавляем обратно поле locale и уникальное ограничение в случае отката миграции
            $table->string('locale')->after('seo_setting_id');
            $table->unique(['seo_setting_id', 'locale']);

            // Удаление внешнего ключа и поля language_id
            $table->dropForeign(['language_id']);
            $table->dropColumn('language_id');
        });
    }
};
