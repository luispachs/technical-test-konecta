<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request, Response};
use App\Models\{Products,Category};
use App\Handlers\Utils;


class ProductController extends Controller
{
    public function index():View{
        $categories =Category::getAll();
        $products =Products::getAll();

        return view('admin.home',['categories'=> $categories,'products'=> $products]);
    }
    public function createAction(Request $request)
    {
        $product = new Products();
        $productName =trim($request->get('productName'));
        $productPrice =(int) $request->get('productPrice',0);
        $productWeight =(int) $request->get('productWeight',0);
        $productStock =(int) $request->get('productAmount',0);
        $productCategory =(int) $request->get('productCategory');
        if($productPrice == 0){
            return \redirect(route('index.product'))->with('errors','El campo precio no puede ser 0');
        }
        if( $productWeight==0){
            return \redirect(route('index.product'))->with('errors','El campo peso no puede ser 0');
        }
        $product->product_name =$productName;
        $product->precio = $productPrice;
        $product->peso = $productWeight;
        $product->stock = $productStock;
        $product->categoria = $productCategory;
        $product->creation_date = date('Y-m-d');
        $reference =$this->createReference();
        $product->referencia =$reference;
        $product->save();
        return \redirect(route('index.product'))->with('success','El producto a sido credo con exito');
    }

    public function deleteAction(Request $request){
        try{
            $itemID = Products::destroy((int) $request->get('id'));
        }catch (\Exception $e){
            return \redirect(route('index.product'))->with('error','Producto no ha podido se eliminado');
        }
            return \redirect(route('index.product'))->with('success','Producto ha sido eliminado exitosamente');
    }
    public function updateViewAction(Request $request,int $id){
        $product = Products::find($id);
        $categories = Category::getAll();
        return view('Admin.update',['product'=>$product,'categories'=> $categories]);
    }
    public function updateAction(Request $request){

        $product = Products::find($request->get('productId'));
        $product->product_name =$product->product_name!=$request->get('productName')?$request->get('productName'):$product->product_name;
        $product->precio =$product->precio!=$request->get('productPrice')?$request->get('productPrice'):$product->precio;
        $product->peso =$product->peso!=$request->get('productWeight')?$request->get('productWeight'):$product->peso;
        $product->stock =$product->stock!=$request->get('productAmount')?$request->get('productAmount'):$product->stock;
        $product->categoria =$product->categoria!=$request->get('productCategory')?$request->get('productCategory'):$product->categoria;
        $product->save();

        return \redirect(route('index.product'))->with('success','Producto ha sido actualizado exitosamente');
    }

    public function getProduct(Request $request,string $name):JsonResponse{
        $products = Products::where('product_name','like',"%$name%")->get();

        return JsonResponse::fromJsonString($products);
    }
    private function createReference(){
        $existReference =true;
        $reference='';
        do{
            $reference = Utils::generatedReference();
            $product = Products::Where('referencia',$reference)->first();
            if(empty($product)){
                $existReference=false;
            }
        }
        while($existReference ==true);
        return $reference;
    }
}
