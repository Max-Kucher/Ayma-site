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
        Schema::table('service_item_descriptions', function (Blueprint $table) {
            $table->string('details_page_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_item_descriptions', function (Blueprint $table) {
            $table->dropColumn('details_page_name');
        });
    }
};
