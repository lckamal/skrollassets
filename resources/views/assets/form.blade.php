@extends('layout')
@section('content')
@inject('buildings', 'App\Building')
@inject('categories', 'App\Category')
@inject('vendors', 'App\Vendor')
@inject('employees', 'App\Employee')

<?php $assetcrumb = isset($asset) ? 'assets.edit' : 'assets.create'; ?>

<section class="content-header">
  <h1>{{ $formTitle }}</h1>
  {!! Breadcrumbs::render($assetcrumb) !!}
</section>
<section class="content">
    <div class="box box-primary">
        @include('errors/validation')

        @if(isset($asset))
            {!! Form::model($asset, array('action' => ['AssetsController@update', $asset->id], 'files' => true)) !!} 
            {!! Form::hidden('_method', 'PATCH') !!}
        @else
            {!! Form::open(array('url' => 'assets', 'enctype' => 'multipart/form-data')) !!}
        @endif
        <div class="box-body">

            <div class="form-group">
                {!! Form::label('asset_no', 'Asset No:') !!} <span class="text-danger">*</span>
                {!! Form::text('asset_no', old('asset_no'), ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('name', 'Name:') !!} <span class="text-danger">*</span>
                {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('description', 'Description:') !!}
                {!! Form::textarea('description', old('description'), ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('model', 'Model:') !!} <span class="text-danger">*</span>
                {!! Form::text('model', old('model'), ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('serial', 'Serial:') !!} <span class="text-danger">*</span>
                {!! Form::text('serial', old('serial'), ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('purchase_price', 'Purchase price:') !!} <span class="text-danger">*</span>
                <div class="input-group">
                  <div class="input-group-addon">$</div>
                  {!! Form::text('purchase_price', old('purchase_price'), ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('barcode', 'Barcode:') !!}
                {!! Form::text('barcode', old('barcode'), ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('date_acquired', 'Date acquired:') !!} <span class="text-danger">*</span>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                    {!! Form::text('date_acquired', old('date_acquired'), ['class' => 'form-control datemask', 'data-mask']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('date_disposed', 'Date disposed:') !!}
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                    {!! Form::text('date_disposed', old('date_disposed'), ['class' => 'form-control datemask', 'data-mask']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('category_id', 'Category:') !!} <span class="text-danger">*</span>
                {!! Form::select('category_id', array('' => 'Select Category') + (array)$categories->lists('name', 'id')->all(), null, ['class' => 'form-control chosen-input']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('building_id', 'Building:') !!} <span class="text-danger">*</span>
                {!! Form::select('building_id', array('' => 'Select Building') + (array)$buildings->lists('name', 'id')->all(), null, ['class' => 'form-control chosen-input']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('floor_id', 'Floor:') !!} <span class="text-danger">*</span>
                {!! Form::select('floor_id', array('' => 'Select Floor'), null, ['class' => 'form-control chosen-input']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('vendor_id', 'Vendor:') !!} <span class="text-danger">*</span>
                {!! Form::select('vendor_id', array('' => 'Select Vendor') + (array)$vendors->lists('name', 'id')->all(), null, ['class' => 'form-control chosen-input']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('employee_id', 'Employee:') !!} <span class="text-danger">*</span>
                {!! Form::select('employee_id', array('' => 'Select Employee') + (array)$employees->lists('first_name', 'id')->all(), null, ['class' => 'form-control chosen-input']) !!}
            </div>
    
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('Image') !!} <small><span class="help-inline">(jpg,png)</span></small>
                        {!! Form::file('image', ['class' => 'form-control']) !!}
                        @if(isset($asset->image))
                            <span class="help-block">
                                Existing image will be replaced if new image is selected.
                            </span>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        @if(isset($asset->image))
                            <img src="{{ $asset->image }}" alt="" height="100" />
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('status', 'Status:') !!} <span class="text-danger">*</span>
                {!! Form::select('status', array('active' => 'Active', 'inactive' => 'Inactive', 'repair' => 'In repair'), null, ['class' => 'form-control chosen-input']) !!}
            </div>

            <hr>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="/assets" class="btn btn-default">Cancel</a>
            </div>
        </div> 
        {!! Form::close() !!}
    </div>
</section>
@stop
@section('scripts.footer')
<script type="text/javascript">
    var selected_floor_id = {!! isset($asset->floor_id) ? $asset->floor_id : '0' !!};

    jQuery(document).ready(function($){
        $('[name="building_id"]').change(function(){
            $.get("{{ url('assets/dropdown')}}", { building_id: $(this).val() }, function(data) {
                var floor_id = $('[name="floor_id"]');
                floor_id.empty();
                floor_id.append("<option value=''>Select Floor</option>");
                $.each(data, function(index, value) {
                    var selected = (index == selected_floor_id) ? "selected='selected'" : "";
                    floor_id.append("<option value='"+ index +"' "+ selected +">" + value + "</option>");
                });
                floor_id.trigger("chosen:updated");
            });
        }).change();

        $('[name="floor_id"]').val();
    });
</script>
@stop