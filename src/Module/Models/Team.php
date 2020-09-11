<?php

namespace RefinedDigital\Team\Module\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use RefinedDigital\CMS\Modules\Core\Models\CoreModel;
use RefinedDigital\CMS\Modules\Core\Traits\IsArticle;
use RefinedDigital\CMS\Modules\Pages\Traits\IsPage;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Team extends CoreModel implements Sortable
{
  use SoftDeletes, IsPage, IsArticle, SortableTrait;

  public $sortable = [ 'order_column_name' => 'position', 'direction' => 'asc'];

  protected $fillable = [
    'active', 'position', 'name', 'image', 'content', 'job_title_1','job_title_2','phone','mobile','fax','email', 'data'
  ];

  protected $casts = [
    'data' => 'object'
  ];

  /**
   * The fields to be displayed for creating / editing
   *
   * @var array
   */
  public $formFields = [
    [
      'name' => 'Content',
      'sections' => [
        'left' => [
          'blocks' => [
            [
              'name' => 'Content',
              'fields' => [
                [
                  [ 'label' => 'Active', 'name' => 'active', 'required' => true, 'type' => 'select', 'options' => [1 => 'Yes', 0 => 'No'] ],
                  [ 'label' => 'Name', 'name' => 'name', 'required' => true, 'attrs' => ['v-model' => 'content.name', '@keyup' => 'updateSlug' ] ],
                ],
                [
                  [ 'label' => 'Title', 'name' => 'job_title_1', 'required' => false, ],
                  [ 'label' => 'Title 2', 'name' => 'job_title_2', 'required' => false, ],
                ],
                [
                  [ 'label' => 'Content', 'name' => 'content', 'required' => true, 'type' => 'richtext' ],
                ],
              ]
            ]
          ]
        ],
        'right' => [
          'blocks' => [
            [
              'name' => 'Attributes',
              'fields' => [
                [
                  [ 'label' => 'Image', 'name' => 'image', 'required' => true, 'hideLabel' => true, 'type' => 'image' ],
                ],
                [
                  [ 'label' => 'Email', 'name' => 'email', 'required' => false, 'type' => 'email' ],
                ],
                [
                  [ 'label' => 'Phone', 'name' => 'phone', 'required' => false, 'type' => 'tel' ],
                ],
                [
                  [ 'label' => 'Mobile', 'name' => 'mobile', 'required' => false, 'type' => 'tel' ],
                ],
                [
                  [ 'label' => 'Fax', 'name' => 'fax', 'required' => false, 'type' => 'tel' ],
                ],
              ]
            ]
          ]
        ],
      ]
    ],
  ];
}
