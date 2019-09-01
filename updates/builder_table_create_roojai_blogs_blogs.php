<?php namespace Roojai\Blogs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRoojaiBlogsBlogs extends Migration
{
    public function up()
    {
        Schema::create('roojai_blogs_blogs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->date('date')->nullable();
            $table->text('introduction')->nullable();
            $table->boolean('publicview')->nullable();
            $table->boolean('feature_video')->nullable();
            $table->text('video_src')->nullable();
            $table->boolean('feature')->nullable();
            $table->boolean('show_newsletter')->nullable();
            $table->string('external_link')->nullable();
            $table->binary('external_option')->nullable();
            $table->text('section')->nullable();
            $table->boolean('mainimagesize')->nullable();
            $table->string('teaserimage')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('roojai_blogs_blogs');
    }
}