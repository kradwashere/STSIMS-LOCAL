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
        Schema::create('location_municipalities', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallIncrements('id');
            $table->string('code',50)->unique();
            $table->string('name',150);
            $table->string('old_name')->nullable();
            $table->boolean('is_municipality');
            $table->boolean('is_chartered')->default(0);
            $table->string('district')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('province_code')->nullable()->constrained();
            $table->foreign('province_code')->references('code')->on('location_provinces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_municipalities');
    }
};
