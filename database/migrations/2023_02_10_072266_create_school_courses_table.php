<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_courses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->tinyInteger('years');
            $table->string('type')->default('n/a');
            $table->string('certification')->default('n/a');
            $table->string('validity')->default('n/a');
            $table->integer('school_id')->unsigned()->index();
            $table->foreign('school_id')->references('id')->on('school_campuses')->onDelete('cascade');
            $table->integer('course_id')->unsigned()->index();
            $table->foreign('course_id')->references('id')->on('list_courses')->onDelete('cascade');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_courses');
    }
};
