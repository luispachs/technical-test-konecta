@extends('Layout.Base')
@section('title','Lista de productos')
@section('content')
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="d-flex justify-content-end align-items-center">
            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#Modal">Agregar Nuevo</button>
            </div>
        </div>
        <div class="modal" id="Modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crear nuevo producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form name="createProduct" id="createProduct" method="POST" action="{{route('create.product')}}">
                            @csrf
                            <div class="form-group">
                                <label for="productName" class="form-lab">Nombre</label>
                                <input type="text" name="productName" id="productName" placeholder="Nombre del producto" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="productPrice" class="form-lab">Precio</label>
                                <input type="text" name="productPrice" id="productPrice" placeholder="Precio del producto" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="productWeight" class="form-lab">Peso</label>
                                <input type="text" name="productWeight" id="productWeight" placeholder="Peso del producto" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="productPrice" class="form-lab">Categoria</label>
                                <select name="productCategory" id="productCategory" class="form-control" title="Categoria">
                                    <option value =""></option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="productAmount" class="form-lab">Cantidad</label>
                                <input type="number" name="productAmount" id="productAmount" placeholder="0" class="form-control">
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="crear">Crear</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-1">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-danger">
                    <p class="text-center">{{session('success')}}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('errors'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-success">
                        <p class="text-center">{{session('errors')}}</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
        </div>
        <div class="row border border-dark m-1" id="productlist">
           <div class="container-fluid">
              <table class="table">
                  <thead>
                  <th scope="col">Id</th><th scope="col">Nombre</th><th scope="col">Referencia</th><th>Precio</th><th>Peso</th><th>Categoria</th><th>Stock</th><th>Fecha de creaci&oacute;n</th><th>Actualizar</th><th>Eliminar</th>
                  </thead>
                  <tbody>
                  @foreach($products as $product)
                      <tr>
                          <td scope="col">{{$product->id}}</td><td>{{$product->product_name}}</td><td>{{$product->referencia}}</td>
                          <td>{{$product->precio}}</td>
                          <td>{{$product->peso}}</td>
                          <td>{{$product->categoria}}</td>
                          <td>{{$product->stock}}</td>
                          <td>{{$product->creation_date}}</td>
                          <td><a class="btn btn-success update" href="{{route('update.product',$product->id)}}" >Actualizar</a></td>
                          <td><button class="btn btn-danger delete" data-id="{{$product->id}}">Eliminar</button></td>
                      </tr>
                  @endforeach
                  </tbody>
              </table>
           </div>
        </div>
    </div>
    <script>
        $('#crear').click((e)=>{
            $('#createProduct').submit();
        });
        $('.delete').click((e)=>{
            let id = e.target.dataset.id;
            $.confirm({
                title: '¿Estas Seguro?',
                content: 'Estas a punto de borrar un elemento,Desea continuar con la operación',
                buttons: {
                    confirm: {
                        text:'Confirmar',
                        btnClass:'btn btn-success',
                        keys:['enter'],
                        action: function(){
                            fetch('{{env('APP_URL')}}api/product/delete/'+id,{
                                method:'DELETE',
                                headers:{
                                    'Content-type':'application/json'
                                },
                                redirect:'follow',
                                body:JSON.stringify({'id':id,})
                            }).then(async resp=>{
                                data =await resp;
                                if (data.redirected) {
                                    window.location.href = data.url;
                                }
                            });
                        }
                    },
                    cancel:{
                        text: 'Cancelar',
                        btnClass:'btn btn-danger',
                        action:function (){}
                    }
                }
            });

        })
    </script>
@endsection
