<?php namespace Roojai\Blogs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
class BuilderTableCreateRoojaiBlogsGallerysBlogs extends Migration
{
    public function up()
    {
        Schema::create('roojai_blogs_gallerys_blogs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('gallery_id');
            $table->integer('blog_id');
            $table->primary(['gallery_id','blog_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('roojai_blogs_gallerys_blogs');
    }
}