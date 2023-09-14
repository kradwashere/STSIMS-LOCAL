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
        Schema::create('scholar_enrollment_lists', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigincrements('id');
            $table->string('code',20);
            $table->string('subject');
            $table->integer('unit');
            $table->boolean('is_lab');
            $table->boolean('is_nonacademic');
            $table->boolean('is_failed')->nullable();
            $table->string('grade')->nullable();
            $table->bigInteger('enrollment_id')->unsigned()->index();
            $table->foreign('enrollment_id')->references('id')->on('scholar_enrollments')->onDelete('cascade');
            $table->bigInteger('encoded_by')->unsigned()->index()->nullable();
            $table->foreign('encoded_by')->references('id')->on('users')->onDelete('cascade');
            $table->json('options');
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
        Schema::dropIfExists('scholar_enrollment_lists');
    }
};
