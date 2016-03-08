<?php

namespace Smarch\Amazo\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Smarch\Amazo\Models\Amazo;
use Smarch\Amazo\Requests\StoreRequest;
use Smarch\Amazo\Requests\UpdateRequest;
use Smarch\Amazo\Traits\SmarchACLTrait;

class AmazoController extends Controller
{

    use SmarchACLTrait;

    var $acl = false;
    var $driver = 'laravel';

    /**
     * constructor
     * 
     * @param boolean acl Whether or not ACL is enabled
     * @param string $driver Which ACL package to use
     */
    public function __construct() {
        $this->acl = config('amazo.acl.enable');
        $this->driver = config('amazo.acl.driver');
        $this->unauthorized = config('amazo.views.unauthorized');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if ( $this->checkAccess( config('amazo.acl.index') ) ) {
            $amazo = Amazo::paginate( config('amazo.pagination', 15) );
            return view( config('amazo.views.index'), compact('amazo') );
        }

        return view( $this->unauthorized, ['message' => 'view damage types list'] );        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if ( $this->checkAccess( config('amazo.acl.create') ) ) {
            return view( config('amazo.views.create') );
        }
        
        return view( $this->unauthorized, ['message' => 'create new damage type'] );        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        $message = ['Begins'];
        if ( $request->has('mod_damage') ) {
        $md = $request->get('mod_damage');
        ddd($request->all());
        $ma = $request->get('mod_amount');
        $mt = $request->get('mod_type');
            for($i=0;$i<count($md);$i++) {
                $message[] =  $md[$i] . " " . $mt[$i] . " " . $ma[$i];
            }
        }
        ddd($message); /* */


        if ( $this->checkAccess( config('amazo.acl.create') ) ) {
            Amazo::create($request->all());            
            return redirect()->route('amazo.index')
                    ->with( ['flash' => ['message' => "<i class='fa fa-check-square-o fa-1x'></i> Success! Damage type created.", 'level' => "success"] ] );
        }
        
        return redirect()->route('amazo.index')
            ->with( ['flash' => ['message' => "You are not permitted to create damage types", 'level' => "danger"] ] );
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
        if ( $this->checkAccess( config('amazo.acl.show') ) ) {
            $resource = Amazo::findOrFail($id);
            $show = "1";
            return view( config('amazo.views.edit'), compact('resource', 'show') );
        }
        
        return view( $this->unauthorized, ['message' => 'view existing damage types'] );
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
        if ( $this->checkAccess( config('amazo.acl.edit') ) ) {
            $resource = Amazo::findOrFail($id);
            $show = "0";
            return view( config('amazo.views.edit'), compact('resource', 'show') );            
        }
        
        return view( $this->unauthorized, ['message' => 'edit existing damage types'] );
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
        if ( $this->checkAccess( config('amazo.acl.edit') ) ) {
            $amazo = Amazo::findOrFail($id);      
            $amazo->update($request->all());        
            return redirect()->route('amazo.index')
                ->with( ['flash' => ['message' => "<i class='fa fa-check-square-o fa-1x'></i> Success! Damage type edited.", 'level' => "success"] ] );
        }

        return redirect()->route('amazo.index')
            ->with( ['flash' => ['message' => "You are not permitted to edit damage types.", 'level' => "danger"] ] );
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
        if ( $this->checkAccess( config('amazo.acl.destroy') ) ) {
            Amazo::destroy($id);
            return redirect()->route('amazo.index')
                ->with( ['flash' => ['message' => "<i class='fa fa-check-square-o fa-1x'></i> Success! Damage type deleted.", 'level' => "warning"] ] );
        }

        return redirect()->route('amazo.index')
            ->with( ['flash' => ['message' => "You are not permitted to destroy damage types.", 'level' => "danger"] ] );

    }

}
