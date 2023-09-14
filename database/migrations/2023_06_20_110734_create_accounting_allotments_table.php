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
        Schema::create('accounting_allotments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code')->unique(); 
            $table->string('check_no'); 
            $table->date('credited_at');
            $table->date('checked_at');
            $table->string('remarks',200); 
            $table->boolean('is_editable')->default(1);
            $table->integer('report_id')->unsigned()->index();
            $table->foreign('report_id')->references('id')->on('accounting_reports')->onDelete('cascade');
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
        Schema::dropIfExists('accounting_allotments');
    }
};
