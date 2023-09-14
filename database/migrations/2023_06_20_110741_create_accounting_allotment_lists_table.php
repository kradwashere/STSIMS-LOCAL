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
        Schema::create('accounting_allotment_lists', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->decimal('amount',12,2);
            $table->string('remarks',200); 
            $table->tinyInteger('expense_id')->unsigned()->index();
            $table->foreign('expense_id')->references('id')->on('list_expenses')->onDelete('cascade');
            $table->integer('allotment_id')->unsigned()->index();
            $table->foreign('allotment_id')->references('id')->on('accounting_allotments')->onDelete('cascade');
            $table->bigInteger('added_by')->unsigned()->index();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('accounting_allotment_lists');
    }
};
