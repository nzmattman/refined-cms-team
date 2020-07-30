<?php

namespace RefinedDigital\Team\Module\Http\Controllers;

use Illuminate\Http\Request;
use RefinedDigital\CMS\Modules\Core\Http\Controllers\CoreController;
use RefinedDigital\Team\Module\Http\Requests\TeamRequest;
use RefinedDigital\Team\Module\Http\Repositories\TeamRepository;
use RefinedDigital\CMS\Modules\Core\Http\Repositories\CoreRepository;

class TeamController extends CoreController
{
    protected $model = 'RefinedDigital\Team\Module\Models\Team';
    protected $prefix = 'team::';
    protected $route = 'team';
    protected $heading = 'Team';
    protected $button = 'a Team Member';

    protected $teamRepository;

    public function __construct(CoreRepository $coreRepository)
    {
        $this->teamRepository = new TeamRepository();
        $this->teamRepository->setModel($this->model);

        parent::__construct($coreRepository);
    }

    public function setup() {

        $table = new \stdClass();
        $table->fields = [
            (object) [ 'name' => '#', 'field' => 'id', 'sortable' => true, 'classes' => ['data-table__cell--id']],
            (object) [ 'name' => 'Name', 'field' => 'name', 'sortable' => true],
            (object) [ 'name' => 'Title', 'field' => 'job_title_1', 'sortable' => true],
            (object) [ 'name' => 'Active', 'field' => 'active', 'type'=> 'select', 'options' => [1 => 'Yes', 0 => 'No'], 'sortable' => true, 'classes' => ['data-table__cell--active']],
        ];
        $table->routes = (object) [
            'edit'      => 'refined.team.edit',
            'destroy'   => 'refined.team.destroy'
        ];
        $table->sortable = true;

        $this->table = $table;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($item)
    {
        // get the instance
        $data = $this->model::findOrFail($item);

        // todo: make this more dynamic
        if (isset($data->data) && is_object($data->data)) {
            foreach ($data->data as $key => $value) {
                $data->{'data__'.$key} = $value;
            }
        }

        return parent::edit($data);
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(TeamRequest $request)
    {
        return parent::storeRecord($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TeamRequest $request, $id)
    {
        return parent::updateRecord($request, $id);
    }


    public function getForFront(Request $request)
    {
        $data = $this->teamRepository->getForFront($request->get('perPage'));
        return parent::formatGetForFront($data, $request);
    }

}
