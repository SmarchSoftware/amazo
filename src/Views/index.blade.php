@extends( config('%%crudNameSingular%%.layout') )

@section( config('%%crudNameSingular%%.section') )

    <h1><i class="fa fa-money fa-fw"></i> {{ config('%%crudNameSingular%%.title', 'Amazo') }}
    <div class="btn-group pull-right" role="group" aria-label="..."> 
      
        <a href="{{ route('%%crudNameSingular%%.create') }}">
        <button type="button" class="btn btn-info">
          <i class="fa fa-plus fa-fw"></i> 
          <span class="hidden-xs hidden-sm">Add New Amazo</span>
        </button></a>
      
    </div>
    </h1>

    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Name</th><th>Slug</th><th>Notes</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($amazo as $item)
                <tr>
                    <td><a href="{{ url('amazo', $item->id) }}">{{ $item->name }}</a></td><td>{{ $item->slug }}</td><td>{{ $item->notes }}</td>
                
                    <td>
                        <a href="{{ route('%%crudNameSingular%%.show', $item->id) }}">
                          <button type="button" class="btn btn-primary btn-xs">
                          <i class="fa fa-search fa-fw"></i> 
                          <span class="hidden-xs hidden-sm">View</span>
                          </button></a>

                        <a href="{{ route('%%crudNameSingular%%.edit', $item->id) }}">
                          <button type="button" class="btn btn-default btn-xs">
                          <i class="fa fa-pencil fa-fw"></i> 
                          <span class="hidden-xs hidden-sm">Edit</span>
                          </button></a>

                        {!! Form::open(['method'=>'delete','route'=> ['%%crudNameSingular%%.destroy',$item->id], 'style' => 'display:inline']) !!}
                          <button type="submit" class="btn btn-danger btn-xs">
                          <i class="fa fa-trash-o fa-lg"></i> 
                          <span class="hidden-xs hidden-sm">Delete</span>
                          </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
              @empty
                <tr><td>There are no amazo</td></tr>
              @endforelse
            </tbody>
        </table>
        <div class="pagination"> {!! $amazo->render() !!} </div>
    </div>

@endsection
