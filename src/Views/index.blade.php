@extends( config('amazo.layout') )

@section( config('amazo.section') )

    <h1><i class="fa fa-hand-rock-o fa-fw"></i> {{ config('amazo.title', 'Damage Type') }}
    <div class="btn-group pull-right" role="group" aria-label="..."> 
      
        <a href="{{ route( config('amazo.route.as') . 'create') }}">
        <button type="button" class="btn btn-info">
          <i class="fa fa-plus fa-fw"></i> 
          <span class="hidden-xs hidden-sm">Add New Damage Type</span>
        </button></a>
      
    </div>
    </h1>

    <div class="table">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th><th class="hidden-xs hidden-sm">Slug</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($amazo as $item)
                <tr>
                    <td>
                      <a href="{{ url('amazo', $item->id) }}">{{ $item->name }}</a>
                    </td>

                    <td class="hidden-xs hidden-sm">{{ $item->slug }}</td>
                
                    <td>
                        <a href="{{ route( config('amazo.route.as') . 'show', $item->id) }}">
                          <button type="button" class="btn btn-primary btn-xs">
                          <i class="fa fa-search fa-fw"></i> 
                          <span class="hidden-xs hidden-sm">View</span>
                          </button></a>

                        <a href="{{ route( config('amazo.route.as') . 'edit', $item->id) }}">
                          <button type="button" class="btn btn-default btn-xs">
                          <i class="fa fa-pencil fa-fw"></i> 
                          <span class="hidden-xs hidden-sm">Edit</span>
                          </button></a>

                        <a href="{{ route( config('amazo.route.as') . 'mods', $item->id) }}">
                          <button type="button" class="btn btn-warning btn-xs">
                          <i class="fa fa-cube"></i> 
                          <span class="hidden-xs hidden-sm">Modifiers</span>
                          </button></a>

                        {!! Form::open(['method'=>'delete','route'=> [ config('amazo.route.as') . 'destroy',$item->id], 'style' => 'display:inline']) !!}
                          <button type="submit" class="btn btn-danger btn-xs">
                          <i class="fa fa-trash-o fa-lg"></i> 
                          <span class="hidden-xs hidden-sm">Delete</span>
                          </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
              @empty
                <tr><td>There are no damage types defined yet</td></tr>
              @endforelse
            </tbody>
        </table>
        <div class="pagination"> {!! $amazo->render() !!} </div>
    </div>

@endsection
