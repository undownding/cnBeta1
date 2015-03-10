<?php

use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('articles', function($table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('article_id')->unique();
            $table->string('title');
            $table->dateTime('date');
            $table->text('intro');
            $table->string('topic');
            $table->integer('view_num')->unsigned();
            $table->integer('comment_num')->unsigned();
            $table->string('source', 20);
            $table->string('source_link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('articles');
    }

}
