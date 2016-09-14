<?php

namespace Smarch\Amazo\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Smarch\Amazo\Models\Amazo;
use Smarch\Amazo\Models\AmazoMods;
use Smarch\Amazo\Requests\StoreRequest;
use Smarch\Amazo\Requests\UpdateRequest;
use Smarch\Amazo\Requests\UpdateModsRequest;

use Smarch\Omac\OmacTrait;

class AmazoController extends Controller
{
    use OmacTrait;

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
            $amazo = Amazo::lists('name','id');
            return view( config('amazo.views.create'), compact('amazo') );
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
        if ( $this->checkAccess( config('amazo.acl.create') ) ) {
            $data = Amazo::create($request->all());
            $this->updateModifiers($data->id, $request, 1);        
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroyModifier($id)
    {
        if ( $this->checkAccess( config('amazo.acl.destroy_mod') ) ) {
            AmazoMods::destroy($id);
            return redirect()->route('amazo.index')
                ->with( ['flash' => ['message' => "<i class='fa fa-check-square-o fa-1x'></i> Success! Damage Modifier deleted.", 'level' => "warning"] ] );
        }

        return redirect()->route('amazo.index')
            ->with( ['flash' => ['message' => "You are not permitted to destroy damage modifiers.", 'level' => "danger"] ] );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function modifiers($id)
    {
        if ( $this->checkAccess( config('amazo.acl.show_mods') ) ) {
            $resource = Amazo::findOrFail($id);
            $amazo = Amazo::where('id','!=',$id)->lists('name','id');
            $modDamage = $resource->addModifierDamage('100');
            return view( config('amazo.views.modifiers'), compact('resource', 'amazo', 'modDamage') );
        }
        
        return view( $this->unauthorized, ['message' => 'view damage type modifiers'] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function updateModifiers($id, Request $request, $new = 0)
    {
        // Modify the request
        $request['attending'] = true;

        // Execute validation manually
        app('Smarch\Amazo\Requests\UpdateModsRequest');

        if ( $this->checkAccess( config('amazo.acl.add_mod') ) ) {
            $filtered = array_filter( array_map('array_filter', $request->modifier) );

            if ( empty( $filtered ) ) {
                
                // new requests can be empty
                if ($new == 1) {
                    return;
                }

                return redirect()
                    ->back()
                    ->withErrors("No damage modifiers selected.");
            }
            
            foreach($filtered as $mod) {
                if ($id == $mod['damage']) {
                    continue;
                }
                $data = [ 
                    'damage_type_id' => $mod['damage'],
                    'mod_type' => $mod['type'],
                    'amount' => $mod['amount'],
                    'parent_id' => $id
                ];
                AmazoMods::create($data);
            }

            return redirect()->route('amazo.index')
                    ->with( ['flash' => ['message' => "<i class='fa fa-check-square-o fa-1x'></i> Success! Damage modifiers added.", 'level' => "success"] ] );
        }
        
        return redirect()->route('amazo.index')
            ->with( ['flash' => ['message' => "You are not permitted to create damage types", 'level' => "danger"] ] );
    }

}
