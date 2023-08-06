@extends('Layout.Base')

@section('title','Actualizar producto')
@section('content')
<div class="container-fluid">
    <form name="updateProduct" id="updateProduct" method="POST" action="{{route('send.update.product')}}">
        @csrf
        <input type="number" name="productId" id="productId" value="{{$product->id}}" class="form-control" hidden>
        <div class="form-group">
            <label for="productName" class="form-lab">Nombre</label>
            <input type="text" name="productName" id="productName" value="{{$product->product_name}}" class="form-control" >
        </div>
        <div class="form-group">
            <label for="productPrice" class="form-lab">Precio</label>
            <input type="text" name="productPrice" id="productPrice" value="{{$product->precio}}" class="form-control">
        </div>
        <div class="form-group">
            <label for="productWeight" class="form-lab">Peso</label>
            <input type="text" name="productWeight" id="productWeight" value="{{$product->peso}}" class="form-control">
        </div>
        <div class="form-group">
            <label for="productPrice" class="form-lab">Categoria</label>
            <select name="productCategory" id="productCategory" class="form-control" title="Categoria">
                <option value ="{{$product->infoCategory->id}}" selected>{{$product->infoCategory->nombre}}</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="productAmount" class="form-lab">Cantidad</label>
            <input type="number" name="productAmount" id="productAmount" value="{{$product->stock}}" class="form-control">
        </div>
        <div class="form-group">
            <label for="creation_date" class="form-lab">Fecha de creación</label>
            <input type="date" name="creationDate" id="creationDate" value="{{$product->creation_date}}" class="form-control" disabled>
        </div>
        <div class="form-group">
            <label for="productReference" class="form-lab">Referencia</label>
            <input type="text" name="productReference" id="productReference" value="{{$product->referencia}}" class="form-control" disabled>
        </div>
    </form>
    <div class="row">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button"  class="btn btn-success m-2 btn-sm" id="updateAction">Actualizar</button>
            <button type="button" class="btn btn-danger m-2 btn-sm" id="cancelAction">Cancelar</button>
        </div>
    </div>
</div>
<script>
    $('#cancelAction').click(e=>{
        location.href='{{route( "index.product" )}}'
    })
    $('#updateAction').click((e)=>{
        $.confirm({
            title: '¿Estas Seguro?',
            content: 'Estas a punto de cambiar un elemento,Desea continuar con la operación',
            buttons: {
                confirm: {
                    text:'Confirmar',
                    btnClass:'btn btn-success',
                    keys:['enter'],
                    action: function(){
                        $('form[name="updateProduct"]').submit();
                    }
                },
                cancel:{
                    text: 'Cancelar',
                    btnClass:'btn btn-danger',
                    action:function (){}
                }
            }
        });

    });
</script>
@endsection
