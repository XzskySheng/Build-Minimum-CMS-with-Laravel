<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //添加字段
        Schema::create('articles', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title');
            $table->string('summary')->nullable();
            $table->text('content');
            $table->text('resolved_content');
            $table->integer('user_id');
            $table->softDeletes();
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
        Schema::drop('articles');
    }
}
