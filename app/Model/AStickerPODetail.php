<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AStickerPODetail extends Model
{
    public static function getElasticPODetails($masterId){
        return DB::table('a_sticker_p_o_details')
            ->where('purchase_order_master_id', $masterId)
            ->where('status' , '!=', 'D')
            ->get();
    }

    public static function returnTotalSum($masterId){
        $data = DB::table('a_sticker_total_value')
            ->select('total_value')
            ->where('purchase_order_master_id', $masterId)
            ->get();

        if($data->count() > 0){
            return $data[0]->total_value;
        }

        return 0;
    }

    public static function getUniqueProducts($masterId){

        return DB::table('a_sticker_p_o_details')
            ->join('a_sticker_product_setups', 'a_sticker_p_o_details.a_sticker_product_setup_id', '=', 'a_sticker_product_setups.id')
            ->select('a_sticker_product_setups.id', 'a_sticker_product_setups.name')
            ->where('purchase_order_master_id', $masterId)
            ->where('a_sticker_p_o_details.status' , '!=', 'D')
            ->orderBy('a_sticker_product_setups.name')
            ->groupBy('a_sticker_p_o_details.a_sticker_product_setup_id', 'a_sticker_product_setups.id', 'a_sticker_product_setups.name')
            ->get();
    }

    public static function getTotalQuantity($masterId){
        $poDetails = DB::table('a_sticker_p_o_details')
            ->select('a_sticker_p_o_details.order_quantity', 'a_sticker_p_o_details.total_price')
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
        $poDetails = DB::table('a_sticker_p_o_details')
            ->select('a_sticker_p_o_details.order_quantity', 'a_sticker_p_o_details.total_price')
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
