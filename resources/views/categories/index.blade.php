@extends('layout')

@section('content')
<section class="content-header">
  <h1>Categories</h1>
  {!! Breadcrumbs::render('categories.index') !!}
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
          @include('partials.filter', ['resetUrl' => '/categories'])
          <div class="box-tools">
            <a href="/categories/create" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add Category</a>
          </div>
        </div>
        <div class="box-body table-responsive no-padding">
            @if(count($categories))
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th style="min-width:150px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $key => $category)
                        <tr>
                            <td>{{ $page_start + $key + 1 }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                <a href="/categories/{{ $category->id }}/edit" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                                <a href="/categories/delete/{{ $category->id }}" class="btn btn-danger btn-xs confirm"><i class="fa fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            @else
                <div class="alert alert-info">
                    There are no categories added. <a href="/categories/create">Add Category</a>
                </div>
            @endif
        </div>
        <div class="box-footer clearfix">
            {!! $categories->render() !!}
        </div>
    </div>
</section>
@stop