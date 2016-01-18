@extends('layouts.master')

@section('content')

    <h1>Amazo</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID.</th> <th>Name</th><th>Slug</th><th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $amazo->id }}</td> <td> {{ $amazo->name }} </td><td> {{ $amazo->slug }} </td><td> {{ $amazo->notes }} </td>
                </tr>
            </tbody>    
        </table>
    </div>

@endsection