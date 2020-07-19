<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friend_reqs', function (Blueprint $table) {
            $table->bigIncrements('fid');
            $table->unsignedBigInteger('from');
            $table->unsignedBigInteger('to');
            $table->boolean('accepted')->default(0);

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
        Schema::dropIfExists('friend_reqs');
    }
}
