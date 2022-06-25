<?php

namespace App\Http\Controllers;

use App\Helper\Reply;
use App\Http\Requests\ProjectTemplate\StorePosAnggaran;
use App\Models\BaseModel;
use App\Models\Pos_anggaran;
use Illuminate\Http\Request; //asli dari controllernya

class PosAnggaranController extends AccountBaseController
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

        $this->semuaPosAnggaran = Pos_Anggaran::allPosAnggaran();

        return view('projects.create_posanggaran', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePosAnggaran $request)
    {
        $this->addPermission = user()->permission('manage_project_category');
        abort_403(!in_array($this->addPermission, ['all', 'added']));

        $pos_anggaran = new Pos_Anggaran(); //menyiapkan var projek
        $pos_anggaran->pos_anggaran_name = $request->pos_anggaran_name; 
        $pos_anggaran->save();

        $posanggaran = Pos_Anggaran::allPosAnggaran();

        $options = BaseModel::options($posanggaran, $pos_anggaran, 'pos_anggaran_name');

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
    public function update(StorePosAnggaran $request, $id)
    {
        $pos_anggaran = Pos_Anggaran::find($id);
        $pos_anggaran->pos_anggaran_name = strip_tags($request->pos_anggaran_name);
        $pos_anggaran->save();

        $posanggaran = Pos_Anggaran::allPosAnggaran();
        $options = BaseModel::options($posanggaran, null, 'pos_anggaran_name');

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
        Pos_Anggaran::destroy($id);
        $posanggaran = Pos_Anggaran::allPosAnggaran();
        $options = BaseModel::options($posanggaran, null, 'pos_anggaran_name');

        return Reply::successWithData(__('messages.deleteSuccess'), ['data' => $options]);
    }
}
