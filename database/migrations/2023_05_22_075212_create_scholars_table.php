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
        Schema::create('scholars', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('spas_id')->unique();
            $table->string('account_no')->unique()->nullable();
            $table->tinyInteger('program_id')->unsigned()->index();
            $table->foreign('program_id')->references('id')->on('list_programs')->onDelete('cascade');
            $table->tinyInteger('subprogram_id')->unsigned()->index();
            $table->foreign('subprogram_id')->references('id')->on('list_programs')->onDelete('cascade');
            $table->tinyInteger('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('list_dropdowns')->onDelete('cascade');
            $table->tinyInteger('status_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')->on('list_statuses')->onDelete('cascade');
            $table->year('awarded_year');
            $table->boolean('is_undergrad')->default(1);
            $table->boolean('is_endorsed')->default(0);
            $table->boolean('is_completed')->default(0);
            $table->boolean('is_synced')->default(1);
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
        Schema::dropIfExists('scholars');
    }
};
