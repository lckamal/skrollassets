<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Floor;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FloorsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage_floors');
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $floors = Floor::filter()->paginate(30);
        $page_start = ( \Request::get('page', 1) - 1 )* 30;
        
        return View('floors.index', compact('floors', 'page_start'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formTitle = 'Create Floor';

        return View('floors.form', compact('floors', 'formTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'building_id' => 'required',
            'image' => 'mimes:png,jpeg,jpg',
        ]);

        $floor = new Floor($request->all());
        $floor->save();
        $floor->saveImage($request);

        flash()->success('Success!', 'Floor created successfully');

        return redirect('/floors?building_id='.$floor->building_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $floor = Floor::findOrFail($id);
        $view = \Request::get('view', 'map');
        $loadview = $view == 'map' ? 'floors.map' : 'floors.show';

        return View($loadview, ['floor' => $floor]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $floor = Floor::findOrFail($id);
        $formTitle = 'Edit floor';
        return View('floors.form', compact('floor', 'formTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'building_id' => 'required',
            'image' => 'mimes:png,jpg,jpeg',
        ]);

        $floor = Floor::findOrFail($id);
        $floor->update($request->all());
        $floor->saveImage($request);
        
        flash()->success('Success!', 'Floor updated successfully!');
        return redirect('/floors?building_id='.$floor->building_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
