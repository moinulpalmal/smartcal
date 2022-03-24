<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InterliningPODetail extends Model
{
    public static function getElasticPODetails($masterId){
        return DB::table('interlining_p_o_details')
            ->where('purchase_order_master_id', $masterId)
            ->where('status' , '!=', 'D')
            ->get();
    }

    public static function getUniqueProducts($masterId){

        return DB::table('interlining_p_o_details')
            ->join('interlining_product_setups', 'interlining_p_o_details.interlining_product_setup_id', '=', 'interlining_product_setups.id')
            ->select('interlining_product_setups.id', 'interlining_product_setups.name')
            ->where('purchase_order_master_id', $masterId)
            ->where('interlining_p_o_details.status', '=', 'A')
            ->orderBy('interlining_product_setups.name')
            ->groupBy('interlining_p_o_details.interlining_product_setup_id', 'interlining_product_setups.id', 'interlining_product_setups.name')
            ->get();

    }

    public static function getTotalQuantity($masterId){
        $poDetails = DB::table('interlining_p_o_details')
            ->select('interlining_p_o_details.order_quantity', 'interlining_p_o_details.total_price')
            ->where('purchase_order_master_id', $masterId)
            ->where('status' , '!=', 'D')
            ->get();

        $total_order_quantity = 0;
        //$sum_total_price = 0;

        foreach ($poDetails as $detail){
            $total_order_quantity = $total_order_quantity + (float)$detail->order_quantity;
            //$sum_total_price = $sum_total_price + (float)$detail->total_price;
        }



        return $total_order_quantity;
    }

    public static function getSumTotalPrice($masterId){
        $poDetails = DB::table('interlining_p_o_details')
            ->select('interlining_p_o_details.order_quantity', 'interlining_p_o_details.total_price')
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

    public static function returnCurrency($masterID){
        $poDetails = DB::table('interlining_total_value')
            ->select('interlining_total_value.currency')
            ->where('purchase_order_master_id', $masterID)
            ->get();

        if($poDetails->count() > 0){
            return $poDetails[0]->currency;
        }

        return ' ';
    }
}
