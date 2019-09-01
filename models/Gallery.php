<?php namespace Roojai\Blogs\Models;

use Model;

/**
 * Model
 */
class Gallery extends Model
{
    use \October\Rain\Database\Traits\Validation;

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
    public $table = 'roojai_blogs_gallerys';
    public $attachMany = [
        'images' => 'System\Models\File'
    ];
    public $belongsToMany = [
      'blogs' => [
      'Roojai\Blogs\Models\Blog',
      'table' => 'roojai_blogs_gallerys_blogs',
      'order' => 'name'
    ]
    ];
}
