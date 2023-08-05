@extends('Layout.Base')

@section('content')
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="d-flex justify-content-end align-items-center">
            <button type="button" class="btn btn-sm btn-success ">Agregar Nuevo</button>
            </div>
        </div>
        <div class="row border border-dark m-1" id="productlist">

        </div>
    </div>
@endsection
