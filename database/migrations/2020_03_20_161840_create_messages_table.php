<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('mid');
            $table->unsignedBigInteger('from');
            $table->unsignedBigInteger('to');
            $table->string('message');
            $table->boolean('is_read')->default(0);

            $table->foreign('from')->references('uid')->on('users')->onDelete('cascade');
            $table->foreign('to')->references('uid')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('messages');
    }
}
