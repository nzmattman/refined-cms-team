<?php

namespace RefinedDigital\Team\Module\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use RefinedDigital\CMS\Modules\Core\Models\CoreModel;
use RefinedDigital\CMS\Modules\Core\Traits\IsArticle;
use RefinedDigital\CMS\Modules\Pages\Traits\IsPage;

class Team extends CoreModel
{
    use SoftDeletes, IsPage, IsArticle;

    protected $order = [ 'column' => 'position', 'direction' => 'asc'];

    protected $fillable = [
        'active', 'position', 'name', 'image', 'content', 'title','sub_title','phone','mobile','fax','email'
    ];

    /**
     * The fields to be displayed for creating / editing
     *
     * @var array
     */
    public $formFields = [
        [
            'name' => 'Content',
            'fields' => [
                [
                    [ 'label' => 'Active', 'name' => 'active', 'required' => true, 'type' => 'select', 'options' => [1 => 'Yes', 0 => 'No'] ],
                    [ 'label' => 'Name', 'name' => 'name', 'required' => true, 'attrs' => ['v-model' => 'content.name', '@keyup' => 'updateSlug' ] ],
                ],
                [
                    [ 'label' => 'Title', 'name' => 'title', 'required' => false, ],
                    [ 'label' => 'Sub Title', 'name' => 'sub_title', 'required' => false, ],
                    [ 'label' => 'Email', 'name' => 'email', 'required' => false, 'type' => 'email' ],
                ],
                [
                    [ 'label' => 'Phone', 'name' => 'phone', 'required' => false, 'type' => 'tel' ],
                    [ 'label' => 'Mobile', 'name' => 'mobile', 'required' => false, 'type' => 'tel' ],
                    [ 'label' => 'Fax', 'name' => 'fax', 'required' => false, 'type' => 'tel' ],
                ],
                [
                    [ 'label' => 'Content', 'name' => 'content', 'required' => true, 'type' => 'richtext' ],
                ],
            ]
        ]
    ];
}
