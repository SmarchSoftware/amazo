@extends( config('%%crudNameSingular%%.layout') )

@section( config('%%crudNameSingular%%.section') )

    <h1>Create New Amazo</h1>
    <hr/>

    {!! Form::open( ['route' => '%%crudNameSingular%%.store', 'class' => 'form-horizontal'] ) !!}

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
                    {!! Form::text('notes', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('notes', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('enabled') ? 'has-error' : ''}}">
                {!! Form::label('enabled', 'Enabled: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                                <div class="checkbox">
                <label>{!! Form::radio('enabled', '1') !!} Yes</label>
            </div>
            <div class="checkbox">
                <label>{!! Form::radio('enabled', '0', true) !!} No</label>
            </div>
                    {!! $errors->first('enabled', '<p class="help-block">:message</p>') !!}
                </div>
            </div>


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection