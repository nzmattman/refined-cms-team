<?php

namespace RefinedDigital\Team\Module\Http\Repositories;

use RefinedDigital\Team\Module\Models\Team;
use RefinedDigital\CMS\Modules\Core\Http\Repositories\CoreRepository;
use RefinedDigital\CMS\Modules\Tags\Models\Tag;

class TeamRepository extends CoreRepository
{

    public function __construct()
    {
        $this->setModel('RefinedDigital\Team\Module\Models\Team');
    }

    public function getForFront($perPage = 5)
    {
        $data = $this->model::with(['meta', 'meta.template'])
            ->whereActive(1)
            ->search(['name','content'])
            ->paging($perPage);

        return $data;
    }

    public function getForHomePage($limit = 6)
    {
        return $this->model::with(['meta', 'meta.template'])
            ->whereActive(1)
            ->limit($limit)
            ->get();
    }

    public function getForSelect()
    {
        $posts = Team::active()->orderBy('name', 'asc')->get();
        $data = [];
        if ($posts->count()) {
            foreach ($posts as $post) {
                $data[] = [
                    'id' => $post->id,
                    'name' => $post->name,
                ];
            }
        }

        return $data;
    }
}
