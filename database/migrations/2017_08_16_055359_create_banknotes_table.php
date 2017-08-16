<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanknotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banknotes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('currency_id')->unsigned();
            $table->string('name');
            $table->decimal('buying', 21, 6);
            $table->decimal('selling', 21, 6);
            $table->timestamps();

            $table->foreign('currency_id')->references('id')->on('currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banknotes');
    }
}
