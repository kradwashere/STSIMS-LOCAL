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
        Schema::create('school_campuses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('oldname')->nullable();
            $table->string('campus')->nullable();
            $table->string('address');
            $table->boolean('is_main');
            $table->boolean('is_active')->default(1);
            $table->integer('school_id')->unsigned()->index();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->tinyInteger('term_id')->unsigned()->index();
            $table->foreign('term_id')->references('id')->on('list_dropdowns')->onDelete('cascade');
            $table->tinyInteger('grading_id')->unsigned()->index();
            $table->foreign('grading_id')->references('id')->on('list_dropdowns')->onDelete('cascade');
            $table->string('municipality_code')->nullable()->constrained();
            $table->foreign('municipality_code')->references('code')->on('location_municipalities')->onDelete('cascade');
            $table->string('province_code')->nullable()->constrained();
            $table->foreign('province_code')->references('code')->on('location_provinces')->onDelete('cascade');
            $table->string('region_code')->nullable()->constrained();
            $table->foreign('region_code')->references('code')->on('location_regions')->onDelete('cascade');
            $table->string('assigned_region')->nullable()->constrained();
            $table->foreign('assigned_region')->references('code')->on('location_regions')->onDelete('cascade');
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
        Schema::dropIfExists('school_campuses');
    }
};
