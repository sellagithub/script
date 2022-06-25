<?php

namespace App\Http\Controllers;

use App\Helper\Reply;
use App\Http\Requests\ProjectTemplate\StoreRekanan;
use App\Models\BaseModel;
use App\Models\Rekanan;
use Illuminate\Http\Request; //asli dari controllernya

class RekananController extends Controller
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

        $this->semuaRekanan = Rekanan::all();

        return view('projects.create_rekanan', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRekanan $request)
    {
        $this->addPermission = user()->permission('manage_project_category');
        abort_403(!in_array($this->addPermission, ['all', 'added']));

        $pilihrekanan = new Rekanan(); //menyiapkan var projek
        $pilihrekanan->rekanan_name = $request->rekanan_name; 
        $pilihrekanan->save();

        $rekanan = Rekanan::all();

        $options = BaseModel::options($rekanan, $pilihrekanan, 'rekanan_name');

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
    public function update(StoreRekanan $request, $id)
    {
        $pilihrekanan = Rekanan::find($id);
        $pilihrekanan->rekanan_name = strip_tags($request->rekanan_name);
        $pilihrekanan->save();

        $rekanan = Rekanan::all();
        $options = BaseModel::options($rekanan, null, 'rekanan_name');

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
        Rekanan::destroy($id);
        $rekanan = Rekanan::all();
        $options = BaseModel::options($rekanan, null, 'rekanan_name');

        return Reply::successWithData(__('messages.deleteSuccess'), ['data' => $options]);
    }
}
