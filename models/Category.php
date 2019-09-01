<?php namespace Roojai\Blogs\Models;

use Model;
use Config;
use Cms\Classes\Page as CmsPage;
use Cms\Classes\Theme;

/**
 * Model
 */
class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;
    const SORT_ORDER = 'sort_order';
    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['name','introduction'];
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'roojai_blogs_categories';

    // Relations
    public $belongsToMany = [
      'blogs' => [
      'Roojai\Blogs\Models\Blog',
      'table' => 'roojai_blogs_categories_blogs',
      'order' => 'date'
    ]
    ];

    public $attachMany = [
        'mainimage' => 'System\Models\File'
    ];
public static function getMenuTypeInfo($type)
{
    $result = [];
    if ($type == 'blogcategories') {
        $result = [
            'dynamicItems' => true
        ];
    }
    if ($result) {
        $theme = Theme::getActiveTheme();
        $pages = CmsPage::listInTheme($theme, true);
        $cmsPages = [];
        foreach ($pages as $page) {
            if (!$page->hasComponent('singlecategory')) {
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
    if ($item->type == 'blogcategories') {
        $result = [
            'items' => []
        ];

        $categories = self::where('publicview', '=', "1")->orderBy('sort_order')
        ->get();

        foreach ($categories as $category) {
            $categoryItem = [
                'title' => $category->name,
                'url'   => self::getCategoryPageUrl($item->cmsPage, $category, $theme),
                'mtime' => $category->updated_at,
            ];

            $result['items'][] = $categoryItem;
        }
    }

    return $result;
}
protected static function getCategoryPageUrl($pageCode, $category, $theme)
{
    $page = CmsPage::loadCached($theme, $pageCode);
    if (!$page) {
        return;
    }
    $params = [
        'slug'  => $category->slug,
    ];
    $url = CmsPage::url($page->getBaseFileName(), $params);
    return $url;
}


}
