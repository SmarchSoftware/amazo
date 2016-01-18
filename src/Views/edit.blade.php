@extends( config('amazo.layout') )

@section( config('amazo.section') )

    <h1>{{ ( ($show == '0') ? 'Edit' : 'Viewing' ) }}  {{ $resource->name }}</h1>
    <hr/>

    {!! Form::model($resource, ['method' => 'PATCH', 'route' => [ 'amazo.update', $resource->id ], 'class' => 'form-horizontal']) !!}
    {!! Form::hidden('id', $resource->id) !!}    

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
            <div class="btn-group" data-toggle="buttons">
              <label class="btn btn-sm btn-primary{{ $resource->enabled == 1 ? ' active' : '' }}">
                {!! Form::radio('enabled',1, null, ['class' => 'form-control'] ) !!} Yes
              </label>

              <label class="btn btn-sm btn-primary{{ $resource->enabled == 0 ? ' active' : '' }}">
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
           @if ($show == '0')
            {!! Form::submit('Edit', ['class' => 'btn btn-primary form-control']) !!}
           @else
                <i class="fa fa-pencil"></i> 
                <a href="{{ route('amazo.edit', $resource->id) }}" title="Edit '{{ $resource->name }}'">Edit '{{ $resource->name }}'</a>
           @endif
        </div>    
    </div>

@endsection