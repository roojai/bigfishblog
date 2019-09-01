<?php namespace Roojai\Blogs\Components;

use Cms\Classes\ComponentBase;
use Roojai\Blogs\Models\Blog;
use Roojai\Blogs\Models\Category;
use BackendAuth;

class Singlecategory extends ComponentBase
{

  public function componentDetails()
  {
      return [
          'name' => 'Blog Category Page',
          'description' => 'Displays a Single Blog Category'
      ];
  }
  public function defineProperties()
  {
      return[
        'sectionback'=> [
          'title'=>'Background Colour',
          'type'=>'dropdown',
          'default'=>'default',
          'options'=>['default' =>'Default','primary'=>'Primary', 'secondary'=>'Secondary','muted'=>'Muted']
        ],
        'titlesize'=> [
          'title'=>'Title Size',
          'description'=>'Set the size of the main title',
          'type'=>'dropdown',
          'default'=>'uk-h1',
          'options'=>['uk-h3' =>'Small','uk-h1'=>'Default', 'uk-heading-primary'=>'Large','uk-heading-hero'=>'Huge','uk-h3 uk-text-primary' =>'Small in theme colour','uk-h1 uk-text-primary'=>'Default in theme colour', 'uk-heading-primary uk-text-primary'=>'Large in theme colour','uk-heading-hero uk-text-primary'=>'Huge in theme colour']
        ],
        'titlecolour'=> [
          'title'=>'Title Colour',
          'description'=>'Set the colour of the title and introduction text',
          'type'=>'dropdown',
          'default'=>'uk-dark',
          'options'=>['uk-dark' =>'Dark','uk-light'=>'Light']
        ],
        'results'=> [
          'title'=>'Blogs per page',
          'description'=>'How many blogs to display on a page',
          'default'=>9,
          'validationPattern'=>'^[0-9]+$',
          'validationMessage'=>'Only numbers allowed'
        ],
        'sortOrder'=> [
          'title'=>'Sort Blogs',
          'description'=>'Sort the blogs',
          'type'=>'dropdown',
          'default'=>'desc',
          'options'=>['desc' =>'Date (descending)','asc'=>'Date (ascending)']
        ],
        'columns'=> [
          'title'=>'Columns',
          'description'=>'Number of columns for large screens',
          'type'=>'dropdown',
          'default'=>'3',
          'options'=>['2' =>'Two','3'=>'Three','4'=>'Four']
        ],
        'cardstyle'=> [
          'title'=>'Card Style',
          'description'=>'Choose the style for the cards',
          'type'=>'dropdown',
          'default'=>'default',
          'options'=>['default' =>'Default','primary'=>'Primary','secondary'=>'Secondary','muted'=>'Muted','blank'=>'Blank'],
        ],
        'imagemask'=> [
          'title'=>'Add image mask',
          'description'=>'Adds a mask to the card image (only available with some themes)',
          'type'=>'checkbox',
          'default'=>null
        ],
        'readmore'=> [
          'title'=>'Read More Text',
          'description'=>'Add the read more text',
          'default'=>"Read More"
        ]

      ];
  }
  public function onRun()
    {
        $user = BackendAuth::getUser();
        if ($user) {
          $this->page['category'] = Category::where('slug','=',$this->param('slug'))->first();
        } else {
          $this->page['category'] = Category::where('publicview', '=', "1")->where('slug','=',$this->param('slug'))->first();
        }
        if(!$this->page['category']['id']) {
          $this->setStatusCode(404);
          return $this->controller->run('404');
        }
        $cat_id=$this->page->category['id'];
        if ($user) {
          $this->page['items']=Blog::whereHas('categories', function($query) use($cat_id) { $query->where('id', '=', $cat_id); })->orderBy('date', $this->property('sortOrder'))->paginate($this->property('results'));
        } else {
          $this->page['items']=Blog::where('publicview', '=', "1")->whereHas('categories', function($query) use($cat_id) { $query->where('id', '=', $cat_id); })->orderBy('date', $this->property('sortOrder'))->paginate($this->property('results'));
        }

      }



}
