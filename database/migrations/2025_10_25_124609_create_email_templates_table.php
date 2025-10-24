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
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()
                  ->constrained('companies')->onDelete('cascade');
            $table->foreignId('email_template_type_id')
                  ->constrained('email_template_types')->onDelete('cascade');
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->text('html_layout')->nullable();
            $table->timestamps();

            $table->unique(['company_id', 'email_template_type_id']);
            $table->index('company_id');
            $table->index('email_template_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
