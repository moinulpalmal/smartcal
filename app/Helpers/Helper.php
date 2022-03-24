<?php
namespace App\Helpers;
use App\Model\AStickerPODetail;
use App\Model\ThreadPODetail;
use Illuminate\Support\Facades\DB;


class Helper{
   public static function IDwiseData($table_name,$field_name,$Id)
   {
   	 return DB::table($table_name)->where($field_name,$Id)->first();
   }

    public static function TwoIDWiseData($table_name,$field_name,$Id,$field_name_twp,$Id_Two)
    {
        return DB::table($table_name)->where($field_name,$Id)->where($field_name_twp,$Id_Two)->first();
    }

    public static function TwoIDWiseDataList($table_name,$field_name,$Id,$field_name_twp,$Id_Two)
    {
        return DB::table($table_name)->where($field_name,$Id)->where($field_name_twp,$Id_Two)->get();
    }

    public static function ThreeIDWiseData($table_name,$field_name,$Id,$field_name_two,$Id_Two, $field_name_three,$Id_Three)
    {
        return DB::table($table_name)
            ->where($field_name,$Id)
            ->where($field_name_two,$Id_Two)
            ->where($field_name_three,$Id_Three)
            ->first();
    }

    public static function GetThreadPOTotalQty($masterID, $productID){
        return ThreadPODetail::getUniqueProductTotalQty($masterID, $productID);
    }

    public static function GetThreadPOTotalPrice($masterID, $productID){
        return ThreadPODetail::getUniqueProductTotalPrice($masterID, $productID);
    }

    public static function GetArrowStickerTotalSum($masterId){
       return AStickerPODetail::returnTotalSum($masterId);
    }
}
