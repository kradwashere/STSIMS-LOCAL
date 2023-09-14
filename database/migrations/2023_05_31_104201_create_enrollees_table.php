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
        Schema::create('enrollees', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->boolean('is_grades_completed')->default(0);
            $table->boolean('is_benefits_released')->default(0);
            $table->integer('school_semester_id')->unsigned()->index();
            $table->foreign('school_semester_id')->references('id')->on('school_semesters')->onDelete('cascade');
            $table->bigInteger('scholar_id')->unsigned()->index();
            $table->foreign('scholar_id')->references('id')->on('scholars')->onDelete('cascade');
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
        Schema::dropIfExists('enrollees');
    }
};
