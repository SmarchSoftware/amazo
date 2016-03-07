@extends( config('amazo.layout') )

@section( config('amazo.section') )

    <h1>Create New Damage Type</h1>
    <hr/>

    {!! Form::open( ['route' => 'amazo.store', 'class' => 'form-horizontal'] ) !!}

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
    
    <div class="form-group">
        {!! Form::label('mods', 'Damage Modifiers: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            <div class="panel panel-default" style="margin-bottom:0;">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-9">
                            <label>Damage Type</label>
                        </div>

                        <div class="col-sm-3">
                            <label class="pull-right">% (+ or -)</label>
                        </div>
                    </div>

                    <div class="form-group" id="modifiers">
                        <div class="col-sm-9">
                            {!! Form::select('modifier[]', array('one'=>'One','one2'=>'One2','one3'=>'One3','one4'=>'One4'), null, ['placeholder' => 'No modifier.', 'class' => 'form-control'] ) !!}
                        </div>

                        <div class="col-sm-3">
                            <input type="number" placeholder="1" value=0 name="modifier_amount[]" class="form-control">
                        </div>
                    </div>

                    <div class="btn-group" role="group" aria-label="...">
                        <div class="input-group" onClick="$('.moreModifiers').prepend( $('#modifiers').clone() );">
                            <input type="text" class="form-control" placeholder="Add Another Modifier" readonly aria-describedby="basic-addon2">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><i class="fa fa-plus fa-lg fa-fw"></i></button>
                            </span>
                        </div>
                    </div>

                    <div class="moreModifiers" style="max-height:8em; overflow-x:hidden; margin-top:1em;">
                        <small class="col-sm-12 text-muted text-center"><em>Added modifiers with empty type or % will be ignored</em></small>
                    </div>
                </div>
            </div>
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
        <div class="col-sm-6">
            <div class="btn-group" data-toggle="buttons">
              <label class="btn btn-sm btn-primary">
                {!! Form::radio('enabled',1, null, ['class' => 'form-control'] ) !!} Yes
              </label>

              <label class="btn btn-sm btn-primary">
                {!! Form::radio('enabled',0, null, ['class' => 'form-control'] ) !!} No
              </label>

              <label data-toggle="tooltip" data-placement="right" class="btn btn-sm btn-default" title="Currently in use?">
                <i class="fa fa-lg fa-question-circle"></i>
              </label>
            </div>
        </div>      
        {!! $errors->first('enabled', '<div class="col-sm-6 col-sm-offset-3 text-danger">:message</div>') !!}
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection