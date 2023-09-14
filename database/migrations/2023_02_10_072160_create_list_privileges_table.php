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
        Schema::create('list_privileges', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->tinyIncrements('id');
            $table->string('name')->unique();
            $table->string('type');
            $table->string('short',100);
            $table->decimal('regular_amount',12,2);
            $table->decimal('summer_amount',12,2);
            $table->boolean('is_fixed');
            $table->boolean('is_active')->default(1);
            $table->boolean('is_reimburseable')->default(0);
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
        Schema::dropIfExists('list_privileges');
    }
};
