<?php namespace Roojai\Blogs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRoojaiBlogsCategories extends Migration
{
    public function up()
    {
        Schema::create('roojai_blogs_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->integer('sort_order')->nullable();
            $table->text('introduction')->nullable();
            $table->boolean('publicview')->nullable();
            $table->boolean('feature')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('roojai_blogs_categories');
    }
}
