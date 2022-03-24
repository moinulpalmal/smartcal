<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FabricPurchaseOrderDetail extends Model
{
    public static function getElasticPODetails($masterId){
        return DB::table('fabric_purchase_order_details')
            ->where('purchase_order_master_id', $masterId)
            ->where('status' , '!=', 'D')
            ->get();
    }

    public static function getUniqueProducts($masterId){

        return DB::table('fabric_purchase_order_details')
            ->join('fabric_product_setups', 'fabric_purchase_order_details.fabric_product_setup_id', '=', 'fabric_product_setups.id')
            ->select('fabric_product_setups.id', 'fabric_product_setups.name')
            ->where('purchase_order_master_id', $masterId)
            ->orderBy('fabric_product_setups.name')
            ->groupBy('fabric_purchase_order_details.fabric_product_setup_id', 'fabric_product_setups.id', 'fabric_product_setups.name')
            ->get();
    }

    public static function getSumTotalPrice($masterId){
        $poDetails = DB::table('fabric_purchase_order_details')
            ->select('fabric_purchase_order_details.order_quantity', 'fabric_purchase_order_details.total_price')
            ->where('purchase_order_master_id', $masterId)
            ->where('status' , '!=', 'D')
            ->get();
        //$total_order_quantity = 0;
        $sum_total_price = 0;

        foreach ($poDetails as $detail){
            //$total_order_quantity = $total_order_quantity + (float)$detail->order_quantity;
            $sum_total_price = $sum_total_price + (float)$detail->total_price;
        }

        return $sum_total_price;

    }
}
