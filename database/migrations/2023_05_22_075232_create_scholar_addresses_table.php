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
        Schema::create('scholar_addresses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('address')->nullable()->default('n/a');
            $table->string('region_code')->nullable()->constrained();
            $table->foreign('region_code')->references('code')->on('location_regions')->onDelete('cascade');
            $table->string('province_code')->nullable()->constrained();
            $table->foreign('province_code')->references('code')->on('location_provinces')->onDelete('cascade');
            $table->string('municipality_code')->nullable()->constrained();
            $table->foreign('municipality_code')->references('code')->on('location_municipalities')->onDelete('cascade');
            $table->string('barangay_code')->nullable()->constrained();
            $table->foreign('barangay_code')->references('code')->on('location_barangays')->onDelete('cascade');
            $table->string('district')->nullable();
            $table->json('information');
            $table->boolean('is_permanent')->default(1);
            $table->boolean('is_within')->default(0);
            $table->boolean('is_completed')->default(0);
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
        Schema::dropIfExists('scholar_addresses');
    }
};
