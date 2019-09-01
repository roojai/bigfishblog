<?php namespace Roojai\Blogs\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Gallerys extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController',        'Backend\Behaviors\ReorderController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Roojai.Blogs', 'main-menu-blogs', 'side-menu-item');
    }
}
