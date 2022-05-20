<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->string('dni', 45)->primary();
            $table->unsignedBigInteger('id_reg');
            $table->unsignedBigInteger('id_com');
            $table->string('email', 120);
            $table->string('name', 45);
            $table->string('last_name', 45);
            $table->string('address', 255);
            $table->dateTime('date_reg');
            $table->timestamps();
            $table->enum('status', ['A', 'I']);

            $table->foreign('id_reg')->references('id')->on('regions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_com')->references('id')->on('communes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
