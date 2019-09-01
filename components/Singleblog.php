<?php namespace Roojai\Blogs\Components;

use Cms\Classes\ComponentBase;
use Roojai\Blogs\Models\Blog;
use BackendAuth;

class Singleblog extends ComponentBase
{

  public function componentDetails()
  {
      return [
          'name' => 'Roojai Single Blog',
          'description' => 'Displays a Single Blog'
      ];
  }

  public function defineProperties()
  {
      return[
        'imagestyle'=> [
          'title'=>'Main Image Style',
          'type'=>'dropdown',
          'default'=>'none',
          'options'=>['none' =>'None','tm-box-decoration-default'=>'Default','tm-box-decoration-primary'=>'Primary','tm-box-decoration-secondary'=>'Secondary','uk-box-shadow-bottom'=>'Shadow','tm-mask-default'=>'Mask']
        ],
        'sideimagestyle'=> [
          'title'=>'Use Side Image Styles',
          'type'=>'checkbox'
        ],
        'featureimagestyle'=> [
          'title'=>'Use Feature Image Styles',
          'type'=>'checkbox'
        ],
      ];
  }
  public function onRun()
  {
    $user = BackendAuth::getUser();
    if ($user) {
      $this->page['blog'] = Blog::where('slug','=',$this->param('slug'))->first();}
    else {
      $this->page['blog'] = Blog::where('publicview', '=', "1")->where('slug','=',$this->param('slug'))->first();}
      if(!$this->page['blog']['id']) {
      $this->setStatusCode(404);
      return $this->controller->run('404');}
  }


}
