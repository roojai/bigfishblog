<?php namespace Roojai\Blogs\Components;

use Cms\Classes\ComponentBase;
use Roojai\Blogs\Models\Blog;
use BackendAuth;

class Sidebarblogs extends ComponentBase
{

  public function componentDetails()
  {
      return [
          'name' => 'Roojai Sidebar Blogs',
          'description' => 'Displays a list of blogs in the sidebar'
      ];
  }

  public function sidebarblogs(){


    $user = BackendAuth::getUser();
    if ($user) {
      $query = Blog::where('slug','!=',$this->param('slug'))->orderBy('date', 'des')->take(4)->get();}
    else {
      $query = Blog::where('slug','!=',$this->param('slug'))->where('publicview', '=', "1")->orderBy('date', 'des')->take(4)->get();}



    return $query;
  }



}
