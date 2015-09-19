@extends('layout')

@section('content')
<section class="content-header">
  <h1>Assets</h1>
  {!! Breadcrumbs::render('assets.index') !!}
</section>
<section class="content">
    
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation">
            <a href="/assets"><i class="fa fa-list"></i> List View</a>
        </li>
        <li role="presentation" class="active">
            <a href="/assets/grid"><i class="fa fa-th-large"></i> Grid View</a>
        </li>
        <li role="presentation">
            <a href="/assets/map"><i class="fa fa-map-signs"></i> Map View</a>
        </li>
    </ul>

    @if(count($assets))
    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Manage Assets</h3>
          <div class="box-tools">
            <a href="/assets/create" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add Asset</a>
          </div>
        </div>
        <div class="box-body">
            <div class="row">
                @foreach($assets as $asset)
                <div class="col-sm-4">
                    <div class="box">
                        <div class="box-header with-border">{{ $asset->name }}</div>
                        <div class="box-body no-border asset-grid text-center">
                            @if(isset($asset->image))
                                <img src="{{ $asset->image }}" alt="" height="240" class="img-responsive" />
                            @else
                                <img src="/images/placeholder.jpg" alt="" class="img-responsive" />
                            @endif
                        </div>
                        <div class="box-footer">
                            <a href="/assets/{{ $asset->id }}/edit" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                            <a href="/assets/delete/{{ $asset->id }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
        <div class="box-footer clearfix">
            {!! $assets->render() !!}
        </div>
    </div>
    @else
        <div class="alert alert-info">
            There are no assets added. <a href="/assets/create">Add Asset</a>
        </div>
    @endif
</section>
<style type="text/css">
    .asset-grid{
        height:250px;
        overflow:hidden;
        text-align: center;
    }
    .asset-grid img{
        display: inline;
    }
</style>
@stop