@extends('layouts.admin.admin-master')
@section('title')
    Poly
@endsection
@section('content')
    <style type="text/css">
        .tile-body{
            background-color: white;
        }
        .tile-header{
            color: white;
        }
        .tile-header{
            background-color:#105e7d;
        }
        tfoot input {
            width: 100%;
            padding: 1px;
            box-sizing: border-box;
        }
    </style>
    <div class="page page-profile">
        <div class="pageheader">
            <h2>Poly <span> Booking Details</span></h2>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{route('home')}}"><i class="fa fa-home"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#"> Poly</a>
                    </li>
                    <li>
                        <a href="{{route('poly.booking.recent')}}"> Recent Bookings</a>
                    </li>
                    <li>
                        <a href="{{route('poly.booking.detail', ['id', $purchaseOrder->id ])}}"> LPD PO NO: {{$purchaseOrder->lpd_po_no}}</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- page content -->
        <div class="pagecontent">
            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="col-md-3">
                    <!-- tile -->
                    <section id="purchase-order" class="tile tile-simple">
                        <!-- tile widget -->
                        <div class="tile-widget p-30 text-center">
                            {{--<div class="thumb thumb-xl">
                                <img class="img-circle" src="assets/images/arnold-avatar.jpg" alt="">
                            </div>--}}
                            <h4 class="mb-0"><strong>LPD PO NO:</strong> {{$purchaseOrder->lpd_po_no}}</h4>
                            <div class="mt-10">
                                @if($duplicate == true)
                                    @if(Auth::user()->hasTaskPermission('resetpo', Auth::user()->id))
                                        <a title="Reset LPD PO" class="ResetPO myIcon icon-success icon-ef-3 icon-ef-3b icon-color" data-id = "{{ $purchaseOrder->id }}"><i class="fa fa-recycle"></i></a>
                                    @endif
                                @else
                                    <a title="Refresh" class ="myIcon icon-info icon-ef-3 icon-ef-3b icon-color" onclick="refresh()">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                    @if($purchaseOrder->status == 'A')
                                        @if(Auth::user()->hasTaskPermission('updatecbmaster', Auth::user()->id))
                                            <a title="Edit Booking Master Update" class ="myIcon icon-warning icon-ef-3 icon-ef-3b icon-color" href="{{route('poly.booking.edit', ['id' => $purchaseOrder->id])}}" {{--data-toggle="modal" data-target="#POUpdateModal" --}}data-options="splash-2 splash-ef-12">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif
                                        @if(Auth::user()->hasTaskPermission('revisecb', Auth::user()->id))
                                            <a title="Revise Booking" class="ReviseOrder myIcon icon-success icon-ef-3 icon-ef-3b icon-color" data-id = "{{ $purchaseOrder->id }}"><i class="fa fa-recycle"></i></a>
                                            <a title="Urgent Booking" class="UrgentOrder myIcon icon-warning icon-ef-3 icon-ef-3b icon-color" data-id = "{{ $purchaseOrder->id }}"><i class="fa fa-rocket"></i></a>

                                        @endif
                                        @if(Auth::user()->hasTaskPermission('deletecb', Auth::user()->id))
                                            <a title="Delete Booking" class="DeleteOrder myIcon icon-danger icon-ef-3 icon-ef-3b icon-color" data-id = "{{ $purchaseOrder->id }}"><i class="fa fa-trash"></i></a>
                                        @endif
                                    @else
                                        @if(Auth::user()->hasTaskPermission('deletecb', Auth::user()->id))
                                            <a title="Return Active Booking" class="ReturnActiveOrder myIcon icon-success icon-ef-3 icon-ef-3b icon-color" data-id = "{{ $purchaseOrder->id }}"><i class="fa fa-check"></i></a>
                                        @endif
                                    @endif
                                    <a title="PDF View" class ="myIcon icon-danger icon-ef-3 icon-ef-3b icon-color" {{--target="_blank"--}} href="{{route('poly.booking.detail.pdf', ['id' => $purchaseOrder->id])}}">
                                        <i class="fa fa-file-pdf-o"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </section>
                    <!-- /tile -->
                    <!-- tile -->
                    <section class="tile tile-simple">
                        <!-- tile header -->
                        <div class="tile-header">
                            <h1 class="custom-font"><strong>Booking</strong> Info</h1>
                        </div>
                        <!-- /tile header -->
                        <!-- tile body -->
                        <div class="tile-body">
                            <ul class="list-unstyled">
                                <li>
                                    <div class="row">
                                        <div class="col-md-5 pull-left">
                                            <strong>Supplier</strong>
                                        </div>
                                        <div class="col-md-7 pull-right">
                                            @if($purchaseOrder->supplier_id != null)
                                                <p class="text-right text-greensea">
                                                    {{(App\Helpers\Helper::IDwiseData('suppliers','id',$purchaseOrder->supplier_id))->name}}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                <hr>
                                <li>
                                    <div class="row">
                                        <div class="col-md-5 pull-left">
                                            <strong>Delivery Location</strong>
                                        </div>
                                        <div class="col-md-7 pull-right">
                                            @if($purchaseOrder->delivery_location_id != null)
                                                <p class="text-right text-greensea">
                                                    {{(App\Helpers\Helper::IDwiseData('delivery_locations','id',$purchaseOrder->delivery_location_id))->name}}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                <hr>
                                <li>
                                    <div class="row">
                                        <div class="col-md-5 pull-left">
                                            <strong>Buyer</strong>
                                        </div>
                                        <div class="col-md-7 pull-right">
                                            @if($purchaseOrder->buyer_id != null)
                                                <p class="text-right text-greensea">
                                                    {{(App\Helpers\Helper::IDwiseData('buyers','id',$purchaseOrder->buyer_id))->name}}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                <hr>
                                <li>
                                    <div class="row">
                                        <div class="col-md-5 pull-left">
                                            <strong>Style</strong>
                                        </div>
                                        <div class="col-md-7 pull-right">
                                            @if($purchaseOrder->style != null)
                                                <p class="text-right text-greensea">
                                                    {{$purchaseOrder->style}}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                <hr>
                                <li>
                                    <div class="row">
                                        <div class="col-md-5 pull-left">
                                            <strong>Buyer PO NO</strong>
                                        </div>
                                        <div class="col-md-7 pull-right">
                                            @if($purchaseOrder->buyer_po_no != null)
                                                <p class="text-right text-greensea">
                                                    {{$purchaseOrder->buyer_po_no}}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                <hr>
                                <li>
                                    <div class="row">
                                        <div class="col-md-5 pull-left">
                                            <strong>Consumption / Pcs/ Inch/ DZ</strong>
                                        </div>
                                        <div class="col-md-7 pull-right">
                                            @if($purchaseOrder->consumption_per_dz != null)
                                                <p class="text-right text-greensea">
                                                    {{$purchaseOrder->consumption_per_dz}}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                <hr>
                                <li>
                                    <div class="row">
                                        <div class="col-md-5 pull-left">
                                            <strong>Garments Qty</strong>
                                        </div>
                                        <div class="col-md-7 pull-right">
                                            @if($purchaseOrder->garments_quantity != null)
                                                <p class="text-right text-greensea">
                                                    {{$purchaseOrder->garments_quantity}}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- /tile body -->
                    </section>
                    <!-- /tile -->
                    <!-- tile -->
                    <section class="tile tile-simple">
                        <!-- tile header -->
                        <div class="tile-header">
                            <h1 class="custom-font"><strong>Booking</strong> Status</h1>
                        </div>
                        <!-- /tile header -->
                        <!-- tile body -->
                        <div class="tile-body">
                            <ul class="list-unstyled">
                                <li>
                                    <div class="row">
                                        <div class="col-md-5 pull-left">
                                            <strong>Booking Date</strong>
                                        </div>
                                        <div class="col-md-7 pull-right">
                                            @if($purchaseOrder->lpd_po_date != null)
                                                <p class="text-right text-greensea">
                                                    {{\Carbon\Carbon::parse($purchaseOrder->lpd_po_date)->format('d/m/Y')}}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                <hr>
                                <li>
                                    <div class="row">
                                        <div class="col-md-5 pull-left">
                                            <strong>Last Approval Date</strong>
                                        </div>
                                        <div class="col-md-7 pull-right">
                                            @if($purchaseOrder->approval_date != null)
                                                <p class="text-right text-greensea">{{\Carbon\Carbon::parse($purchaseOrder->approval_date)->format('d/m/Y')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                <hr>
                                <li>
                                    <div class="row">
                                        <div class="col-md-5 pull-left">
                                            <strong>Is Revised</strong>
                                        </div>
                                        <div class="col-md-7 pull-right">
                                            @if($purchaseOrder->is_revised == true)
                                                <p class="text-right text-greensea">Yes</p>
                                            @else
                                                <p class="text-right text-danger">No</p>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                <hr>
                                <li>
                                    <div class="row">
                                        <div class="col-md-5 pull-left">
                                            <strong>Last Revise Date</strong>
                                        </div>
                                        <div class="col-md-7 pull-right">
                                            @if($purchaseOrder->last_revise_date != null)
                                                <p class="text-right text-greensea">{{\Carbon\Carbon::parse($purchaseOrder->last_revise_date)->format('d/m/Y')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                <hr>
                            </ul>
                        </div>
                        <!-- /tile body -->
                    </section>
                    <!-- /tile -->
                    <!-- tile -->

                    <!-- /tile -->
                    <!-- tile -->
                    <section class="tile tile-simple">
                        <!-- tile header -->
                        <div class="tile-header">
                            <h1 class="custom-font"><strong>Description</strong> </h1>
                        </div>

                        <!-- tile body -->

                        <div class="tile-body">
                            <p class="text-default lt">{!! $purchaseOrder->description !!}</p>
                        </div>
                        <!-- /tile body -->
                    </section>
                    <!-- tile -->
                    <section class="tile tile-simple">
                        <!-- tile header -->
                        <div class="tile-header">
                            <h1 class="custom-font"><strong>Remarks</strong> </h1>
                        </div>

                        <!-- tile body -->

                        <div class="tile-body">
                            <p class="text-default lt">{!! $purchaseOrder->remarks !!}</p>
                        </div>
                        <!-- /tile body -->
                    </section>

                </div>
                <!-- /col -->
                <!-- col -->
                <div class="col-md-9">
                    <!-- tile -->
                    <section class="tile tile-simple">
                        <!-- tile body -->
                        <div class="tile-body p-0">
                            <div role="tabpanel">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs tabs-dark" role="tablist">
                                    <li role="presentation" class="active"><a href="#itemList" aria-controls="itemList" role="tab" data-toggle="tab">Item List</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="itemList">
                                        <div class="wrap-reset">
                                            @if($duplicate == true)
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                                        <h4 class="text-danger text-bold"><strong>Duplicate LPD PO No. Please Contact with Administrator</strong></h4>
                                                    </div>
                                                </div>
                                            @else
                                                @if(Auth::user()->hasTaskPermission('deletep', Auth::user()->id))
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                                                            <form method="post" id="ItemAdd" name="ItemAddForm" enctype="multipart/form-data">
                                                                {{ csrf_field() }}
                                                                <section class="tile">
                                                                    <!-- tile header -->
                                                                    <div class="tile-header dvd dvd-btm">
                                                                        <h1 class="custom-font"><strong>Item</strong> Insert/Update Form</h1>

                                                                        <a><button id="iconChange" class="pull-right btn-info btn-xs" type="submit"><i class="fa fa-check"></i></button></a>

                                                                    </div>
                                                                    <!-- /tile header -->
                                                                    <!-- tile body -->
                                                                    <div class="tile-body">
                                                                        <input type="hidden" id="DetailID" name="item_id">
                                                                        <input type="hidden" id="PolyTypeID" class="PolyType" name="poly_type">
                                                                        <input type="hidden" id="Currency" class="Currency" name="currency">
                                                                        <input type="hidden" id="MasterID" name="purchase_order_master_id" value="{{old('purchase_order_master_id', $purchaseOrder->id)}}">
                                                                        <div class="row" style="padding: 0px 15px;">
                                                                            <div class="col-md-4 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="ProductID" class="control-label">Select Product</label>
                                                                                    <select id="ProductID" class="form-control select2" name="poly_product_setup" required style="width: 100%;" onchange="javascript:getProductPrice(this)">
                                                                                        <option value="">- - - Select - - -</option>
                                                                                        @if(!empty($products))
                                                                                            @foreach($products as $group)
                                                                                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                                                                            @endforeach'
                                                                                        @endif'
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-8 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="ItemDetail" class="control-label">Item Detail</label>
                                                                                    <input type="text" class="form-control" name="item_details" id="ItemDetail" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="padding: 0px 15px;">
                                                                            <div class="col-md-3 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="price_unit" class="control-label">Price Unit</label>
                                                                                    <input type="text" class="form-control PriceUnit" name="price_unit" id="price_unit" required readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="UnitPrice" class="control-label">Approved Unit Price</label>
                                                                                    <input type="number" id="UnitPrice" class="form-control UnitPrice" step="any" name="unit_price" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="Qty" class="control-label">Order Quantity</label>
                                                                                    <input type="number" min="1" id="Qty" class="form-control Qty" step="any" name="order_quantity" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="InputUnitID" class="control-label">Order Unit</label>
                                                                                    <select id="InputUnitID" class="form-control select2" name="input_unit" required style="width: 100%;" >
                                                                                        <option value="">- - - Select - - -</option>
                                                                                        @if(!empty($units))
                                                                                            @foreach($units as $group)
                                                                                                <option value="{{ $group->id }}">{{ $group->full_unit }}</option>
                                                                                            @endforeach'
                                                                                        @endif'
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="padding: 0px 15px;">
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="WidthUnitID" class="control-label">Width & Length Unit</label>
                                                                                    <select id="WidthUnitID" class="form-control select2" name="width_length_unit" required style="width: 100%;" onchange="javascript:getConvUnitList(this)">
                                                                                        <option value="">- - - Select - - -</option>
                                                                                        @if(!empty($units))
                                                                                            @foreach($units as $group)
                                                                                                <option value="{{ $group->id }}">{{ $group->full_unit }}</option>
                                                                                            @endforeach'
                                                                                        @endif'
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="ConvWidthUnitID" class="control-label">Conv. Width & Length Unit</label>
                                                                                    <select id="ConvWidthUnitID" class="form-control select2" name="converted_width_length_unit" required style="width: 100%;" onchange="javascript:getConvRate(this)">
                                                                                        <option value="">- - - Select - - -</option>
                                                                                        {{--@if(!empty($units))
                                                                                            @foreach($units as $group)
                                                                                                <option value="{{ $group->id }}">{{ $group->full_unit }}</option>
                                                                                            @endforeach'
                                                                                        @endif'--}}
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="ConversionRate" class="control-label">Conv. Rate</label>
                                                                                    <input type="number" id="Width" class="form-control ConversionRate" step="any" name="conversion_rate" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="Width" class="control-label">Width</label>
                                                                                    <input type="number" id="Width" class="form-control Width" step="any" name="width">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="Length" class="control-label">Length</label>
                                                                                    <input type="number" id="Width" class="form-control Length" step="any" name="length">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="Thickness" class="control-label">Thickness</label>
                                                                                    <input type="number" id="Width" class="form-control Thickness" step="any" name="thickness">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="padding: 0px 15px;">
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="FlapType" class="control-label">Flap Type</label>
                                                                                    <select id="FlapType" class="form-control select2 FlapType" name="flap_type" style="width: 100%;">
                                                                                        <option value="">- - - Select - - -</option>
                                                                                        <option value="F">Flap</option>
                                                                                        <option value="P">Pillow</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="Flap" class="control-label">Flap</label>
                                                                                    <input type="number" id="Flap" class="form-control Flap" step="any" name="flap" value="0">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="QtyPerLBS" class="control-label">Qty Per LBS</label>
                                                                                    <input type="number" id="QtyPerLBS" class="form-control QtyPerLBS" step="any" name="qty_per_lbs" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="TotalLBSQty" class="control-label">Total LBS Qty</label>
                                                                                    <input type="number" id="TotalLBSQty" class="form-control TotalLBSQty" step="any" name="total_lbs_qty" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="PcsPerLbs" class="control-label">Pcs Per Lbs</label>
                                                                                    <input type="number" id="PcsPerLbs" class="form-control PcsPerLbs" step="any" name="pcs_per_lbs" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="PxPcs" class="control-label">Px/Pcs</label>
                                                                                    <input type="number" id="PxPcs" class="form-control PxPcs" step="any" name="px_pcs" readonly>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="row" style="padding: 0px 15px;">
                                                                            <div class="col-md-1 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="FUSD" class="control-label">F. USD Conv.</label>
                                                                                    <input type="number" id="FUSD" class="form-control FUSD" step="any" name="first_usd_conversion_value" value="0" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-1 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="SUSD" class="control-label">S. USD Conv.</label>
                                                                                    <input type="number" id="SUSD" class="form-control SUSD" step="any" name="second_usd_conversion_value" value="0" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="AdehesivePrice" class="control-label">Adhesive Price</label>
                                                                                    <input type="number" id="AdehesivePrice" class="form-control AdhesivePrice" step="any" name="adhesive_price" value="0">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="TotalAdhesivePrice" class="control-label">Total Adhesive Price</label>
                                                                                    <input type="number" id="TotalAdhesivePrice" class="form-control TotalAdhesivePrice" step="any" name="total_adhesive_price" value="0" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="PrintingPrice" class="control-label">Printing Price</label>
                                                                                    <input type="number" id="PrintingPrice" class="form-control PrintingPrice" step="any" name="printing_price" value="0">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="PrintingCount" class="control-label">Printing Color Count</label>
                                                                                    <input type="number" id="PrintingCount" class="form-control PrintingCount" step="any" name="printing_color_count" value="0">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="TotalPrintingPrice" class="control-label">Total Printing Price</label>
                                                                                    <input type="number" id="TotalPrintingPrice" class="form-control TotalPrintingPrice" step="any" name="total_printing_price" value="0" readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="padding: 0px 15px;">
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="TotalUnitPrice" class="control-label">Total Unit Price</label>
                                                                                    <input type="number" id="UnitPrice" class="form-control TotalUnitPrice" step="any" name="total_unit_price" required readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="TotalUnitPriceUnit" class="control-label">Total Unit Price Unit</label>
                                                                                    <input type="text" id="TotalUnitPriceUnit" class="form-control" name="total_unit_price_unit" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="Total" class="control-label">Total Price</label>
                                                                                    <input type="number" step="any" id="Total" class="form-control Total" name="total_price" required readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="Measurement" class="control-label">Measurement</label>
                                                                                    <input type="text" id="Measurement" class="form-control Measurement" name="measurement" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="padding: 0px 15px;">
                                                                            <div class="col-md-12 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="ItemRemarks" class="control-label">Remarks</label>
                                                                                    <input type="text" id="ItemRemarks" class="form-control ItemRemarks" name="item_remarks">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /tile body -->
                                                                </section>
                                                                <!-- /tile -->
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                                                    <section class="tile">
                                                        <!-- tile header -->
                                                        <div class="tile-header dvd dvd-btm">
                                                            <h1 class="custom-font"><strong>Item</strong> List</h1>
                                                        </div>
                                                        <!-- /tile header -->
                                                        <!-- tile body -->
                                                        <div class="tile-body">
                                                            @php($i=0)
                                                            @if(!empty($uniqueProducts))
                                                                @foreach($uniqueProducts as $uproduct)
                                                                    <div class="table-responsive">
                                                                        <table class="table table-hover table-bordered table-condensed table-responsive" id="advanced-usage{{$i++}}">
                                                                            <thead>
                                                                            <tr style="background-color: #1693A5; color: white;">
                                                                                <th class="text-center">Measurement</th>
                                                                                <th class="text-center">Order Quantity</th>
                                                                                <th class="text-center">Approved Unit Price</th>
                                                                                <th class="text-center">Unit Price</th>
                                                                                <th class="text-center">Total Price</th>
                                                                                <th class="text-center">Remarks</th>
                                                                                <th class="text-center">Action</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <h5 class="text-left"><strong>{{$uproduct->name}}</strong></h5>
                                                                            @foreach($details as $item)
                                                                                @if($item->item_details == $uproduct->name)
                                                                                    <tr>
                                                                                        <td class="text-left">
                                                                                            {{$item->measurement}} {{ (App\Helpers\Helper::IDwiseData('units','id',$item->width_length_unit_id))->short_unit }}
                                                                                        </td>
                                                                                        <td class="text-right">{{$item->order_quantity}} {{ (App\Helpers\Helper::IDwiseData('units','id',$item->order_unit_id))->short_unit }}</td>
                                                                                        <td class="text-right">@if($item->currency == "৳") {{ $item->currency }} @else $ @endif {{ $item->unit_price }} / {{$item->price_unit}}</td>
                                                                                        <td class="text-right">$ {!! number_format($item->total_price/$item->order_quantity  , 12, '.', ',') !!} /{{ (App\Helpers\Helper::IDwiseData('units','id',$item->order_unit_id))->short_unit }}</td>
                                                                                        <td class="text-right">$ {{ $item->total_price }}</td>
                                                                                        <td class="text-right">{{$item->remarks}}</td>
                                                                                        <td class="text-center">
                                                                                            {{--                                                                                                <button class="btn btn-info btn-xs" data-toggle="modal" data-target="#user{{$item->id}}" data-options="splash-2 splash-ef-12"><i class="fa fa-eye"></i></button>--}}
                                                                                            @if(Auth::user()->hasTaskPermission('updatepitem', Auth::user()->id))
                                                                                                {{--                                                                                                    <a onclick="iconChange()" data-id = "{{ $item->item_count }}" class="EditFactory btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>--}}
                                                                                                <a title="Delete" class="DeleteDetail btn btn-danger btn-xs" data-id = "{{ $item->item_count }}"><i class="fa fa-trash"></i></a>
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach

                                                                            </tbody>
                                                                        </table>

                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <!-- /tile body -->
                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /tile body -->
                    </section>
                    <!-- /tile -->
                </div>
                <!-- /col -->
            </div>
            <!-- /row -->
        </div>
        <!-- /page content -->
    </div>
@endsection

@section('page-modals')  <


@endsection

@section('pageScripts')
    <script>
        $(window).load(function(){
            /* $('#advanced-usage').DataTable({

             });*/

            $('.select2').select2();
            sessionStorage.clear();

        });

        function getConvUnitList(_category) {
            var categoryId = _category.value;

            var url = '{{ route('admin.unit.get-conv-setup') }}';
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            });
            if (categoryId) {
                $.ajax({
                    url: url,
                    data: {id: categoryId},
                    type: "POST",
                    dataType: "json",
                    success: function (data) {
                        //document.forms["ItemAddForm"]["unit_per_square_meter_price"].value = data.unit_per_square_meter_price;
                        //document.forms["ItemAddForm"]["is_board"].value = data.is_board;
                        defaultKey = " ";
                        defaultValue = "- - - Select - - -";
                        $('select[id= "ConvWidthUnitID"]').empty();

                        $('select[id= "ConvWidthUnitID"]').append('<option value="'+ defaultKey +'">'+ defaultValue +'</option>');
                        $.each(data, function(key,value){
                            //console.log(data);
                            $('select[id= "ConvWidthUnitID"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        //$('#YarnCountName').trigger('chosen:updated');
                        $('.select2').select2();
                        document.forms["ItemAddForm"]["conversion_rate"].value = "";
                    }
                });
            } else {
                //document.forms["ItemAddForm"]["unit_per_square_meter_price"].value = 0;
                //document.forms["ItemAddForm"]["is_board"].value = 0;
                defaultKey = " ";
                defaultValue = "- - - Select - - -";

                $('select[id= "ConvWidthUnitID"]').empty();
                $('select[id= "ConvWidthUnitID"]').append('<option value="'+ defaultKey +'">'+ defaultValue +'</option>');
                $('.select2').select2();
                document.forms["ItemAddForm"]["conversion_rate"].value = "";
            }
        }

        function getConvRate(_category) {

            var to_unit_id = parseInt(_category.value);
            var from_unit_id = parseInt($("#WidthUnitID").children("option:selected").val());
            //console.log(to_unit_id);
            // return;
            var url = '{{ route('admin.unit.get-conv-rate') }}';
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            });
            if (from_unit_id) {
                $.ajax({
                    url: url,
                    data: {from_unit_id: from_unit_id, to_unit_id: to_unit_id},
                    type: "POST",
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        document.forms["ItemAddForm"]["conversion_rate"].value = data.unit_conversion_rate;

                    }
                });
            } else {
                document.forms["ItemAddForm"]["conversion_rate"].value = 0;
                //document.forms["ItemAddForm"]["is_board"].value = 0;

            }
        }

        @php($j=0)
        @if(!empty($uniqueProducts))
        @foreach($uniqueProducts as $uproduct)
        $('#advanced-usage{{$j++}}').on('click',".DeleteDetail", function(){
            var button = $(this);
            var id = button.attr("data-id");
            var url = '{{ route('poly.booking.detail.delete') }}';
            swal({
                title: 'Are you sure?',
                text: 'This item will be removed permanently!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function(value) {
                if (value) {
                    //window.location.href = url;
                    //console.log(id);
                    $.ajax({
                        method:'DELETE',
                        url: url,
                        data:{item_id: id, _token: '{{csrf_token()}}', purchase_order_master_id: $('#MasterID').val()},
                        success:function(data){
                            if(data){
                                //console.log(data);
                                swal({
                                    title: "Operation Successful!",
                                    icon: "success",
                                    button: "Ok!",
                                }).then(function (value) {
                                    if(value){
                                        //console.log(value);
                                        window.location.href = window.location.href.replace(/#.*$/, '');
                                    }
                                });
                            }
                        },
                        error:function(error){
                            console.log(error);
                            swal({
                                title: "Operation Unsuccessful!",
                                text: "Somthing wrong happend please check!",
                                icon: "error",
                                button: "Ok!",
                                className: "myClass",
                            });
                        }
                    })
                }
            });
        });
        @endforeach
        @endif

        $('#purchase-order').on('click',".UrgentOrder", function(){
            var button = $(this);
            var id = button.attr("data-id");
            var url = '{{ route('poly.booking.urgent') }}';
            swal({
                title: 'Are you sure?',
                text: 'This booking will be made urgent permanently!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function(value) {
                if (value) {
                    //window.location.href = url;
                    //console.log(id);
                    $.ajax({
                        method:'DELETE',
                        url: url,
                        data:{id: id, _token: '{{csrf_token()}}'},
                        success:function(data){
                            if(data){
                                //console.log(data);
                                swal({
                                    title: "Operation Successful!",
                                    icon: "success",
                                    button: "Ok!",
                                }).then(function (value) {
                                    if(value){
                                        //console.log(value);
                                        window.location.href = window.location.href.replace(/#.*$/, '');
                                    }
                                });
                            }
                        },
                        error:function(error){
                            console.log(error);
                            swal({
                                title: "Operation Unsuccessful!",
                                text: "Somthing wrong happend please check!",
                                icon: "error",
                                button: "Ok!",
                                className: "myClass",
                            });
                        }
                    })
                }
            });
        });

        $('#purchase-order').on('click',".ReviseOrder", function(){
            var button = $(this);
            var id = button.attr("data-id");
            var url = '{{ route('poly.booking.revise') }}';
            swal({
                title: 'Are you sure?',
                text: 'This booking will be revise permanently!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function(value) {
                if (value) {
                    //window.location.href = url;
                    //console.log(id);
                    $.ajax({
                        method:'DELETE',
                        url: url,
                        data:{id: id, _token: '{{csrf_token()}}'},
                        success:function(data){
                            if(data){
                                //console.log(data);
                                swal({
                                    title: "Operation Successful!",
                                    icon: "success",
                                    button: "Ok!",
                                }).then(function (value) {
                                    if(value){
                                        //console.log(value);
                                        window.location.href = window.location.href.replace(/#.*$/, '');
                                    }
                                });
                            }
                        },
                        error:function(error){
                            console.log(error);
                            swal({
                                title: "Operation Unsuccessful!",
                                text: "Somthing wrong happend please check!",
                                icon: "error",
                                button: "Ok!",
                                className: "myClass",
                            });
                        }
                    })
                }
            });
        });
        $('#purchase-order').on('click',".DeleteOrder", function(){
            var button = $(this);
            var id = button.attr("data-id");
            var url = '{{ route('poly.booking.delete') }}';
            swal({
                title: 'Are you sure?',
                text: 'This booking will be removed permanently!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function(value) {
                if (value) {
                    //window.location.href = url;
                    //console.log(id);
                    $.ajax({
                        method:'DELETE',
                        url: url,
                        data:{id: id, _token: '{{csrf_token()}}'},
                        success:function(data){
                            if(data){
                                //console.log(data);
                                swal({
                                    title: "Operation Successful!",
                                    icon: "success",
                                    button: "Ok!",
                                }).then(function (value) {
                                    if(value){
                                        //console.log(value);
                                        window.location.href = window.location.href.replace(/#.*$/, '');
                                    }
                                });
                            }
                        },
                        error:function(error){
                            console.log(error);
                            swal({
                                title: "Operation Unsuccessful!",
                                text: "Somthing wrong happend please check!",
                                icon: "error",
                                button: "Ok!",
                                className: "myClass",
                            });
                        }
                    })
                }
            });
        });

        $('#purchase-order').on('click',".ReturnActiveOrder", function(){
            var button = $(this);
            var id = button.attr("data-id");
            var url = '{{ route('poly.booking.return-active') }}';
            swal({
                title: 'Are you sure?',
                text: 'This booking will be reactivated permanently!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function(value) {
                if (value) {
                    //window.location.href = url;
                    //console.log(id);
                    $.ajax({
                        method:'DELETE',
                        url: url,
                        data:{id: id, _token: '{{csrf_token()}}'},
                        success:function(data){
                            if(data){
                                //console.log(data);
                                swal({
                                    title: "Operation Successful!",
                                    icon: "success",
                                    button: "Ok!",
                                }).then(function (value) {
                                    if(value){
                                        //console.log(value);
                                        window.location.href = window.location.href.replace(/#.*$/, '');
                                    }
                                });
                            }
                        },
                        error:function(error){
                            console.log(error);
                            swal({
                                title: "Operation Unsuccessful!",
                                text: "Somthing wrong happend please check!",
                                icon: "error",
                                button: "Ok!",
                                className: "myClass",
                            });
                        }
                    })
                }
            });
        });

        $(function(){
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
            });
            $('#ItemAdd').submit(function(e){
                e.preventDefault();
                var data = $(this).serialize();
                var id = $('#DetailID').val();
                var masterId = $('#MasterID').val();
                //console.log(masterId);
                //return;
                var url = '{{ route('poly.booking.detail.save') }}';
                //console.log(data);
                $.ajax({
                    url: url,
                    method:'POST',
                    data:data,
                    success:function(data){
                        console.log(data);
                        if(id)
                        {
                            swal({
                                title: "Data Updated Successfully!",
                                icon: "success",
                                button: "Ok!",
                            }).then(function (value) {
                                if(value){
                                    window.location.href = window.location.href.replace(/#.*$/, '');
                                }
                            });
                        }
                        else
                        {
                            swal({
                                title: "Data Inserted Successfully!",
                                icon: "success",
                                button: "Ok!",
                            }).then(function (value) {
                                if(value){
                                    window.location.href = window.location.href.replace(/#.*$/, '');
                                }
                            });
                        }
                    },
                    error:function(error){
                        console.log(error);
                        swal({
                            title: "Data Not Saved!",
                            text: "Please Check Your Data!",
                            icon: "error",
                            button: "Ok!",
                            className: "myClass",
                        });
                    }
                })

            })
        });

        function getProductPrice(_category) {
            //console.log('dada');

            var categoryId = _category.value;
            var supplierId = '{{$purchaseOrder->supplier_id}}';
            var url = '{{ route('poly.product.get-price') }}';
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            });
            if (categoryId) {
                $.ajax({
                    url: url,
                    data: {id: categoryId, supplier: supplierId},
                    type: "POST",
                    dataType: "json",
                    success: function (data) {
                        //console.log(data);
                        document.forms["ItemAddForm"]["price_unit"].value = data.price_unit;
                        document.forms["ItemAddForm"]["unit_price"].value = data.unit_price;
                        document.forms["ItemAddForm"]["first_usd_conversion_value"].value = data.first_usd_conversion_value;
                        document.forms["ItemAddForm"]["second_usd_conversion_value"].value = data.second_usd_conversion_value;
                        document.forms["ItemAddForm"]["adhesive_price"].value = data.adhesive_price;
                        document.forms["ItemAddForm"]["printing_price"].value = data.printing_price;
                        document.forms["ItemAddForm"]["poly_type"].value = data.poly_type;
                        document.forms["ItemAddForm"]["currency"].value = data.currency;
                    }
                });
            } else {

            }
        }

        $('#ItemAdd').delegate('.PolyType, .Currency, .UnitPrice, .Qty, .ConversionRate, ' +
            '.Width,  .Length, .Thickness, .FlapType, .Flap, .QtyPerLBS,' +
            '.TotalLBSQty, .PcsPerLbs, .PxPcs, .FUSD, .SUSD, .AdehesivePrice,' +
            '.TotalAdehesivePrice, .PrintingPrice, .PrintingCount, .TotalPrintingPrice, .TotalUnitPrice,' +
            '.Total','keyup',function(){
            var tr = $(this).parent().parent().parent().parent().parent().parent();

            var approved_unit_price = parseFloat(tr.find('.UnitPrice').val()).toFixed(12);
            var poly_type = tr.find('.PolyType').val();
            var price_unit = tr.find('.PriceUnit').val();
            var currency = tr.find('.Currency').val();
            var order_qty = parseInt(tr.find('.Qty').val());
            var conversion_rate = parseFloat(tr.find('.ConversionRate').val()).toFixed(12);
            var input_width = tr.find('.Width').val();
            var width = parseFloat(tr.find('.Width').val()).toFixed(12);
            width = parseFloat(width/conversion_rate).toFixed(12);
            var input_length = tr.find('.Length').val();
            var length = parseFloat(tr.find('.Length').val()).toFixed(12);
            length = parseFloat(length/conversion_rate).toFixed(12);
            var thickness = parseFloat(tr.find('.Thickness').val()).toFixed(12);
            var flap_type =  tr.find('.FlapType').val();
            var input_flap = tr.find('.Flap').val();
            var flap = parseFloat(tr.find('.Flap').val()).toFixed(12);
            flap = parseFloat(flap/conversion_rate).toFixed(12);
            var fusd = parseFloat(tr.find('.FUSD').val()).toFixed(12);
            var susd = parseFloat(tr.find('.SUSD').val()).toFixed(12);
            var adhesive_price = parseFloat(tr.find('.AdhesivePrice').val()).toFixed(12);
            var printing_price = parseFloat(tr.find('.PrintingPrice').val()).toFixed(12);
            var printing_count = parseInt(tr.find('.PrintingCount').val());
            //console.log(adhesive_price);
            //return;

            if(poly_type == 'GP'){
                //console.log('GP');
                tr.find('.TotalUnitPrice').val(approved_unit_price);
                var gp_total_price = parseFloat(approved_unit_price * width * length * order_qty).toFixed(11);
                //var gp_total_price = (total_price);
                //tr.find('.TotalUnitPrice').val(hmg_total_unit_price);
                //var num_total_gp = gp_total_price.toString();
                //num_total_gp = num_total_gp.slice(0, (num_total_gp.indexOf("."))+ 4); //With 3 exposing the hundredths place
                var num_total_gp = upto3Decimal(gp_total_price);
                Number(num_total_gp); //If you need it back as a Number
                tr.find('.Total').val(num_total_gp);


                var gp_measurement = 'W' + '-' + ' ' +(input_width)+' '+'x'+' '+'L'+  '-'  +' '+(input_length);
                tr.find('.Measurement').val(gp_measurement);
            }
            else if(poly_type == 'H&MG'){
                var hmg_total_printing_price = parseFloat((printing_count * printing_price)/12).toFixed(10);
                tr.find('.TotalPrintingPrice').val(hmg_total_printing_price);

                var hmg_total_unit_price = parseFloat(approved_unit_price).toFixed(10);
                //console.log(total_unit_price);
                //return;
                tr.find('.TotalUnitPrice').val(hmg_total_unit_price);
                var hmg_main_price = parseFloat(width * length * hmg_total_unit_price * order_qty).toFixed(10);
                //console.log(hmg_main_price);
                //return;
                var hmg_second_price = parseFloat(order_qty * hmg_total_printing_price).toFixed(10);
                var hmg_total_price = parseFloat(hmg_main_price - (-hmg_second_price)).toFixed(10);
                //console.log("ConvRate: " + convRate);
                var total_sqm_price_hmg = (hmg_total_price);
                //var num_total_hmg = total_sqm_price_hmg.toString();
                //num_total_hmg = num_total_hmg.slice(0, (num_total_hmg.indexOf("."))+ 4); //With 3 exposing the hundredths place
                var num_total_hmg = upto3Decimal(total_sqm_price_hmg);
                Number(num_total_hmg); //If you need it back as a Number
                tr.find('.Total').val(num_total_hmg);

                var pp_measurement = 'W'+ '-' + ' '+(input_width)+' '+'x'+' '+'L'+ '-' + ' '+ (input_length); /* +'/'+' '+'T'+' '+(tr.find('.Thickness').val());*/
                tr.find('.Measurement').val(pp_measurement);
            }
            else if(poly_type == 'PP'){
                var pp_pcs_per_lbs = parseFloat(((75000/width)/(length-(-flap/2)))/thickness).toFixed(12);
                //console.log(pp_pcs_per_lbs);
                //return
                var pp_px_pcs = parseFloat((approved_unit_price * fusd)/pp_pcs_per_lbs).toFixed(12);
                tr.find('.PcsPerLbs').val(pp_pcs_per_lbs);
                tr.find('.PxPcs').val(pp_px_pcs);
                var pp_total_adhesive_price = parseFloat((adhesive_price /12) * fusd).toFixed(12);
                //console.log(total_adhesive_price);
                //return;
                //tr.find('.TotalAdhesivePrice').val(pp_total_adhesive_price);
                var pp_total_unit_price = parseFloat((pp_total_adhesive_price - (-pp_px_pcs))/susd).toFixed(6);
                // console.log( parseFloat((pp_total_adhesive_price - (-pp_px_pcs))/susd));
                //return;
                tr.find('.TotalUnitPrice').val(pp_total_unit_price);
                var pp_total_price = order_qty * pp_total_unit_price;
                //console.log("ConvRate: " + convRate);
                var total_sqm_price_pp = upto3Decimal(pp_total_price);
                //var num_total_pp = total_sqm_price_pp.toString();
                //console.log(num_total_pp);
                //return;
                //num_total_pp = num_total_pp.slice(0, (num_total_pp.indexOf("."))+ 4); //With 3 exposing the hundredths place
                Number(total_sqm_price_pp); //If you need it back as a Number
                tr.find('.Total').val(total_sqm_price_pp);

                var pp_measurement = 'W'+ '-' +' '+(input_width)+' '+'x'+' '+'L'+ '-' + ' ' + '(' +(input_length) + '+' + 'F' + '-' + ' ' + (tr.find('.Flap').val()) +')' ; /* +'/'+' '+'T'+' '+(tr.find('.Thickness').val());*/
                tr.find('.Measurement').val(pp_measurement);
            }
            else if(poly_type == 'SP' || poly_type == 'ZWP' || poly_type == 'LP' || poly_type == 'H&MB'){
                var sp_total_unit_price = approved_unit_price;

                if(price_unit == 'DZN'){
                    sp_total_unit_price = parseFloat(sp_total_unit_price/12).toFixed(10);
                }
                else if(price_unit == 'LBS'){
                    sp_total_unit_price = parseFloat(sp_total_unit_price).toFixed(10);
                }
                else{
                    sp_total_unit_price = parseFloat(sp_total_unit_price).toFixed(10);
                }

                tr.find('.TotalUnitPrice').val(sp_total_unit_price);
                var sp_total_price = parseFloat(sp_total_unit_price * order_qty).toFixed(10);
                //var num_total_sp = sp_total_price.toString();
                //num_total_sp = num_total_sp.slice(0, (num_total_sp.indexOf("."))+ 4); //With 3 exposing the hundredths place
                var num_total_sp = upto3Decimal(sp_total_price);
                Number(num_total_sp); //If you need it back as a Number
                tr.find('.Total').val(num_total_sp);
                var sp_measurement = 'W' + '-' +' '+(input_width)+' '+'x'+' '+'L'+ '-' +' '+ '(' +(input_length) + '+' + 'F' + '-' + ' ' + (tr.find('.Flap').val()) +')' ; /* +'/'+' '+'T'+' '+(tr.find('.Thickness').val());*/
                tr.find('.Measurement').val(sp_measurement);
            }
            else if(poly_type == 'NPP'){
                tr.find('.TotalUnitPrice').val(approved_unit_price);
                var npp_qty_per_lbs = parseFloat(((75000/width)/length)/thickness).toFixed(10);
                tr.find('.QtyPerLBS').val(npp_qty_per_lbs);
                var npp_pcs_per_lbs = parseFloat(order_qty/npp_qty_per_lbs).toFixed(10);
                tr.find('.TotalLBSQty').val(npp_pcs_per_lbs);

                var npp_total_price = parseFloat(npp_pcs_per_lbs * approved_unit_price).toFixed(10);
                //var gp_total_price = (total_price);
                //var num_total_npp = npp_total_price.toString();
                //num_total_npp = num_total_npp.slice(0, (num_total_npp.indexOf("."))+ 4); //With 3 exposing the hundredths place
                var num_total_npp = upto3Decimal(npp_total_price);
                Number(num_total_npp); //If you need it back as a Number
                tr.find('.Total').val(num_total_npp);

                var npp_measurement = 'W' + '-' +' '+(input_width)+' '+'x'+' '+'L' + '-' +' '+(input_length); /* +'/'+' '+'T'+' '+(tr.find('.Thickness').val());*/
                tr.find('.Measurement').val(npp_measurement);
            }
            else if(poly_type == 'APC' || poly_type == 'APH&M' || poly_type == 'APR'){
                //console.log( 'Width: '+ width);
                //console.log('Length: '+ length);
                //console.log('Flap: '+ flap);
                //return;
                //var cal_length = length+(flap/2);
                var pcs_per_lbs = parseFloat(((75000/width)/(length-(-flap/2)))/thickness).toFixed(10);
                // console.log('pcs_per_lbs: '+ pcs_per_lbs);
                //return;
                var px_pcs = parseFloat(approved_unit_price/pcs_per_lbs).toFixed(10);
                //console.log('px_pcs: '+ px_pcs);
                //return;
                tr.find('.PcsPerLbs').val(pcs_per_lbs);
                tr.find('.PxPcs').val(px_pcs);
                var total_adhesive_price = parseFloat(adhesive_price * width).toFixed(10);
                //console.log(total_adhesive_price);
                //return;
                tr.find('.TotalAdhesivePrice').val(total_adhesive_price);
                var total_printing_price = parseFloat(printing_count * printing_price).toFixed(10);
                tr.find('.TotalPrintingPrice').val(total_printing_price);
                //console.log(total_printing_price);
                // return;
                //var test = parseFloat((total_adhesive_price + (total_printing_price) + (px_pcs))/susd).toFixed(10);
                var total_unit_price = parseFloat((total_adhesive_price - (-total_printing_price) - (-px_pcs))/susd).toFixed(10);
                //console.log(total_unit_price);
                //return;

                tr.find('.TotalUnitPrice').val(total_unit_price);
                var total_price = order_qty * total_unit_price;
                //console.log("ConvRate: " + convRate);
                var total_sqm_price_b = (total_price);
                //var num_total_b = total_sqm_price_b.toString();
                //num_total_b = num_total_b.slice(0, (num_total_b.indexOf("."))+ 4); //With 3 exposing the hundredths place
                var num_total_b = upto3Decimal(total_sqm_price_b);
                Number(num_total_b); //If you need it back as a Number
                tr.find('.Total').val(num_total_b);
                //console.log(poly_type);
                //return;
                var apc_measurement = 'W' + '-' +' '+(input_width)+' '+'x'+' '+'L' + '-'  +' '+ '(' +(input_length) + '+' + 'F' + '-' + ' ' + (tr.find('.Flap').val()) +')' ; /* +'/'+' '+'T'+' '+(tr.find('.Thickness').val());*/
                tr.find('.Measurement').val(apc_measurement);
            }

            function upto3Decimal(num) {
                if (num > 0)
                    return Math.floor(num * 1000) / 1000;
                else
                    return Math.ceil(num * 1000) / 1000;
            }

            function upto2Decimal(num) {
                if (num > 0)
                    return Math.floor(num * 100) / 100;
                else
                    return Math.ceil(num * 100) / 100;
            }
        });

        Number.prototype.toMoney = function(decimals, decimal_sep, thousands_sep)
        {
            var n = this,
                c = isNaN(decimals) ? 2 : Math.abs(decimals),
                d = decimal_sep || '.',
                t = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                sign = (n < 0) ? '-' : '',
                i = parseInt(n = Math.abs(n).toFixed(c)) + '',
                j = ((j = i.length) > 3) ? j % 3 : 0;
            return sign + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : '');
        };

        function refresh()
        {
            window.location.href = window.location.href.replace(/#.*$/, '');
        }

        function iconChange() {

            $('#iconChange').find('i').addClass('fa-edit');

        }
        $('#purchase-order').on('click',".ResetPO", function(){
            var button = $(this);
            var id = button.attr("data-id");
            var url = '{{ route('admin.lpd.reset-po') }}';
            swal({
                title: 'Are you sure?',
                text: 'This booking po no will be reset permanently!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function(value) {
                if (value) {
                    //window.location.href = url;
                    //console.log(id);
                    $.ajax({
                        method:'DELETE',
                        url: url,
                        data:{id: id, _token: '{{csrf_token()}}'},
                        success:function(data){
                            if(data){
                                //console.log(data);
                                swal({
                                    title: "Operation Successful!",
                                    icon: "success",
                                    button: "Ok!",
                                }).then(function (value) {
                                    if(value){
                                        //console.log(value);
                                        window.location.href = window.location.href.replace(/#.*$/, '');
                                    }
                                });
                            }
                        },
                        error:function(error){
                            console.log(error);
                            swal({
                                title: "Operation Unsuccessful!",
                                text: "Somthing wrong happend please check!",
                                icon: "error",
                                button: "Ok!",
                                className: "myClass",
                            });
                        }
                    })
                }
            });
        });
    </script>
@endsection()


