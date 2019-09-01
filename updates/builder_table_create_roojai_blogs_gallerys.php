<?php namespace Roojai\Blogs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRoojaiBlogsGallerys extends Migration
{
    public function up()
    {
        Schema::create('roojai_blogs_gallerys', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->text('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('roojai_blogs_gallerys');
    }
}
