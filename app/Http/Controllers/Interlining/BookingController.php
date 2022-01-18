<?php

namespace App\Http\Controllers\Interlining;

use App\Http\Controllers\Controller;
use App\Model\Buyer;
use App\Model\DeliveryLocation;
use App\Model\InterliningPODetail;
use App\Model\InterliningProductSetup;
use App\Model\PurchaseOrderMaster;
use App\Model\Supplier;
use App\Model\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    //$product_group_id = 2;

    public function recent(){
        $purchaseOrders = PurchaseOrderMaster::orderBy('lpd_po_no', 'desc')
            ->where('product_group_id', 2)
            ->where('status', '!=', 'D')
            ->get()
            ->take(1000);

        //return $purchaseOrders;
        return view('interlining.booking.recent', compact('purchaseOrders'));
    }

    public function active(){
        $purchaseOrders = PurchaseOrderMaster::orderBy('lpd_po_no', 'desc')
            ->where('product_group_id', 2)
            ->where('status', '=', 'A')
            ->get();

        //return $purchaseOrders;
        return view('interlining.booking.active', compact('purchaseOrders'));
    }

    public function deliveryComplete(){
        $purchaseOrders = PurchaseOrderMaster::orderBy('lpd_po_no', 'desc')
            ->where('product_group_id', 2)
            ->where('status', '=', 'DC')
            ->get()
            ->take(1000);

        //return $purchaseOrders;
        return view('interlining.booking.delivery-complete', compact('purchaseOrders'));
    }

    public function search(){
        $suppliers = Supplier::getActiveSupplierByProductGroup(2);
        //$deliveryLocations = DeliveryLocation::getDeliveryLocationForSelectField();
        $buyers = Buyer::getBuyersForSelectField();
        $currentDate = Carbon::now();

        //return $currentDate;

        return view('interlining.booking.search',
            compact('suppliers', 'buyers', 'currentDate'));
    }

    public function searchBooking(Request $request){

        $lpd_po_no = $request->get('lpd_po_no');
        if(!empty($lpd_po_no)){
            $purchaseOrders = PurchaseOrderMaster::orderBy('lpd_po_no', 'desc')
                ->where('product_group_id', 2)
                ->where('lpd_po_no', $lpd_po_no)
                ->where('status', '!=', 'D')
                ->get();
            return view('interlining.booking.search-result', compact('purchaseOrders'));
        }
        else{

            $from_date = $request->get('from_date');
            $to_date = $request->get('to_date');
            $supplier_id = $request->get('supplier');

            $purchaseOrders = PurchaseOrderMaster::orderBy('lpd_po_no', 'desc')
                ->where('product_group_id', 2)
                ->whereBetween('lpd_po_date', array($from_date, $to_date))
                ->where('status', '!=', 'D')
                ->get();

            if(!empty($supplier_id)){
                $purchaseOrders = $purchaseOrders->where('supplier_id', $supplier_id);
            }

            return view('interlining.booking.search-result', compact('purchaseOrders'));
        }

        //return $purchaseOrders;

    }

    public function newBooking(){

        $suppliers = Supplier::getActiveSupplierByProductGroup(2);
        $deliveryLocations = DeliveryLocation::getDeliveryLocationForSelectField();
        $buyers = Buyer::getBuyersForSelectField();

        return view('interlining.booking.new',
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
        $purchase_order_master->product_group_id = 2;
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
            return redirect()->route('interlining.booking.detail', ['id' => $purchase_order_master->id]);
        }
        return back();
    }

    public function detail($id){
        $purchase_order_master = PurchaseOrderMaster::find($id);

        if($purchase_order_master != null){
            if($purchase_order_master->product_group_id == 2){
                if($purchase_order_master->status != 'D'){
                    $duplicate = PurchaseOrderMaster::checkDuplicateLpdPO($id);
                    $products = InterliningProductSetup::getActiveProductListForSelect($purchase_order_master->supplier_id);
                    $details = InterliningPODetail::getElasticPODetails($id);
                    $uniqueProducts = InterliningPODetail::getUniqueProducts($id);
                    $units = Unit::getAllActiveUnitsForSelectList();
                    //return $products;
                    $purchaseOrder = $purchase_order_master;

                    return view('interlining.booking.detail',
                        compact('purchaseOrder',
                            'products', 'details', 'uniqueProducts', 'units', 'duplicate'));

                }
                return redirect()->route('interlining.booking.recent');
            }
            return redirect()->route('interlining.booking.recent');
        }

        return redirect()->route('interlining.booking.recent');
    }
    public function edit($id){
        $purchase_order_master = PurchaseOrderMaster::find($id);

        if($purchase_order_master != null){
            if($purchase_order_master->product_group_id == 2){
                if($purchase_order_master->status != 'D'){

                    //return $purchase_order_master;
                    $suppliers = Supplier::getActiveSupplierByProductGroup(2);
                    $deliveryLocations = DeliveryLocation::getDeliveryLocationForSelectField();
                    $buyers = Buyer::getBuyersForSelectField();
                    $purchaseOrder = $purchase_order_master;
                    return view('interlining.booking.edit',
                        compact('purchaseOrder', 'suppliers',
                            'deliveryLocations', 'buyers'));

                }
                return redirect()->route('interlining.booking.recent');
            }
            return redirect()->route('interlining.booking.recent');
        }

        return redirect()->route('interlining.booking.recent');
    }

    public function pdf($id){
        $purchase_order_master = PurchaseOrderMaster::find($id);

        if($purchase_order_master != null){
            if($purchase_order_master->product_group_id == 2){
                if($purchase_order_master->status != 'D'){

                    $details = InterliningPODetail::getElasticPODetails($id);
                    $uniqueProducts = InterliningPODetail::getUniqueProducts($id);
                    //$units = Unit::getAllActiveUnitsForSelectList();
                    //return $products;
                    $master = $purchase_order_master;

                    return view('interlining.booking.print',
                        compact('master',
                            'details', 'uniqueProducts'));

                }
                return redirect()->route('interlining.booking.recent');
            }
            return redirect()->route('interlining.booking.recent');
        }

        return redirect()->route('interlining.booking.recent');
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

    public function saveDetail(Request $request){

        $id = $request->get('item_id');
        if(!empty($id)){
            /*$detail = new CartoonPurchaseOrderDetail();

            if($detail->save()){
                return 'save';
            }*/

            return 'save';
        }
        else{
            $detail = new InterliningPODetail();
            //return $request->all();

            $detail->purchase_order_master_id = $request->purchase_order_master_id;
            $detail->item_count = $this->getItemCount($request->purchase_order_master_id);

            $detail->interlining_product_setup_id = $request->interlining_product_setup;
            $detail->article_id = $request->article_no;
            $detail->input_unit_id = $request->input_unit;
            //$detail->gross_form_factor = $request->gross_form_factor;

            $detail->order_quantity = $request->order_quantity;
            //$detail->gross_order_quantity = $request->gross_order_quantity;
            $detail->unit_price = $request->unit_price;
            $detail->total_price = ($request->get('total_price'));
            $detail->currency = ($request->get('currency'));
            $detail->remarks = $request->item_remarks;
            if($detail->save()){
                return 'save';
            }
        }
        return null;
    }

    public function deleteDetail(Request $request){
        $id = $request->get('item_id');

        $purchaseOrderDetail = InterliningPODetail::where('purchase_order_master_id', $request->purchase_order_master_id)
            ->where('item_count', $id)
            ->first();

        if(!empty($purchaseOrderDetail)){

            $result = DB::table('interlining_p_o_details')
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

        $purchase_order_master->product_group_id = 2;
        $purchase_order_master->lpd_po_date = $request->booking_date;
        $purchase_order_master->delivery_date = $request->delivery_date;
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
            return redirect()->route('interlining.booking.detail', ['id' => $purchase_order_master->id]);
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
        $lastDetail = DB::table('interlining_p_o_details')
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
