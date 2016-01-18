<?php

namespace Smarch\Amazo\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Smarch\Amazo\Models\Amazo;
use Smarch\Amazo\Requests\StoreRequest;
use Smarch\Amazo\Requests\UpdateRequest;

class AmazoController extends Controller
{

    /**
     * Will check user access depending on the driver being used.
     * Defaults to using laravel Auth Guard driver
     * @param  [string] $permission
     * @return [boolean]
     */
    protected function checkAccess($permission)
    {
        $result = false;

        $driver = config('amazo.acl.driver');

        if ($driver  == 'shinobi' ) { 
            $result = \Shinobi::can($permission);
        } elseif ($driver == 'sentinel') {
            $result = \Sentinel::hasAccess($permission);
        } else {
            $result = \Auth::user()->can($permission);
        }

        return $result; 
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if ( config('amazo.acl.enable') && ( ! $this->checkAccess( config('amazo.acl.index') ) ) ) {
            return view( config('amazo.views.unauthorized'), [ 'message' => 'view damage types list' ]);
        }

        $amazo = Amazo::paginate( config('amazo.pagination', 15) );
        return view( config('amazo.views.index'), compact('amazo') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if ( config('amazo.acl.enable') && ( ! $this->checkAccess( config('amazo.acl.create') ) ) ) {
            return view( config('amazo.views.unauthorized'), [ 'message' => 'create new damage type' ]);
        }

        return view(  config('amazo.views.create') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        if ( config('amazo.acl.enable') && ( ! $this->checkAccess( config('amazo.acl.create') ) ) ) {
            $level = "danger";
            $message = "You are not permitted to create damage types";
            return redirect()->route('amazo.index')
                ->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
        }
        
        Amazo::create($request->all());
        $level = "success";
        $message = "<i class='fa fa-check-square-o fa-1x'></i> Success! Damage type created.";
        
        return redirect()->route('amazo.index')
                ->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        if ( config('amazo.acl.enable') && ( ! $this->checkAccess( config('amazo.acl.show') ) ) ) {
            return view( config('amazo.views.unauthorized'), [ 'message' => 'view existing damage types' ]);
        }

        $resource = Amazo::findOrFail($id);
        $show = "1";
        return view( config('amazo.views.edit'), compact('resource', 'show') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if ( config('amazo.acl.enable') && ( ! $this->checkAccess( config('amazo.acl.edit') ) ) ) {
            return view( config('amazo.views.unauthorized'), [ 'message' => 'edit existing damage types' ]);
        }

        $resource = Amazo::findOrFail($id);
        $show = "0";
        return view( config('amazo.views.edit'), compact('resource', 'show') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function update($id, UpdateRequest $request)
    {
        if ( config('amazo.acl.enable') && ( ! $this->checkAccess( config('amazo.acl.edit') ) ) ) {
            $level = "danger";
            $message = "You are not permitted to edit damage types.";
            
            return redirect()->route('amazo.index')
                    ->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
        }

        $amazo = Amazo::findOrFail($id);      
        $amazo->update($request->all());
        $level = "success";
        $message = "<i class='fa fa-check-square-o fa-1x'></i> Success! Damage type edited.";
        
        return redirect()->route('amazo.index')
                ->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if ( config('amazo.acl.enable') && ( ! $this->checkAccess( config('amazo.acl.destroy') ) ) ) {
            $level = "danger";
            $message = " You are not permitted to destroy damage types.";
            return redirect()->route('amazo.index')
                ->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
        }

        Amazo::destroy($id);
        $level = "warning";
        $message = "<i class='fa fa-check-square-o fa-1x'></i> Success! Damage type deleted.";

        return redirect()->route('amazo.index')
                ->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
    }

}
