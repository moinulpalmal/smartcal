<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GeneralPODetail extends Model
{
    public static function getElasticPODetails($masterId){
        return DB::table('general_p_o_details')
            ->where('purchase_order_master_id', $masterId)
            ->where('status' , '!=', 'D')
            ->get();
    }

    public static function getUniqueProducts($masterId){

        return DB::table('general_p_o_details')
            ->join('general_product_setups', 'general_p_o_details.general_product_setup_id', '=', 'general_product_setups.id')
            ->select('general_product_setups.id', 'general_product_setups.name')
            ->where('purchase_order_master_id', $masterId)
            ->where('general_p_o_details.status' , '!=', 'D')
            ->orderBy('general_product_setups.name')
            ->groupBy('general_p_o_details.general_product_setup_id', 'general_product_setups.id', 'general_product_setups.name')
            ->get();
    }

    public static function getTotalQuantity($masterId){
        $poDetails = DB::table('general_p_o_details')
            ->select('general_p_o_details.order_quantity', 'general_p_o_details.total_price')
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
        $poDetails = DB::table('general_p_o_details')
            ->select('general_p_o_details.order_quantity', 'general_p_o_details.total_price')
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
        $poDetails = DB::table('general_total_value')
            ->select('general_total_value.currency')
            ->where('purchase_order_master_id', $masterID)
            ->get();

        if($poDetails->count() > 0){
            return $poDetails[0]->currency;
        }

        return ' ';
    }
}
