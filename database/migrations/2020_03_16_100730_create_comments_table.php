<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('cid');
            $table->string('comment');
            $table->unsignedBigInteger('from_uid');
            $table->unsignedBigInteger('to_uid');
            $table->unsignedBigInteger('post_id');

            $table->foreign('from_uid')->references('uid')->on('users')->onDelete('cascade');
            $table->foreign('to_uid')->references('uid')->on('users')->onDelete('cascade');
            $table->foreign('post_id')->references('pid')->on('posts')->onDelete('cascade');

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
        Schema::dropIfExists('comments');
    }
}
