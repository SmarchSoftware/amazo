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

  <h3>'{{ $resource->name }}' Modifiers</h3>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-primary">
        <div class="panel-heading clearfix">
          <h3 class="panel-title"><i class="fa fa-users fa-lg"></i> Add Modifiers to {{ $resource->name }}</h3>
        </div>

        <div class="panel-body">
          <div class="row">
            <div class="col-sm-5">
              <label class="text-muted">Damage Type</label>
            </div>

            <div class="col-sm-3 text-center">
              <label class="text-muted">Amount (+ or -)</label>
            </div>

            <div class="col-sm-4 text-right">
              <label class="text-muted">Modifier Type</label>
            </div>
          </div>

          {!! Form::model($resource, ['_method' => 'PATCH', 'route' => [ config('amazo.route.as') . 'mods', $resource->id ], 'class' => 'form-horizontal']) !!}
          @for ($i = 0; $i < 3; $i++)
          <div class="form-group">
            <div class="col-sm-5">
              {!! Form::select("modifier[$i][damage]", $amazo, null, ['placeholder' => 'None', 'class' => 'form-control'] ) !!}
            </div>

            <div class="col-sm-3">
              {!! Form::number("modifier[$i][amount]", null, ['placeholder' => 'None', 'class' => 'form-control', 'step'=>'any'] ) !!}
            </div>

            <div class="col-sm-4">
              {!! Form::select("modifier[$i][type]", array('*'=>'Multiplier (*)','+'=>'Additive (+/-)'), null, ['placeholder' => 'None', 'class' => 'form-control'] ) !!}
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
              <div class="col-sm-5">
                <label class="text-muted">Damage Type</label>
              </div>

              <div class="col-sm-3">
                <label class="text-muted">Amount (+ or -)</label>
              </div>

              <div class="col-sm-3 text-right">
                <label class="text-muted">Modifier Type</label>
              </div>

              <div class="col-sm-1">
                <label class="text-muted">Delete</label>
              </div>
            </div>
            @forelse($resource->modifiers as $item)

              <div class="row">
                <div class="col-sm-5">
                  <label>{{ $item->damageType->name }}</label>
                </div>

                <div class="col-sm-3">
                  <label>{{ $item->amount }}</label>
                </div>

                <div class="col-sm-3 text-right">
                  <label>{{ $item->mod_type }}</label>
                </div>

                <div class="col-sm-1">
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
      </div>
    </div>
  </div>

@endsection