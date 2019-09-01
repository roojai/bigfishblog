<?php namespace Roojai\Blogs;

use System\Classes\PluginBase;
use Roojai\Blogs\Models\Blog;
use Roojai\Blogs\Models\Category;
use Event;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
      return [
        'Roojai\Blogs\Components\Blogs'=>'blogs',
        'Roojai\Blogs\Components\Singleblog'=>'singleblog',
        'Roojai\Blogs\Components\Sidebarblogs'=>'sidebarblogs',
        'Roojai\Blogs\Components\Singlecategory'=>'singlecategory'
      ];

    }
    public function registerPageSnippets()
    {
        return [
          'Roojai\Blogs\Components\Blogs'=>'blogs'
        ];
    }
    public function registerSettings()
    {
    }
    public function boot()
      {
          Event::listen('pages.menuitem.listTypes', function() {
              return [
                  'roojaiblogs'=>'All Blogs',
                  'blogcategories'=>'Blog Categories'
              ];
          });

          Event::listen('pages.menuitem.getTypeInfo', function($type) {
              if ($type == 'roojaiblogs'){
                  return Blog::getMenuTypeInfo($type);
              } elseif($type == 'blogcategories'){
                  return Category::getMenuTypeInfo($type);
              }
          });

          Event::listen('pages.menuitem.resolveItem', function($type, $item, $url, $theme) {
              if ($type == 'roojaiblogs' ){
                  return Blog::resolveMenuItem($item, $url, $theme);
              } elseif($type == 'blogcategories'){
                  return Category::resolveMenuItem($item, $url, $theme);
              }
          });
      }
}
