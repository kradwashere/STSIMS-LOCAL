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
        Schema::create('accounting_disbursements', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->decimal('amount',12,2); 
            $table->string('remarks')->nullable();
            $table->integer('report_id')->unsigned()->index();
            $table->foreign('report_id')->references('id')->on('accounting_reports')->onDelete('cascade');
            $table->tinyInteger('expense_id')->unsigned()->index();
            $table->foreign('expense_id')->references('id')->on('list_expenses')->onDelete('cascade');
            $table->bigInteger('added_by')->unsigned()->index();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade'); 
            $table->boolean('is_editable')->default(1);
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
        Schema::dropIfExists('accounting_disbursements');
    }
};
