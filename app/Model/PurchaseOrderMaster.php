<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseOrderMaster extends Model
{
    /*public static function getLPDPoNo(){

        $currentYear = Carbon::now()->year;
        $strCurrentYear = (string)$currentYear;
        $yearValue = substr($strCurrentYear,2);
        $currentMonth = Carbon::now()->month;
        $strCurrentMonth = (string)$currentMonth;

        $lastLpd = DB::table('purchase_order_masters')
            ->select('id', 'lpd_po_no')
            ->where('status', '!=', 'D')
            ->where('year', $currentYear)
            ->where('month', $currentMonth)
            ->get()
            ->last();

        if($lastLpd == null)
        {
            $value = 1;
            $NewString = sprintf( "%06d", $value);
            return ($yearValue.$strCurrentMonth.$NewString);
        }
        else{
            $lastLpdPO = substr($lastLpd->lpd_po_no, 6);
            $lastNumber = (integer)$lastLpdPO;
            $NewString = sprintf( "%06d", $lastNumber+1);
            return ($yearValue.$strCurrentMonth.$NewString);
        }
    }*/

    public static function getLPDPoNo(){

        //$currentYear = Carbon::now()->year;
        //$strCurrentYear = (string)$currentYear;
        //$yearValue = substr($strCurrentYear,2);
        //$currentMonth = Carbon::now()->month;
        //$strCurrentMonth = (string)$currentMonth;

        $lastLpd = DB::table('purchase_order_masters')
            ->select('id', 'lpd_po_no')
            ->where('status', '!=', 'D')
            ->get()
            ->last();

        if($lastLpd == null)
        {
            $value = 1;

            return $value;
        }
        else{
            $lastLpdPO = $lastLpd->lpd_po_no;
            $lastNumber = (int)$lastLpdPO;
          //  $lastNumber = var_dump((int)$lastLpdPO);
           // $NewString = sprintf( "%06d", $lastNumber+1);
            return $lastNumber+1;
        }
    }

    public static function checkDuplicateLpdPO($id){
        $purchase_order_master = PurchaseOrderMaster::find($id);
        $lpdPOData = DB::table('purchase_order_masters')
            ->select('id', 'lpd_po_no')
            ->where('status', '!=', 'D')
            ->where('lpd_po_no', $purchase_order_master->lpd_po_no)
            ->get();


        if($lpdPOData->count() > 1){
            return true;
        }

        return  false;

    }

    public static function resetLPDPONo($id){
        $purchase_order_master = PurchaseOrderMaster::find($id);
        $old_po = $purchase_order_master->lpd_po_no;
        if($purchase_order_master != null){
            $purchase_order_master->lpd_po_no = self::getLPDPoNo();
            $purchase_order_master->old_lpd_po_no = $old_po;
            $purchase_order_master->last_updated_by = Auth::id();
            if($purchase_order_master->save()){
                return true;
            }

            return false;
        }
        return false;
    }
}
