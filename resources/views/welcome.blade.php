@extends('Layout.Base')
@section('title','Venta de productos')
@section('content')
     <div class="container">
        <h1>Venta de articulos.</h1>
     </div>
    <div class="container">
        <div class="row">

                <div class="mb-3 col">
                    <div class="form-group">
                        <label for="product" class="form-label">Producto</label>
                        <select name="product" id="product" class="form-control">
                        </select>
                    </div>
                </div>
                <div class="mb-3 col">
                    <div class="form-group">
                        <label for="amount" class="form-label">Cantidad</label>
                        <input type="number" name="amount" id="amount" class="form-control">
                    </div>
                </div>
                <div class="mb-3 col d-flex  justify-content-center align-items-center">
                    <div class="form-group">
                        <div class="btn btn-success" id="addProduct">Agregar</div>
                    </div>
                </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
               <div class="container border border-dark m-1" id="invoice">

               </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="container border border-dark m-1" id="productlist">

                </div>
            </div>
        </div>
    </div>
    <script>
        $('#product').select2();
    </script>
@endsection

