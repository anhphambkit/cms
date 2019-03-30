@extends('layouts.master')
@section('content')
<?php 
	$extend = "";
	$urlCreate = URL::route('admin.user.create');
?>
<div class="row">
    <div class="col-12">
        @include('core-base::elements.tables.datatables', ['title' => __('Users'), 'dataTable' => $dataTable, 'extend' => $extend, 'urlCreate' => $urlCreate])
    </div>
</div>
@endsection