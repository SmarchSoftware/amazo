@extends( config('amazo.layout') )

@section( config('amazo.section') )

  @if ($errors->has())
  <div class="alert alert-danger">
  <strong>Whoops!</strong> Please correct the following errors:
  <ul>
    @foreach ($errors->all() as $error)
     <li>{{ $error }}</li>
    @endforeach
  </ul>
  </div>
  @endif

  <h3>'{{ $resource->name }}' Modifiers <button type="button" class="btn btn-xs btn-default" data-toggle="collapse" data-target="#modifierInfo" aria-expanded="false" aria-controls="modifierInfo"><i class="fa fa-question fa-fw fa-2x"></i> </button></h3>
  <div class="row">
   <div class="col-md-12 col-sm-12 col-xs-12 collapse" id="modifierInfo">
    <div class="panel panel-primary">
      <div class="panel-body">
      <button type="button" class="close" data-toggle="collapse" data-target="#modifierInfo" aria-label="Close" title="Close" aria-controls="modifierInfo" aria-expanded="true">&times;</button>
        <p><strong>Damage modifiers are completely optional.</strong> Say, for example, you already have a damage type called "Cold". Now say you wish to have an "Ice" damage type that deals "double" the  damage "Cold" performs whenever it hits. So you would create your "Ice" damage type and then give it a damage modifier to the "Cold" damage type with a "mulitplier" of "2.000". Now whenever your "Ice" damage type is applied it will double whatever the "Cold" damage was as well.</p>

        <pre class="collapse" id="collapseExample">
        $damage = "100"; //determined earlier in code.

        // i.e. $resource = "Cold" damage type object
        $totalDamage = $resource->addModifierDamage($damage)->totalDamage;
        //returns 300

        // addModifierDamage() returns an object with all the modifier and damage information
        dd( $resource->addModifierDamage($damage) );
        // returns
        public startingDamage -> integer 100
        public allModifierDamage -> integer 200
        public totalDamage -> integer 300
          →public modifiers -> stdClass(1)
            →public 0 -> stdClass(6)
            public message -> string(48) "fdsadf generated 200 damage (100 * 2.0000)"
            public parentName -> string(8) "Cold"
            public modifierName -> string(6) "Ice"
            public modifierAmount -> string(9) "2.0000"
            public modifierDamage -> string(6) "200"
            public modifierCumulative -> bool FALSE
            public modifierCumulativeAsString -> string(4) "Base"
            →public operator -> stdClass(2)
              public stringOperator -> string(1) "*"
              public bcOperator -> string(5) "bcmul"
        </pre>
        </p>

        <p class="col-xs-12 col-lg-12 bg-warning"><i class="fa fa-lightbulb-o fa-2x fa-pull-left fa-fw"></i> If you have more than one modifier, you can decide if the modifier applies to the base/starting damage or the total damage. All "Cumulative" modifiers run <strong>after</strong> base modifiers have already run.</p>

        <p><button type="button" class="btn btn-sm btn-default" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"> Toggle Example </button></p>
      </div>
    </div>
   </div>
  </div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-primary">
        <div class="panel-heading clearfix">
          <h3 class="panel-title"><i class="fa fa-users fa-lg"></i> Add Modifiers to {{ $resource->name }}</h3>
        </div>

        <div class="panel-body">
          <div class="row">
            <div class="col-xs-4">
              <label class="text-muted">Damage<span class="hidden-xs"> Type</span></label>
            </div>

            <div class="col-xs-3 text-center">
              <label class="text-muted"><span class="hidden-xs">Modifier Type </span></label>
            </div>

            <div class="col-xs-3 text-center">
              <label class="text-muted"><span class="hidden-xs">Amount </span>(+ or -)</label>
            </div>

            <div class="col-xs-2 text-right">
              <label class="text-muted">How<span class="hidden-xs"> To Apply</span></label>
            </div>
          </div>

          {!! Form::model($resource, ['_method' => 'PATCH', 'route' => [ config('amazo.route.as') . 'mods', $resource->id ], 'class' => 'form-horizontal']) !!}
          @for ($i = 0; $i < 3; $i++)
          <div class="form-group">
            <div class="col-xs-4">
              {!! Form::select("modifier[$i][damage]", $amazo, null, ['placeholder' => 'None', 'class' => 'form-control'] ) !!}
            </div>

            <div class="col-xs-3">
              {!! Form::select("modifier[$i][type]", array('*'=>'Multiplier (*)','+'=>'Additional (+/-)'), null, ['placeholder' => 'None', 'class' => 'form-control'] ) !!}
            </div>

            <div class="col-xs-3">
              {!! Form::number("modifier[$i][amount]", null, ['placeholder' => 'None', 'class' => 'form-control', 'step'=>'any'] ) !!}
            </div>

            <div class="col-xs-2">
              {!! Form::select("modifier[$i][cumulative]", array('0'=>'On Base','1'=>'On Total'), 0, ['class' => 'form-control'] ) !!}
            </div>
          </div>
          @endfor

          <div class="form-group">
            <div class="col-sm-3">
              {!! Form::submit("Update '$resource->name'", ['class' => 'btn btn-primary form-control']) !!}
            </div>
          </div>
          {!! Form::close() !!}
        </div>

        <div class="panel-footer">
          <div class="text-muted text-center"><em>Added modifiers *must* have a value in all 3 fields.</em></div>
        </div>
      </div>
    </div>
  </div>
  

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-primary">
        <div class="panel-heading clearfix">
          <h3 class="panel-title"><i class="fa fa-users fa-lg"></i> Current Modifiers for {{ $resource->name }}
          </h3>
        </div>
        
        <div class="panel-body">
          <div>  
            <div class="row">
              <div class="col-xs-5">
                <label class="text-muted">Damage<span class="hidden-xs"> Type</span></label>
              </div>

              <div class="col-xs-1 text-center">
                <label class="text-muted"><span class="hidden-xs">Mod</span></label>
              </div>

              <div class="col-xs-2 text-center">
                <label class="text-muted"><span class="hidden-xs">Amount </span>+/-</label>
              </div>

              <div class="col-xs-2 text-right">
                <label class="text-muted">How<span class="hidden-xs"> To Apply</span></label>
              </div>

              <div class="col-xs-1">
                    <span class="hidden-xs hidden-sm">Delete</span></label>
              </div>
            </div>
            @forelse($resource->modifiers as $item)
              <div class="row">
                <div class="col-xs-5">
                  <label>{{ $item->damageType->name }}</label>
                </div>

                <div class="col-xs-1 text-right">
                  <label>{{ $item->mod_type }}</label>
                </div>

                <div class="col-xs-2">
                  <label>{{ $item->amount }}</label>
                </div>

                <div class="col-xs-2 text-right">
                  <label>{{ $item->CumulativeString }}</label>
                </div>

                <div class="col-xs-1">
                  {!! Form::open(['method'=>'delete','route'=> [ config('amazo.route.as') . 'destroy.mod',$item->id], 'style' => 'display:inline']) !!}
                    <button type="submit" class="btn btn-danger btn-xs">
                    <i class="fa fa-trash-o fa-lg"></i> 
                    <span class="hidden-xs hidden-sm">Delete</span>
                    </button>
                  {!! Form::close() !!}
                </div>
              </div>

            @empty
              <div class="alert alert-warning">
                <i class="fa fa-warning fa-2x"></i> <span class="lead">There are no modifiers for {{ $resource->name }}.</span>
              </div>
            @endforelse
          </div>
        </div>

        <div class="panel-footer">
          <div class="row">
            <div class="col-sm-12 text-primary text-center">
            @if (count($resource->modifiers) > 0)
              <em>With a starting damage of 100, these modifiers would add {!! $modDamage->allModifierDamage !!} damage for a total of {!! $modDamage->totalDamage !!} </em> <button type="button" class="btn btn-xs btn-default pull-right" data-toggle="collapse" data-target="#collapseExplain" aria-expanded="false" aria-controls="collapseExplain"> Explain </button>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-11 col-xs-offset-1 col-sm-10 col-sm-offset-2 col-md-9 col-md-offset-3 text-default collapse" id="collapseExplain">
              @foreach ($modDamage->modifiers as $mod)
               <li>{!! $mod->message !!}</li>
              @endforeach
            @else
              <em>There are no modifiers for {{ $resource->name }}.</em>
            @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection