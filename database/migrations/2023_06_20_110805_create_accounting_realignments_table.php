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
        Schema::create('accounting_realignments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->decimal('amount',12,2); 
            $table->tinyInteger('receiver_class')->unsigned()->index();
            $table->foreign('receiver_class')->references('id')->on('list_expenses')->onDelete('cascade');
            $table->tinyInteger('sender_class')->unsigned()->index();
            $table->foreign('sender_class')->references('id')->on('list_expenses')->onDelete('cascade');
            $table->bigInteger('added_by')->unsigned()->index();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade'); 
            $table->json('attachment');
            $table->boolean('is_approved')->default(1);
            $table->boolean('is_paid')->default(0);
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
        Schema::dropIfExists('accounting_realignments');
    }
};
