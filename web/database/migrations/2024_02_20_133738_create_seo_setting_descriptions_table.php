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
        Schema::create('seo_setting_descriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seo_setting_id'); // Ссылка на основную таблицу SEO настроек
            $table->string('locale'); // Код языка (например, 'en', 'fr', 'es' и т.д.)
            $table->string('title');
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->foreign('seo_setting_id')->references('id')->on('seo_settings')->onDelete('cascade');
            $table->unique(['seo_setting_id', 'locale']); // Уникальность для пары seo_setting_id и locale

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_setting_descriptions');
    }
};
