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
        Schema::create('location_barangays', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallIncrements('id');
            $table->string('code',50)->unique();
            $table->string('name',150);
            $table->string('old_name')->nullable();
            $table->string('district')->nullable();
            $table->string('municipality_code')->nullable()->constrained();
            $table->foreign('municipality_code')->references('code')->on('location_municipalities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_barangays');
    }
};
