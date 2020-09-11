<?php

namespace RefinedDigital\Team\Module\Http\Repositories;

use RefinedDigital\Team\Module\Models\Team;
use RefinedDigital\CMS\Modules\Core\Http\Repositories\CoreRepository;

class TeamRepository extends CoreRepository
{

    public function __construct()
    {
        $this->setModel('RefinedDigital\Team\Module\Models\Team');
    }

    public function getForFront($perPage = 5)
    {
        return $this->model::active()
            ->search(['name','content'])
            ->ordered()
            ->paging($perPage);
    }

    public function getAllForFront()
    {
        return $this->model::active()
                            ->ordered()
                            ->get();
    }

    public function getForHomePage($limit = 6)
    {
        return $this->model::active()
            ->ordered()
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
