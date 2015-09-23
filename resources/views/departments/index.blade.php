@extends('layout')

@section('content')
<section class="content-header">
  <h1>Departments</h1>
  {!! Breadcrumbs::render('departments.index') !!}
</section>
<section class="content">
    @include('departments.tabs', ['active' => 'list'])
    <div class="box box-info">
        <div class="box-header with-border">
          @include('partials.filter', ['resetUrl' => '/departments'])
        </div>
        <div class="box-body table-responsive no-padding">
            @if(count($departments))
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>location</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $department)
                        <tr>
                            <td>{{ $department->id }}</td>
                            <td>{{ $department->name }}</td>
                            <td>{{ $department->latitude }}, {{ $department->longitude }}</td>
                            <td>
                                <a href="/floors?department_id={{ $department->id }}" class="btn btn-primary btn-xs">Floors</a>
                                <a href="/departments/{{ $department->id }}/edit" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                                <a href="/departments/delete/{{ $department->id }}" class="btn btn-danger btn-xs confirm"><i class="fa fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            @else
            <div class="alert alert-info">
                There are no departments added. <a href="/departments/create">Add Departments</a>
            </div>
            @endif
        </div>
        <div class="box-footer clearfix">
            {!! $departments->render() !!}
        </div>
    </div>
</section>
@stop