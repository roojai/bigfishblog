<?php namespace Roojai\Blogs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRoojaiBlogsCategoriesBlogs extends Migration
{
    public function up()
    {
        Schema::create('roojai_blogs_categories_blogs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('blog_id');
            $table->integer('category_id');
            $table->primary(['blog_id','category_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('roojai_blogs_categories_blogs');
    }
}
