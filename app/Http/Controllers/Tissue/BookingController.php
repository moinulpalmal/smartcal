<?php

namespace App\Http\Controllers\Tissue;

use App\Http\Controllers\Controller;
use App\Model\Buyer;
use App\Model\DeliveryLocation;
use App\Model\PurchaseOrderMaster;
use App\Model\Supplier;
use App\Model\TissueProductSetup;
use App\Model\TissuePurchaseOrderDetail;
use App\Model\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    //$product_group_id = 3;
    public function recent(){
        $purchaseOrders = PurchaseOrderMaster::orderBy('lpd_po_no', 'desc')
            ->where('product_group_id', 3)
            ->where('status', '!=', 'D')
            ->get()
            ->take(1000);

        //return $purchaseOrders;
        return view('tissue.booking.recent', compact('purchaseOrders'));
    }

    public function active(){
        $purchaseOrders = PurchaseOrderMaster::orderBy('lpd_po_no', 'desc')
            ->where('product_group_id', 3)
            ->where('status', '=', 'A')
            ->get();

        //return $purchaseOrders;
        return view('tissue.booking.active', compact('purchaseOrders'));
    }

    public function deliveryComplete(){
        $purchaseOrders = PurchaseOrderMaster::orderBy('lpd_po_no', 'desc')
            ->where('product_group_id', 3)
            ->where('status', '=', 'DC')
            ->get()
            ->take(1000);

        //return $purchaseOrders;
        return view('tissue.booking.recent', compact('purchaseOrders'));
    }

    public function search(){
        $suppliers = Supplier::getActiveSupplierByProductGroup(3);
        //$deliveryLocations = DeliveryLocation::getDeliveryLocationForSelectField();
        $buyers = Buyer::getBuyersForSelectField();
        $currentDate = Carbon::now();

        //return $currentDate;

        return view('tissue.booking.search',
            compact('suppliers', 'buyers', 'currentDate'));
    }

    public function report(){
        $suppliers = Supplier::getActiveSupplierByProductGroup(3);
        //$deliveryLocations = DeliveryLocation::getDeliveryLocationForSelectField();
        $buyers = Buyer::getBuyersForSelectField();
        $currentDate = Carbon::now();

        //return $currentDate;

        return view('tissue.booking.report',
            compact('suppliers', 'buyers', 'currentDate'));
    }

    public function reportResult(Request $request){
        $lpd_po_no = $request->get('lpd_po_no');

        if(!empty($lpd_po_no)){

            $purchaseOrders = PurchaseOrderMaster::orderBy('lpd_po_no', 'desc')
                ->where('product_group_id', 3)
                ->where('lpd_po_no', $lpd_po_no)
                ->where('status', '!=', 'D')
                ->get();

            if(!empty($status)){
                $purchaseOrders = $purchaseOrders->whereIn('status', $status);
            }

            return view('tissue.booking.booking-report', compact('purchaseOrders'));
        }
        else{

            $purchaseOrders = PurchaseOrderMaster::orderBy('lpd_po_no', 'desc')
                ->where('product_group_id', 3)
                ->where('status', '!=', 'D')
                ->get();

            if(!empty($request->get('from_date'))){
                if(!empty($request->get('to_date'))){
                    $purchaseOrders = $purchaseOrders->whereBetween('lpd_po_date', array($request->get('from_date'), $request->get('to_date')));

                }
                else{
                    $purchaseOrders = $purchaseOrders->whereBetween('lpd_po_date', array($request->get('from_date'), Carbon::today()));
                }
            }
            else{
                if(!empty($request->get('to_date'))){
                    $purchaseOrders = $purchaseOrders->whereBetween('lpd_po_date', array( Carbon::today()->addYear(-30), $request->get('to_date')));
                }
                else{
                    $purchaseOrders = $purchaseOrders->whereBetween('lpd_po_date', array(Carbon::today()->addYear(-30), Carbon::today()));
                }
            }

            if(!empty( $request->get('supplier'))){
                $purchaseOrders = $purchaseOrders->whereIn('supplier_id', $request->get('supplier'));
            }

            if(!empty($request->get('buyer'))){
                $purchaseOrders = $purchaseOrders->whereIn('buyer_id',   $request->get('buyer'));
            }

            if(!empty( $request->get('status'))){
                $purchaseOrders = $purchaseOrders->whereIn('status',  $request->get('status'));
            }

            //return $purchaseOrders;

            return view('tissue.booking.booking-report', compact('purchaseOrders', 'request'));
        }
    }

    public function searchBooking(Request $request){
        $lpd_po_no = $request->get('lpd_po_no');
        if(!empty($lpd_po_no)){
            $purchaseOrders = PurchaseOrderMaster::orderBy('lpd_po_no', 'desc')
                ->where('product_group_id', 3)
                ->where('lpd_po_no', $lpd_po_no)
                ->where('status', '!=', 'D')
                ->get();
            return view('tissue.booking.search-result', compact('purchaseOrders'));
        }
        else{

            $from_date = $request->get('from_date');
            $to_date = $request->get('to_date');
            $supplier_id = $request->get('supplier');

            $purchaseOrders = PurchaseOrderMaster::orderBy('lpd_po_no', 'desc')
                ->where('product_group_id', 3)
                ->whereBetween('lpd_po_date', array($from_date, $to_date))
                ->where('status', '!=', 'D')
                ->get();

            if(!empty($supplier_id)){
                $purchaseOrders = $purchaseOrders->where('supplier_id', $supplier_id);
            }

            return view('tissue.booking.search-result', compact('purchaseOrders'));
        }

        //return $purchaseOrders;

    }

    public function newBooking(){

        $suppliers = Supplier::getActiveSupplierByProductGroup(3);
        $deliveryLocations = DeliveryLocation::getDeliveryLocationForSelectField();
        $buyers = Buyer::getBuyersForSelectField();

        return view('tissue.booking.new',
            compact('suppliers', 'deliveryLocations', 'buyers'));
    }

    public function saveBooking(Request $request){

        //return $request->all();

        $this->validate($request, [
            'booking_date' => 'required|date',
            'delivery_date' => 'required|date',
            'supplier' => 'required',
            'delivery_location' => 'required',
            'buyer' => 'required',
            'style' => 'required|string|max:200',
            'consumption_per_dz' => 'required|string|max:200',
            'garments_quantity' => 'required|numeric|min:1'
        ]);

        //return $request->all();

        //return $this->getLPDPoNo();

        $purchase_order_master = new PurchaseOrderMaster();


        $purchase_order_master->year = Carbon::now()->year;
        $purchase_order_master->month = Carbon::now()->month;
        $purchase_order_master->product_group_id = 3;
        $purchase_order_master->lpd_po_date = $request->booking_date;
        $purchase_order_master->delivery_date = $request->delivery_date;
        $purchase_order_master->supplier_id = $request->supplier;
        $purchase_order_master->buyer_id = $request->buyer;
        $purchase_order_master->delivery_location_id = $request->delivery_location;
        $purchase_order_master->delivery_location_detail_id = $request->delivery_location_detail_id;

        $purchase_order_master->style = $request->style;
        $purchase_order_master->consumption_per_dz = $request->consumption_per_dz;
        $purchase_order_master->garments_quantity = $request->garments_quantity;
//        $purchase_order_master->description = $request->description;
        $purchase_order_master->buyer_po_no = $request->buyer_po_no;
        $purchase_order_master->remarks = $request->remarks;
        $purchase_order_master->inserted_by = Auth::id();
        $purchase_order_master->lpd_po_no = PurchaseOrderMaster::getLPDPoNo();
        if($purchase_order_master->save()){
            return redirect()->route('tissue.booking.detail', ['id' => $purchase_order_master->id]);
        }
        return back();
    }

    public function detail($id){
        $purchase_order_master = PurchaseOrderMaster::find($id);

        if($purchase_order_master != null){
            if($purchase_order_master->product_group_id == 3){
                if($purchase_order_master->status != 'D'){
                    $duplicate = PurchaseOrderMaster::checkDuplicateLpdPO($id);
                    $products = TissueProductSetup::getActiveProductListForSelect($purchase_order_master->supplier_id);
                    $details = TissuePurchaseOrderDetail::getElasticPODetails($id);
                    $uniqueProducts = TissuePurchaseOrderDetail::getUniqueProducts($id);
                    $units = Unit::getAllActiveUnitsForSelectList();
                    //return $products;
                    $purchaseOrder = $purchase_order_master;

                    return view('tissue.booking.detail',
                        compact('purchaseOrder',
                            'products', 'details', 'uniqueProducts', 'units', 'duplicate'));

                }
                return redirect()->route('tissue.booking.recent');
            }
            return redirect()->route('tissue.booking.recent');
        }

        return redirect()->route('tissue.booking.recent');
    }

    public function edit($id){
        $purchase_order_master = PurchaseOrderMaster::find($id);

        if($purchase_order_master != null){
            if($purchase_order_master->product_group_id == 3){
                if($purchase_order_master->status != 'D'){

                    //return $purchase_order_master;
                    $suppliers = Supplier::getActiveSupplierByProductGroup(3);
                    $deliveryLocations = DeliveryLocation::getDeliveryLocationForSelectField();
                    $buyers = Buyer::getBuyersForSelectField();
                    $purchaseOrder = $purchase_order_master;

                    return view('tissue.booking.edit',
                        compact('purchaseOrder', 'suppliers',
                            'deliveryLocations', 'buyers'));

                }
                return redirect()->route('tissue.booking.recent');
            }
            return redirect()->route('tissue.booking.recent');
        }

        return redirect()->route('tissue.booking.recent');
    }

    public function pdf($id){
        $purchase_order_master = PurchaseOrderMaster::find($id);

        if($purchase_order_master != null){
            if($purchase_order_master->product_group_id == 3){
                if($purchase_order_master->status != 'D'){

                    $details = TissuePurchaseOrderDetail::getElasticPODetails($id);
                    $uniqueProducts = TissuePurchaseOrderDetail::getUniqueProducts($id);
                    //$units = Unit::getAllActiveUnitsForSelectList();
                    //return $products;
                    $master = $purchase_order_master;

                    return view('tissue.booking.print',
                        compact('master',
                            'details', 'uniqueProducts'));

                }
                return redirect()->route('tissue.booking.recent');
            }
            return redirect()->route('tissue.booking.recent');
        }

        return redirect()->route('tissue.booking.recent');
    }

    public function delete(Request $request){
        $purchase_order_master = PurchaseOrderMaster::find($request->id);
        if($purchase_order_master != null){
            $purchase_order_master->status = 'D';
            $purchase_order_master->last_updated_by = Auth::id();

            if($purchase_order_master->save()){
                return true;
            }
            return null;
        }

        return null;
    }

    public function returnActive(Request $request){
        $purchase_order_master = PurchaseOrderMaster::find($request->id);
        if($purchase_order_master != null){
            $purchase_order_master->delivery_complete_date = null;
            $purchase_order_master->status = 'A';
            $purchase_order_master->last_updated_by = Auth::id();

            if($purchase_order_master->save()){
                return true;
            }
            return null;
        }

        return null;
    }

    public function saveDetail(Request $request){

        $id = $request->get('item_id');
        if(!empty($id)){

            return 'save';
        }
        else{
            $detail = new TissuePurchaseOrderDetail();
            //return $request->all();
            $detail->purchase_order_master_id = $request->purchase_order_master_id;
            $detail->item_count = $this->getItemCount($request->purchase_order_master_id);

            $detail->tissue_product_setup_id = $request->tissue_product_setup;
            $detail->input_unit_id = $request->input_unit;
            //$detail->dz_conversion_rate = $request->gross_form_factor;

            $detail->size = $request->size;
            $detail->order_quantity = $request->order_quantity;
            $detail->order_quantity_dz = $request->order_quantity_dz;
            $detail->per_dz_price = $request->per_dz_price;
            $detail->total_price = ($request->get('total_price'));
            $detail->remarks = $request->item_remarks;
            if($detail->save()){
                return 'save';
            }
        }
        return null;
    }

    public function deleteDetail(Request $request){
        $id = $request->get('item_id');

        $purchaseOrderDetail = TissuePurchaseOrderDetail::where('purchase_order_master_id', $request->purchase_order_master_id)
            ->where('item_count', $id)
            ->first();

        if(!empty($purchaseOrderDetail)){

            $result = DB::table('tissue_purchase_order_details')
                ->where('item_count', $id)
                ->where('purchase_order_master_id', $request->purchase_order_master_id)
                ->update(['status' => 'D']);

            if($result){
                return 'Updated';
            }
            return "Error";
        }

        return "Error";
    }

    public function updateBooking(Request $request){

        //return $request->all();

        $this->validate($request, [
            'booking_date' => 'required|date',
            'delivery_date' => 'required|date',
//            'supplier' => 'required',
            'delivery_location' => 'required',
            'buyer' => 'required',
            'style' => 'required|string|max:200',
            'consumption_per_dz' => 'required|string|max:200',
            'garments_quantity' => 'required|numeric|min:1'
        ]);

        //return $request->all();

        //return $this->getLPDPoNo();

        $purchase_order_master = PurchaseOrderMaster::find($request->id);

        $purchase_order_master->product_group_id = 3;
        $purchase_order_master->lpd_po_date = $request->booking_date;
        $purchase_order_master->delivery_date = $request->delivery_date;
        $purchase_order_master->tna_start_date = $request->tna_start_date;
        $purchase_order_master->tna_end_date = $request->tna_end_date;
        if(!empty($request->delivery_complete_date)){
            $purchase_order_master->delivery_complete_date = $request->delivery_complete_date;
            $purchase_order_master->status = "DC";
        }
//        $purchase_order_master->supplier_id = $request->supplier;
        $purchase_order_master->buyer_id = $request->buyer;
        $purchase_order_master->delivery_location_id = $request->delivery_location;
        $purchase_order_master->delivery_location_detail_id = $request->delivery_location_detail_id;

        $purchase_order_master->style = $request->style;
        $purchase_order_master->consumption_per_dz = $request->consumption_per_dz;
        $purchase_order_master->garments_quantity = $request->garments_quantity;
//        $purchase_order_master->description = $request->description;
        $purchase_order_master->remarks = $request->remarks;
        $purchase_order_master->buyer_po_no = $request->buyer_po_no;
        $purchase_order_master->last_updated_by = Auth::id();

        if($purchase_order_master->save()){
            return redirect()->route('tissue.booking.detail', ['id' => $purchase_order_master->id]);
        }

        return back();
    }

    public function makeUrgent(Request $request){
        $purchase_order_master = PurchaseOrderMaster::find($request->id);
        if($purchase_order_master != null){
            $purchase_order_master->is_urgent = true;
            $purchase_order_master->last_updated_by = Auth::id();

            if($purchase_order_master->save()){
                return true;
            }
            return null;
        }

        return null;
    }

    public function makeRevise(Request $request){
        $purchase_order_master = PurchaseOrderMaster::find($request->id);
        if($purchase_order_master != null){
            $purchase_order_master->is_revised = true;
            $purchase_order_master->last_revise_date = Carbon::now();
            $purchase_order_master->last_updated_by = Auth::id();

            if($purchase_order_master->save()){
                return true;
            }
            return null;
        }

        return null;
    }

    public function getItemCount($masterId){
        $lastDetail = DB::table('tissue_purchase_order_details')
            ->select('item_count')
            ->where('purchase_order_master_id', $masterId)
            ->get()
            ->last();

        if($lastDetail == null){
            return 1;
        }
        else{
            $lastNumber = $lastDetail->item_count;

            return ($lastNumber+1);
        }
    }
}
