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
                        <select name="product" id="product" class="form-control" data-placeholder="Escribe el nombre del producto">
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
                        <div class="btn btn-success" id="addProductToSelect">Agregar</div>
                    </div>
                </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
               <div class="container border border-dark m-1" id="invoice">

               </div>
                <div class="container border border-dark m-1">
                <div class="row justify-content-end">
                    <div class="col-4"><p id="totalAmount"><strong>Total:</strong> 0 </p></div>
                    <div class="col-4"><button class="btn btn-success" id="getPay">Pagar</button></div>
                </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="container border border-dark m-1" id="productlist">
                   @foreach($products as $product)
                       <div class="row border m-1">
                           <div class="col-5"><p>{{$product->product_name}}</p></div>
                           <div class="col-3"><p>{{$product->precio}}</p></div>
                           <div class="col-2"><div class="form-group">
                                   <label for="amountInList" class="form-label">Cantidad:</label>
                                   <input type="number" class="form-control m-2" placeholder="0" name="amountInList" id="amountInList-{{$product->id}}">
                               </div>
                           </div>
                           <div class="col-2"><button class="btn btn-success addFromList" data-id="{{$product->id}}" data-nombre="{{$product->product_name}}" data-precio="{{$product->precio}}">Agregar</button></div>
                       </div>
                   @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        let productos =[];
        let totalAmount=0
        $('#product').select2({
            ajax:{
                minimumInputLength: 3,
                url:params=>{
                    return '{{env('APP_URL')}}api/product/get/'+params.term;
                },
                dataType: 'json',
                delay:1000,
                processResults:data=>{
                   result=data.map(elem=>{
                      return {
                          id:elem.id,
                          text:elem.product_name+' | $'+ elem.precio,
                          stock:elem.stock,
                          ref:elem.referencia,
                          peso:elem.peso,
                          name:elem.product_name,
                          precio:elem.precio,
                      }
                  });
                    return {"results":result};
                },
            }
        });
        $('#getPay').click(e=>{
            fetch('{{route("set.sale")}}',{
                method:'POST',
                headers:{
                    "Content-Type": "application/json",
                },
                body:JSON.stringify({'products':productos}),
            }).then(async resp=>{
                let json = await resp.json();
                $.confirm({
                    title:'total a cobrar',
                    content:json.message,
                    buttons:{
                        confirm:{
                            text:'Cobrar',
                            btnClass:'btn btn-success',
                            action:function(){
                                location.href='/';
                            }
                        }
                    }
                })
            }).catch(error=>{});
        })

        $('#addProductToSelect').click(e=>{
          let data = $('#product').select2('data');
          let id =data[0].id;
          let nombre =data[0].name;
          let precio =data[0].precio;
          let cantidad = $("#amount").val();
          addProductBySelect(id,cantidad,precio,nombre);

        })
        $('.addFromList').click(e=>{
           let  elem= e.target;
           let id =elem.dataset.id;
           let nombre =elem.dataset.nombre;
           let precio =elem.dataset.precio;
           let cantidad = $('#amountInList-'+id).val();
           addProductBySelect(id,cantidad,precio,nombre);

        })

        function addProductBySelect(id,cantidad,precio,nombre){
            fetch('{{env('APP_URL')}}api/product/stock/'+id).then(async resp=>{
                let json =await resp.json();
                if(json.stock < cantidad){
                    alert('No hay los suficientes productos. Disponibles:'+json.stock);
                    return;
                }
                if(json.stock ==0){
                    alert('No hay disponibilidad del producto');
                    return;
                }

                let total =cantidad*precio;
                let html ="<div class='row'><p>"+nombre+"|"+cantidad+"|"+total+"</p></div>";
                totalAmount +=total
                $('#totalAmount').html("<p><strong>Total:</strong>"+totalAmount+"</p>")
                $('#invoice').append(html);
                productos.push({'id':id,'cantidad':cantidad,'precio':precio,'nombre':nombre});
                console.log(productos);
            })
        }
    </script>
@endsection

