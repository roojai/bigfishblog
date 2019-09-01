<?php namespace Roojai\Blogs\Components;

use Cms\Classes\ComponentBase;
use Roojai\Blogs\Models\Blog;
use Roojai\Blogs\Models\Category;
use BackendAuth;

class Blogs extends ComponentBase
{

  public function componentDetails()
  {
      return [
          'name' => 'Roojai Blog Teasers',
          'description' => 'Displays the Blogs in Cards'
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
        'title'=> [
          'title'=>'Title',
          'description'=>'Title to show at the top',
          'type'=>'text'
        ],
        'titlesize'=> [
          'title'=>'Title Size',
          'description'=>'Set the size of the main title',
          'type'=>'dropdown',
          'default'=>'uk-h1',
          'options'=>['uk-h3' =>'Small','uk-h1'=>'Default', 'uk-heading-primary'=>'Large','uk-heading-hero'=>'Huge','uk-h3 uk-text-primary' =>'Small in theme colour','uk-h1 uk-text-primary'=>'Default in theme colour', 'uk-heading-primary uk-text-primary'=>'Large in theme colour','uk-heading-hero uk-text-primary'=>'Huge in theme colour']
        ],
        'titletype'=> [
          'title'=>'Title Type (h1/h2/h3)',
          'description'=>'Set the type of title',
          'type'=>'dropdown',
          'default'=>'h2',
          'options'=>['h1' =>'h1','h2'=>'h2', 'h3'=>'h3']
        ],
        'titlecolour'=> [
          'title'=>'Title Colour',
          'description'=>'Set the colour of the title and introduction text',
          'type'=>'dropdown',
          'default'=>'uk-dark',
          'options'=>['uk-dark' =>'Dark','uk-light'=>'Light']
        ],
        'intro'=> [
          'title'=>'introduction',
          'description'=>'Optional description to show above the teasers',
          'type'=>'text'
        ],
        'results'=> [
          'title'=>'Number of Blogs',
          'description'=>'How many blogs to display',
          'default'=>6,
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
        'category'=> [
          'title'=>'Category',
          'description'=>'Select Category',
          'type'=>'dropdown',
          'default'=>'all',
        ],
        'pagination'=> [
          'title'=>'Pagination',
          'description'=>'Show pagination',
          'type'=>'checkbox',
          'default'=>null
        ],
        'readmore'=> [
          'title'=>'Read More Text',
          'description'=>'Add the read more text',
          'default'=>"Read More"
        ],
        'writtentop'=> [
          'title'=>'Written content above',
          'description'=>'Tick this is you are adding text instead of using a snippet or banner immediately above this',
          'type'=>'checkbox',
          'default'=>null
        ],
        'writtenbottom'=> [
          'title'=>'Written content below',
          'description'=>'Tick this is you are adding text instead of using a snippet or banner immediately below this',
          'type'=>'checkbox',
          'default'=>null
        ]
      ];
  }

  public function getCategoryOptions()
  {
    $categories=['all'=>'All'];
    $allcategories=Category::all();
    foreach($allcategories as $singlecat){
      $categories=array_merge($categories,[$singlecat->slug=>$singlecat->name]);
    };

      return $categories;
  }
  public function onRun()
    {
        $user = BackendAuth::getUser();
        $cat_id=$this->property('category');
        if($cat_id!="all"){
          if ($user) {
          $this->page['items']=Blog::whereHas('categories', function($query) use($cat_id) { $query->where('slug', '=', $cat_id); })->orderBy('date', $this->property('sortOrder'))->paginate($this->property('results'));
          }
          else {
          $this->page['items']=Blog::where('publicview', '=', "1")->whereHas('categories', function($query) use($cat_id) { $query->where('slug', '=', $cat_id); })->orderBy('date', $this->property('sortOrder'))->paginate($this->property('results'));
          }
        } else {
          if ($user) {
          $this->page['items']=Blog::orderBy('date', $this->property('sortOrder'))->paginate($this->property('results'));
          }
          else {
          $this->page['items']=Blog::where('publicview', '=', "1")->orderBy('date', $this->property('sortOrder'))->paginate($this->property('results'));
          }
        }

      }



}
