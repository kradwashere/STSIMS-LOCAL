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
        Schema::create('school_gradings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('grade',10);
            $table->string('lower_limit',10);
            $table->string('upper_limit',10);
            $table->integer('school_id')->unsigned()->index();
            $table->foreign('school_id')->references('id')->on('school_campuses')->onDelete('cascade');
            $table->boolean('is_incomplete')->default(0);
            $table->boolean('is_failed')->default(0);
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
        Schema::dropIfExists('school_gradings');
    }
};
