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
        Schema::create('scholar_reimbursements', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->decimal('amount',12,2);
            $table->json('attachment');
            $table->boolean('is_approved')->default(0);
            $table->boolean('is_reimbursed')->default(0);
            $table->tinyInteger('benefit_id')->unsigned()->index();
            $table->foreign('benefit_id')->references('id')->on('list_privileges')->onDelete('cascade');
            $table->bigInteger('scholar_id')->unsigned()->index();
            $table->foreign('scholar_id')->references('id')->on('scholars')->onDelete('cascade');
            $table->integer('school_semester_id')->unsigned()->index();
            $table->foreign('school_semester_id')->references('id')->on('school_semesters')->onDelete('cascade');
            $table->bigInteger('checked_by')->unsigned()->index();
            $table->foreign('checked_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('scholar_reimbursements');
    }
};
