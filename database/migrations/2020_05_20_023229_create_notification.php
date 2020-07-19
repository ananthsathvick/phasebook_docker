<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->bigIncrements('nid');
            $table->unsignedBigInteger('from_uid');
            $table->unsignedBigInteger('to_uid');
            $table->unsignedBigInteger('post_id');
            $table->string('notice');
            $table->boolean('is_read')->default(0);

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
        Schema::dropIfExists('notification');
    }
}
