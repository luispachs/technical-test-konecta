<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Sales;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SaleController extends Controller
{
    public function index(){
        return view('welcome',['products'=>Products::getAll()]);
    }
    public function getStock(Request $request,int $id):JsonResponse{
        $stock = Products::find($id);
        return JsonResponse::fromJsonString(json_encode(['stock'=>$stock->stock]));
    }

    public function soldAction(Request $request):JsonResponse{
            $products =$request->get('products');
            $total=0;
             $message="";
             $name ="";
            foreach ($products as $product){
                try {
                    $item= Products::find($product['id']);
                    $name =$item->product_name;
                    $item->stock-= $product['cantidad'];
                    $item->save();
                    $total+=($product['cantidad']*$product['precio']);
                    $venta =new Sales();
                    $venta->producto=$product['id'];
                    $venta->cantidad=$product['cantidad'];
                    DB::transaction(function()use ($item,$venta){
                        $item->save();
                        $venta->save();
                    });
                }catch(\Exception $e){
                    $message .= " ".$name." ";
                }
            }
        $msg='total a cobrar: '.$total;
        if($message!=""){
            $msg.=$message;
        }
            return JsonResponse::fromJsonString(json_encode(['status'=>200,'message'=>$msg]),200);
    }
}
