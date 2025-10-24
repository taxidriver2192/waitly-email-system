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
        Schema::create('email_template_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_template_id')
                  ->constrained('email_templates')->onDelete('cascade');
            $table->foreignId('language_id')
                  ->constrained('languages')->onDelete('cascade');
            $table->string('subject', 500);
            $table->text('html_body');
            $table->text('text_body')->nullable();
            $table->string('preheader')->nullable();
            $table->timestamps();

            $table->unique(['email_template_id', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_template_translations');
    }
};
