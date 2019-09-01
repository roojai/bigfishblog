<?php namespace Roojai\Blogs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateRoojaiBlogsBlogs extends Migration
{
    public function up()
    {
        Schema::table('roojai_blogs_blogs', function($table)
        {
            $table->integer('form_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('roojai_blogs_blogs', function($table)
        {
            $table->dropColumn('form_id');
        });
    }
}
