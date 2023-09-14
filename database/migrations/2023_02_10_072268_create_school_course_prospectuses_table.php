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
        Schema::create('school_course_prospectuses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->json('subjects');
            $table->string('school_year',10);
            $table->boolean('is_completed')->default(0);
            $table->boolean('is_active')->default(0);
            $table->boolean('is_locked')->default(0);
            $table->integer('school_course_id')->unsigned()->index();
            $table->foreign('school_course_id')->references('id')->on('school_courses')->onDelete('cascade');
            $table->bigInteger('added_by')->unsigned()->index();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade'); 
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
        Schema::dropIfExists('school_course_prospectuses');
    }
};
