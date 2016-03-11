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

    <h1>Create New Damage Type</h1>
    <hr/>

    {!! Form::open( ['route' =>  config('amazo.route.as') . 'store', 'class' => 'form-horizontal'] ) !!}

    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
        {!! Form::label('name', 'Name: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('slug') ? 'has-error' : ''}}">
        {!! Form::label('slug', 'Slug: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('slug', null, ['class' => 'form-control', 'required' => 'required']) !!}
            {!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    
    <div class="form-group {{ $errors->has('notes') ? 'has-error' : ''}}">
        {!! Form::label('notes', 'Notes: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::textarea('notes', null, ['class' => 'form-control']) !!}
            {!! $errors->first('notes', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('enabled') ? 'has-error' : ''}}">
        {!! Form::label('enabled', 'Enabled: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-3">
            <div class="btn-group" data-toggle="buttons">
              <label class="btn btn-primary">
                {!! Form::radio('enabled',1, null, ['class' => 'form-control'] ) !!} Yes
              </label>

              <label class="btn btn-primary">
                {!! Form::radio('enabled',0, null, ['class' => 'form-control'] ) !!} No
              </label>

              <label data-toggle="tooltip" data-placement="right" class="btn btn-default" title="Currently in use?">
                <i class="fa fa-lg fa-question-circle"></i>
              </label>
            </div>
        </div>
        
        <div class="col-sm-3 text-right">
            <button type="button" class="btn btn-sm btn-default" data-toggle="collapse" data-target="#collapseModifiers" aria-expanded="false" aria-controls="collapseModifiers"> <i class="fa fa-plus"></i> Add Damage Modifiers</a>
        </div>
        {!! $errors->first('enabled', '<div class="col-sm-6 col-sm-offset-3 text-danger">:message</div>') !!}
    </div>
    
    <div class="form-group collapse" id="collapseModifiers">
        <label class="col-sm-3 control-label">Damage Modifiers:<br /><em class="text-muted">(Optional)</em></label>        
        <div class="col-sm-6">
            <div class="panel panel-default" style="margin-bottom:0;">
                <div class="panel-heading">
                   <h2 class="panel-title">You can add up to 3 modifiers now. You can always add more later.</h2>
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
                </div>
                    
                <div class="panel-footer">
                    <div class="text-muted text-center"><em>Added modifiers *must* have a value in all 3 fields.</em></div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection