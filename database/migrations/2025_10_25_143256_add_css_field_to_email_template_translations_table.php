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
        Schema::table('email_template_translations', function (Blueprint $table) {
            $table->text('css_styles')->nullable()->after('preheader');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_template_translations', function (Blueprint $table) {
            $table->dropColumn('css_styles');
        });
    }
};
