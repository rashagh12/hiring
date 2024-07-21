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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('working_time', ['part-time', 'full-time', 'remote', 'on-site']);
            $table->integer('vacancies');
            $table->string('salary');
            $table->string('experience')->nullable();
            $table->text('benefits')->nullable();
            $table->text('responsibilities')->nullable();
            $table->string('keywords')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('company_id')->constrained('companies');
            $table->enum('status', ['pending', 'approved','rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
