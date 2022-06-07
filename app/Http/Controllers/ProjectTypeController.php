<?php

namespace App\Http\Controllers;

use App\Helper\Reply;
use App\Http\Requests\ProjectTemplate\StoreProjectType;
use App\Models\BaseModel;
use App\Models\Project_type;
use Illuminate\Http\Request; //asli dari controllernya

class ProjectTypeController extends AccountBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->addPermission = user()->permission('manage_project_category');
        abort_403(!in_array($this->addPermission, ['all', 'added']));

        $this->semuaTipeProyek = Project_type::all();

        return view('projects.create_tipeprojek', $this->data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectType $request)
    {
        $this->addPermission = user()->permission('manage_project_category');
        abort_403(!in_array($this->addPermission, ['all', 'added']));

        $projek = new Project_type(); //menyiapkan var projek
        $projek->project_type_name = $request->project_type_name; 
        $projek->save();

        $tipeprojek = Project_type::all();

        $options = BaseModel::options($tipeprojek, $projek, 'project_type_name');

        return Reply::successWithData(__('messages.categoryAdded'), ['data' => $options]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProjectType $request, $id)
    {
        $projek = Project_type::find($id);
        $projek->project_type_name = strip_tags($request->project_type_name);
        $projek->save();

        $tipeprojek = Project_type::allTipeprojek();
        $options = BaseModel::options($tipeprojek, null, 'project_type_name');

        return Reply::successWithData(__('messages.updatedSuccessfully'), ['data' => $options]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Project_type::destroy($id);
        $tipeprojek = Project_type::allTipeprojek();
        $options = BaseModel::options($tipeprojek, null, 'project_type_name');

        return Reply::successWithData(__('messages.deleteSuccess'), ['data' => $options]);
    }
}
