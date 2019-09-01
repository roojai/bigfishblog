<?php namespace Roojai\Blogs\Models;

use Model;
use Config;
use Cms\Classes\Page as CmsPage;
use Cms\Classes\Theme;

/**
 * Model
 */
class Blog extends Model
{
    use \October\Rain\Database\Traits\Validation;
    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['name','introduction','content','section'];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */


    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'roojai_blogs_blogs';
    protected $jsonable = [ 'section'];

        // Relations

        public $belongsToMany = [
      		'categories' => [
      		'Roojai\Blogs\Models\Category',
      		'table' => 'roojai_blogs_categories_blogs',
      		'order' => 'name'
        	],
          'gallerys' => [
          'Roojai\Blogs\Models\Gallery',
          'table' => 'roojai_blogs_gallerys_blogs',
          'order' => 'name'
        ]
      	];
        public $belongsTo = [
          "form" => "Roojai\Sitesystem\Models\Form"
        ];
        public static function getMenuTypeInfo($type)
        {
            $result = [];


            if ($type == 'roojaiblogs') {
                $result = [
                    'dynamicItems' => true
                ];
            }

            if ($result) {
                $theme = Theme::getActiveTheme();

                $pages = CmsPage::listInTheme($theme, true);
                $cmsPages = [];

                foreach ($pages as $page) {
                    if (!$page->hasComponent('singleblog')) {
                        continue;
                    }


                    $cmsPages[] = $page;
                }

                $result['cmsPages'] = $cmsPages;
            }

            return $result;
        }



        public static function resolveMenuItem($item, $url, $theme)
        {
            $result = null;
            $baseurl=Config::get('app.url');
            if ($item->type == 'roojaiblogs') {
                $result = [
                    'items' => []
                ];

                $blogs = self::where('publicview', '=', "1")->orderBy('date')
                ->get();

                foreach ($blogs as $blog) {
                    $blogItem = [
                        'name' => $blog->name,
                        'url'   => self::getBlogPageUrl($item->cmsPage, $blog, $theme),
                        'mtime' => $blog->updated_at,
                    ];

                    $result['items'][] = $blogItem;
                }
            }

            return $result;
        }
        protected static function getBlogPageUrl($pageCode, $blog, $theme)
        {
            $page = CmsPage::loadCached($theme, $pageCode);
            if (!$page) {
                return;
            }
            $params = [
                'slug'  => $blog->slug,
            ];
            $url = CmsPage::url($page->getBaseFileName(), $params);

            return $url;
        }

}
