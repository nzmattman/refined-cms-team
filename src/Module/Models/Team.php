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

    public $sortable = ['order_column_name' => 'position', 'direction' => 'asc'];

    protected $fillable = [
        'active', 'position', 'name', 'image', 'content', 'job_title_1', 'job_title_2', 'phone',
        'mobile', 'fax', 'email', 'data', 'intro'
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
            'name'     => 'Content',
            'sections' => [
                'left'  => [
                    'blocks' => [
                        [
                            'name'   => 'Content',
                            'fields' => [
                                [
                                    [
                                        'label' => 'Name', 'name' => 'name', 'required' => true,
                                        'attrs' => [
                                            'v-model' => 'content.name', '@keyup' => 'updateSlug'
                                        ]
                                    ],
                                ],
                                [
                                    [
                                        'label'    => 'Title', 'name' => 'job_title_1', 'required' => false,
                                    ],
                                ],
                            ]
                        ]
                    ]
                ],
                'right' => [
                    'blocks' => [
                        [
                            'name'   => 'Settings',
                            'fields' => [
                                [
                                    [
                                        'label' => 'Active', 'name' => 'active', 'required' => true, 'type'  => 'select', 'options' => [1 => 'Yes', 0 => 'No']
                                    ],
                                ],
                            ]
                        ],
                        [
                            'name'   => 'Attributes',
                            'fields' => [
                                [
                                    [
                                        'label'     => 'Image', 'name' => 'image', 'required'  => true, 'hideLabel' => true, 'type' => 'image'
                                    ],
                                ],
                            ]
                        ]
                    ]
                ],
            ]
        ],
    ];

    protected $blockTitle2 = [
        'label'    => 'Title 2', 'name' => 'job_title_2', 'required' => false,
    ];

    protected $blockIntro = [
        'label'    => 'Intro', 'name' => 'intro', 'type' => 'textarea'
    ];

    protected $blockEmail = [
        'label' => 'Email', 'name' => 'email', 'required' => false, 'type'  => 'email'
    ];

    protected $blockPhone = [
        'label' => 'Phone', 'name' => 'phone', 'required' => false, 'type'  => 'tel'
    ];

    protected $blockMobile = [
        'label' => 'Mobile', 'name' => 'mobile', 'required' => false, 'type' => 'tel'
    ];

    protected $blockFax = [
        'label' => 'Fax', 'name' => 'fax', 'required' => false, 'type'  => 'tel'
    ];

    protected $blockContent = [
        'label'    => 'Content', 'name' => 'content', 'required' => true, 'type' => 'richtext'
    ];

    public function setFormFields()
    {
        $config      = config('team');
        $fields      = $this->formFields;
        if (isset($config['email']) && $config['email']) {
            $fields[0]['sections']['right']['blocks'][1]['fields'][] = [$this->blockEmail];
        }

        if (isset($config['phone']) && $config['phone']) {
            $fields[0]['sections']['right']['blocks'][1]['fields'][] = [$this->blockPhone];
        }

        if (isset($config['mobile']) && $config['mobile']) {
            $fields[0]['sections']['right']['blocks'][1]['fields'][] = [$this->blockMobile];
        }

        if (isset($config['fax']) && $config['fax']) {
            $fields[0]['sections']['right']['blocks'][1]['fields'][] = [$this->blockFax];
        }

        if (isset($config['title2']) && $config['title2']) {
            array_splice($fields[0]['sections']['left']['blocks'][0]['fields'][1], 1, 0, [$this->blockTitle2]);
        }

        if (isset($config['content']) && $config['content']) {
            array_splice($fields[0]['sections']['left']['blocks'][0]['fields'], 2, 0, [[$this->blockContent]]);
        }

        if (isset($config['intro']) && $config['intro']) {
            array_splice($fields[0]['sections']['left']['blocks'][0]['fields'], 2, 0, [[$this->blockIntro]]);
        }


        return $fields;
    }
}
