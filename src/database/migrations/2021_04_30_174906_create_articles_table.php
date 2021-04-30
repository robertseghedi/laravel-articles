<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->longText('title');
            $table->longText('content');
            $table->integer('category')->default(0);
            $table->integer('author')->default(0);
            $table->integer('comment_count')->default(0);
            $table->integer('like_count')->default(0);
            $table->string('author_ip')->default('hidden');
            $table->string('author_os')->default('hidden');
            $table->string('author_browser')->default('hidden');
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
        Schema::dropIfExists('articles');
    }
}
