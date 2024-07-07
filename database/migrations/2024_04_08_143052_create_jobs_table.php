<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('job_type_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('vacancy')->default(1);
            $table->string('location');
            $table->decimal('salary', 10, 2);
            $table->string('company_name');
            $table->text('benefits');
            $table->text('responsibility');
            $table->text('qualifications');
            $table->text('keywords');
            $table->text('experience');
            $table->string('company_location');
            $table->boolean('status')->default(1); // Adding status field
            $table->boolean('isFeatured')->default(0); // Adding isFeatured field
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('job_type_id')->references('id')->on('job_types')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
