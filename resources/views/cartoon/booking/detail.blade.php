@extends('layouts.admin.admin-master')
@section('title')
    Carton & Board
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
        <h2>Carton & Board <span> Booking Details</span></h2>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{route('home')}}"><i class="fa fa-home"></i> Dashboard</a>
                </li>
                <li>
                    <a href="#"> Carton & Board</a>
                </li>
                <li>
                    <a href="{{route('cartoon.booking.recent')}}"> Recent Bookings</a>
                </li>
                <li>
                    <a href="{{route('cartoon.booking.detail', ['id', $purchaseOrder->id ])}}"> LPD PO NO: {{$purchaseOrder->lpd_po_no}}</a>
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
                                            <a title="Edit Booking Master Update" class ="myIcon icon-warning icon-ef-3 icon-ef-3b icon-color" href="{{route('cartoon.booking.edit', ['id' => $purchaseOrder->id])}}" {{--data-toggle="modal" data-target="#POUpdateModal" --}}data-options="splash-2 splash-ef-12">
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
                                    <a title="PDF View" class ="myIcon icon-danger icon-ef-3 icon-ef-3b icon-color" {{--target="_blank"--}} href="{{route('cartoon.booking.detail.pdf', ['id' => $purchaseOrder->id])}}">
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
                                                @if(Auth::user()->hasTaskPermission('deletecb', Auth::user()->id))
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
                                                                        <input type="hidden" id="IsBoard" name="is_board">
                                                                        <input type="hidden" id="MasterID" name="purchase_order_master_id" value="{{old('purchase_order_master_id', $purchaseOrder->id)}}">
                                                                        <div class="row" style="padding: 0px 15px;">
                                                                            <div class="col-md-6 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="ProductID" class="control-label">Select Product</label>
                                                                                    <select id="ProductID" class="form-control select2" name="cartoon_product_setup" required style="width: 100%;" onchange="javascript:getMeasurementDetailList(this)">
                                                                                        <option value="">- - - Select - - -</option>
                                                                                        @if(!empty($products))
                                                                                            @foreach($products as $group)
                                                                                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                                                                            @endforeach'
                                                                                        @endif'
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="MDetailID" class="control-label">Measurement Details</label>
                                                                                    <select id="MDetailID" class="form-control select2" name="measurement_detail" required style="width: 100%;" onchange="javascript:getProductPrice(this)">
                                                                                        <option value="">- - - Select - - -</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="InputUnitID" class="control-label">Input Unit</label>
                                                                                    <select id="InputUnitID" class="form-control select2" name="input_unit" required style="width: 100%;" onchange="javascript:getConvUnitList(this)">
                                                                                        <option value="">- - - Select - - -</option>
                                                                                        @if(!empty($units))
                                                                                            @foreach($units as $group)
                                                                                                <option value="{{ $group->id }}">{{ $group->full_unit }}</option>
                                                                                            @endforeach'
                                                                                        @endif'
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="ConvUnitID" class="control-label">Conv. Unit</label>
                                                                                    <select id="ConvUnitID" class="form-control select2" name="conversion_unit" required style="width: 100%;" onchange="javascript:getConvRate(this)">
                                                                                        <option value="">- - - Select - - -</option>
                                                                                        {{--@if(!empty($units))
                                                                                            @foreach($units as $group)
                                                                                                <option value="{{ $group->id }}">{{ $group->full_unit }}</option>
                                                                                            @endforeach'
                                                                                        @endif'--}}
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="ConvRate" class="control-label">Conv. Rate</label>
                                                                                    <input type="number" step="any" class="form-control ConvRate" name="unit_conversion_rate" id="ConvRate" readonly required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label class="checkbox checkbox-custom-alt checkbox-custom-lg" style="padding-top: 17px">
                                                                                        <input name="no_cal" class="NoCal" id="NoCal" type="checkbox"><i></i> <strong>No Calculation!</strong>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="padding: 0px 15px;">
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="Length" class="control-label">Length</label>
                                                                                    <input type="number" step="any" class="form-control Length" name="length" id="Length" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="Width" class="control-label">Width</label>
                                                                                    <input type="number" step="any" class="form-control Width" name="width" id="Width" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="Height" class="control-label">Height</label>
                                                                                    <input type="number" step="any" class="form-control Height" name="height" id="Height">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="Extra" class="control-label">Extra</label>
                                                                                    <input type="number" step="any" class="form-control Extra" name="extra" id="Extra" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="Length_Width" class="control-label">Length + Width</label>
                                                                                    <input type="number" step="any" class="form-control LengthWidth" name="length_width" id="Length_Width" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="Width_Height" class="control-label">Width + Height</label>
                                                                                    <input type="number" step="any" class="form-control WidthHeight" name="width_height" id="Width_Height" readonly>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="row" style="padding: 0px 15px;">
                                                                            <div class="col-md-3 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="Width_Height_Round" class="control-label">Width + Height(Round)</label>
                                                                                    <input type="number" step="any" class="form-control WidthHeightRound" name="width_height_round" id="Width_Height_Round">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="TotalSQM" class="control-label">Total SQM</label>
                                                                                    <input type="number" step="any" class="form-control TotalSQM" name="square_meter" id="TotalSQM" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="UnitPerSQMPrice" class="control-label">Unit Per SQM Price (USD)</label>
                                                                                    <input type="number" id="UnitPerSQMPrice" class="form-control UnitPerSQMPrice" step="any" name="unit_per_square_meter_price" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="PerSQMPrice" class="control-label">Per Carton/Board Value (USD)</label>
                                                                                    <input type="number" id="PerSQMPrice" class="form-control PerSQMPrice" step="any" name="per_square_meter_price" required readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="padding: 0px 15px;">
                                                                            <div class="col-md-4 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="Qty" class="control-label">Order Quantity</label>
                                                                                    <input type="number" min="1" id="Qty" class="form-control Qty" step="any" name="order_quantity" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 no-padding">
                                                                                <div class="form-group">
                                                                                    <label for="Total" class="control-label">Total Price (USD)</label>
                                                                                    <input type="number" step="any" id="Total" class="form-control Total" readonly = "" name="total_price" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 no-padding">
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
                                                            @if(!empty($uniqueProducts))
                                                                @foreach($uniqueProducts as $uproduct)
                                                            <div class="table-responsive">
                                                                <table class="table table-hover table-bordered table-condensed table-responsive" id="advanced-usage{{$uproduct->id}}">
                                                                    <thead>
                                                                    <tr style="background-color: #1693A5; color: white;">
                                                                        <th class="text-center">Length</th>
                                                                        <th class="text-center">Width</th>
                                                                        <th class="text-center">Height</th>
                                                                        <th class="text-center">Unit</th>
                                                                        <th class="text-center">SQM</th>
                                                                        <th class="text-center">Unit Per SQM Price (USD)</th>
                                                                        <th class="text-center">Total SQM Price (USD)</th>
                                                                        <th class="text-center">Order Qty</th>
                                                                        <th class="text-center">Total Price (USD)</th>
                                                                        <th class="text-center">Remarks</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                                <h5 class="text-left"><strong>{{$uproduct->name}}</strong></h5>
                                                                                @foreach($details as $item)
                                                                                    @if($item->cartoon_product_setup_id == $uproduct->id)
                                                                                        <tr>
                                                                                            <td class="text-left">{{$item->length}}</td>
                                                                                            <td class="text-left">{{$item->width}}</td>
                                                                                            <td class="text-left">{{$item->height}}</td>
                                                                                            <td class="text-center">{{ (App\Helpers\Helper::IDwiseData('units','id',$item->input_unit_id))->full_unit }}</td>
                                                                                            <td class="text-left">{{$item->square_meter}}</td>
                                                                                            @if($item->no_cal == true)
                                                                                                <td class="text-center">-{{--$ {{ $item->unit_per_square_meter_price }}--}}</td>
                                                                                                @else
                                                                                                <td class="text-right">$ {{ $item->unit_per_square_meter_price }}</td>
                                                                                                @endif

                                                                                            @if($item->no_cal == true)
                                                                                                <td class="text-right">$ {{ $item->unit_per_square_meter_price }}</td>
                                                                                                @else
                                                                                                <td class="text-right">$ {{ $item->per_square_meter_price }}</td>
                                                                                                @endif
                                                                                            <td class="text-right">{{ $item->order_quantity }}</td>
                                                                                            <td class="text-right">$ {{ $item->total_price }}</td>
                                                                                            <td class="text-right">{{$item->remarks}}</td>
                                                                                            <td class="text-center">
            {{--                                                                                    <button class="btn btn-info btn-xs" data-toggle="modal" data-target="#user{{$item->id}}" data-options="splash-2 splash-ef-12"><i class="fa fa-eye"></i></button>--}}
                                                                                                @if(Auth::user()->hasTaskPermission('updatecbitem', Auth::user()->id))
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

        @if(!empty($uniqueProducts))
        @foreach($uniqueProducts as $uproduct)
        $('#advanced-usage{{$uproduct->id}}').on('click',".DeleteDetail", function(){
            var button = $(this);
            var id = button.attr("data-id");
            var url = '{{ route('cartoon.booking.detail.delete') }}';
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
            var url = '{{ route('cartoon.booking.urgent') }}';
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

        $('#purchase-order').on('click',".ReviseOrder", function(){
            var button = $(this);
            var id = button.attr("data-id");
            var url = '{{ route('cartoon.booking.revise') }}';
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
            var url = '{{ route('cartoon.booking.delete') }}';
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
            var url = '{{ route('cartoon.booking.return-active') }}';
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
                var url = '{{ route('cartoon.booking.detail.save') }}';
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

        function getMeasurementDetailList(_category){
            var productId = _category.value;
            var supplierId = '{{$purchaseOrder->supplier_id}}';
            var url = '{{ route('cartoon.product.get-measurement-detail-list') }}';
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            });
            if(productId){
                $.ajax({
                    url: url,
                    data: {cartoon_product_setup_id: productId, supplier_id:supplierId},
                    type: "POST",
                    dataType: "json",
                    success: function (data) {
                        //document.forms["ItemAddForm"]["unit_per_square_meter_price"].value = data.unit_per_square_meter_price;
                        //document.forms["ItemAddForm"]["is_board"].value = data.is_board;
                        defaultKey = " ";
                        defaultValue = "- - - Select - - -";
                        $('select[id= "MDetailID"]').empty();

                        $('select[id= "MDetailID"]').append('<option value="'+ defaultKey +'">'+ defaultValue +'</option>');
                        $.each(data, function(key,value){
                            //console.log(data);
                            $('select[id= "MDetailID"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        //$('#YarnCountName').trigger('chosen:updated');
                        $('.select2').select2();
                    }
                });
            }
            else{
                defaultKey = " ";
                defaultValue = "- - - Select - - -";

                $('select[id= "MDetailID"]').empty();
                $('select[id= "MDetailID"]').append('<option value="'+ defaultKey +'">'+ defaultValue +'</option>');
                $('.select2').select2();
            }
        }
        function getProductPrice(_category) {
            var categoryId = _category.value;
            var productId =  $('select[id= "ProductID"]').val();
            var supplierId = '{{$purchaseOrder->supplier_id}}';
            var url = '{{ route('cartoon.product.get-price') }}';
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            });
            if (categoryId) {
                $.ajax({
                    url: url,
                    data: {cartoon_product_setup_id: productId, supplier_id: supplierId, measurement_detail: categoryId},
                    type: "POST",
                    dataType: "json",
                    success: function (data) {
                        document.forms["ItemAddForm"]["unit_per_square_meter_price"].value = data.unit_per_square_meter_price;
                        document.forms["ItemAddForm"]["is_board"].value = data.is_board;
                        document.forms["ItemAddForm"]["length"].value = data.length;
                        document.forms["ItemAddForm"]["width"].value = data.width;
                        document.forms["ItemAddForm"]["height"].value = data.height;
                        //$('select[name=input_unit]').val(data.input_unit_id).change();
                        $('select[id= "InputUnitID"]').val(data.input_unit).change();

                        if(data.length > 0){
                            $('input[name=no_cal]').prop('checked', true);
                        }
                        else{
                            $('input[name=no_cal]').prop('checked', false);
                        }
                    }
                });
            } else {
                document.forms["ItemAddForm"]["unit_per_square_meter_price"].value = 0;
                document.forms["ItemAddForm"]["is_board"].value = 0;
                document.forms["ItemAddForm"]["length"].value = 0;
                document.forms["ItemAddForm"]["width"].value = 0;
                document.forms["ItemAddForm"]["height"].value = 0;
                $('select[id= "InputUnitID"]').val().change();
                $('input[name=no_cal]').prop('checked', false);
            }
        }

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
                        $('select[id= "ConvUnitID"]').empty();

                        $('select[id= "ConvUnitID"]').append('<option value="'+ defaultKey +'">'+ defaultValue +'</option>');
                        $.each(data, function(key,value){
                            //console.log(data);
                            $('select[id= "ConvUnitID"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        //$('#YarnCountName').trigger('chosen:updated');
                        $('.select2').select2();
                        document.forms["ItemAddForm"]["unit_conversion_rate"].value = "";
                    }
                });
            } else {
                //document.forms["ItemAddForm"]["unit_per_square_meter_price"].value = 0;
                //document.forms["ItemAddForm"]["is_board"].value = 0;
                defaultKey = " ";
                defaultValue = "- - - Select - - -";

                $('select[id= "ConvUnitID"]').empty();
                $('select[id= "ConvUnitID"]').append('<option value="'+ defaultKey +'">'+ defaultValue +'</option>');
                $('.select2').select2();
                document.forms["ItemAddForm"]["unit_conversion_rate"].value = "";
            }
        }

        function getConvRate(_category) {

            var to_unit_id = parseInt(_category.value);
            var from_unit_id = parseInt($("#InputUnitID").children("option:selected").val());
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
                        document.forms["ItemAddForm"]["unit_conversion_rate"].value = data.unit_conversion_rate;
                        if(from_unit_id == 3){
                            document.forms["ItemAddForm"]["extra"].value = 5;
                        }
                        else{
                            document.forms["ItemAddForm"]["extra"].value = 2;
                        }

                        //document.forms["ItemAddForm"]["is_board"].value = data.is_board;

                    }
                });
            } else {
                document.forms["ItemAddForm"]["unit_conversion_rate"].value = 0;
                document.forms["ItemAddForm"]["extra"].value = 0;
                //document.forms["ItemAddForm"]["is_board"].value = 0;

            }
        }

        $('#ItemAdd').delegate('.ConvRate, .Length, .Width, .Height, .Extra, .LengthWidth, .WidthHeight,' +
            '.WidthHeightRound, .TotalSQM, .UnitPerSQMPrice, .PerSQMPrice ,.Qty, .Total','keyup',function(){
            var tr = $(this).parent().parent().parent().parent().parent().parent();
            var no_cal = '';
            if(document.getElementById('NoCal').checked) {
                no_cal = 'on';
            } else {
                no_cal = '';
            }
            //console.log(no_cal);
            //return;
            var is_board = parseInt($("#IsBoard").val());
            //console.log("is_board: " + is_board);
            var length = parseFloat(tr.find('.Length').val()).toFixed(6);
            //console.log("Length: " + length);
            var width = parseFloat(tr.find('.Width').val()).toFixed(6);
            //console.log("Width: " + width);
            var height = parseFloat(tr.find('.Height').val()).toFixed(6);
            //console.log("Height: " + height);
            var extra = parseFloat(tr.find('.Extra').val()).toFixed(6);
            //console.log("Extra: " + extra);
            var convRate = parseFloat(tr.find('.ConvRate').val()).toFixed(6);

            var qty = parseInt(tr.find('.Qty').val());

            //console.log("ConvRate: " + convRate);

            if(is_board == 0){
                //console.log('is_board');
                //return;
                var length_width = (length - (-width) - (-extra))/convRate;
                var result_length_width = parseFloat(length_width).toFixed(12);
                //var num = result_length_width.toString(); //If it's not already a String
                //num = num.slice(0, (num.indexOf("."))+3); //With 3 exposing the hundredths place
                var num = upto2Decimal(result_length_width);
                Number(num); //If you need it back as a Number

                //var result_length_width_final = num;
                //console.log("length_width: " + result_length_width_final);
                tr.find('.LengthWidth').val(num);

                var width_height = (width - (-height))/convRate;
                var result_width_height = parseFloat(width_height).toFixed(12);
                //var num_w = result_width_height.toString(); //If it's not already a String
               //num_w = num_w.slice(0, (num_w.indexOf("."))+3); //With 3 exposing the hundredths place
                var num_w = upto2Decimal(result_width_height);
                Number(num_w); //If you need it back as a Number
                tr.find('.WidthHeight').val(num_w);

                //sqm calculation
                var new_length_width = parseFloat(tr.find('.LengthWidth').val()).toFixed(12);
                //console.log("Width_Height: " + new_length_width);
                var width_height_round = parseFloat(tr.find('.WidthHeightRound').val()).toFixed(12);
                //console.log("Width_Height_Round: " + width_height_round);
                var total_sqm = (new_length_width * width_height_round * 2)/1550;
                var result_total_sqm = parseFloat(total_sqm).toFixed(12);
                var num_sqm = result_total_sqm.toString();
                //num_sqm = num_sqm.slice(0, (num_sqm.indexOf("."))+3); //With 3 exposing the hundredths place
                //var num_sqm = upto2Decimal(result_total_sqm);
                Number(num_sqm); //If you need it back as a Number
                tr.find('.TotalSQM').val(num_sqm);

                //per sqm price calc
                var unit_sqm_price = parseFloat(tr.find('.UnitPerSQMPrice').val()).toFixed(12);

                var per_sqm_price = ((parseFloat(num_sqm).toFixed(12)) * unit_sqm_price);
               // var per_sqm_total = per_sqm_price.toString();
                //per_sqm_total = per_sqm_total.slice(0, (per_sqm_total.indexOf("."))+4); //With 3 exposing the hundredths place
                var per_sqm_total = upto3Decimal(per_sqm_price);
                Number(per_sqm_total); //If you need it back as a Number
                tr.find('.PerSQMPrice').val(per_sqm_total);

                //total price calc
                var per_sqm_price_n = parseFloat(tr.find('.PerSQMPrice').val()).toFixed(12);
                var total_sqm_price = 0;
                if(no_cal == 'on'){
                    //console.log("cal");
                    total_sqm_price = (unit_sqm_price * qty);
                }
                else{
                    //console.log("cal");
                    total_sqm_price = (per_sqm_price_n * qty);
                }

                //console.log(total_sqm_price);
                //return;

                //var num_total = total_sqm_price.toString();
                //num_total = num_total.slice(0, (num_total.indexOf("."))+4); //With 3 exposing the hundredths place
                //Number(num_total); //If you need it back as a Number

                var num_total = upto3Decimal(total_sqm_price);
                Number(num_total);
                tr.find('.Total').val(num_total);
            }
            else{
                var length_width_b = (length * width);
                var result_length_width_b = parseFloat(length_width_b).toFixed(12);
                var num_b = result_length_width_b.toString(); //If it's not already a String
                num_b = num_b.slice(0, (num_b.indexOf("."))+3); //With 3 exposing the hundredths place
                Number(num_b); //If you need it back as a Number

                //var result_length_width_final = num;
                //console.log("length_width: " + result_length_width_final);
                tr.find('.LengthWidth').val(num_b);
                var from_unit_id = parseInt($("#InputUnitID").children("option:selected").val());

                if(from_unit_id == 3){
                    //for cm
                    var new_length_width_b = parseFloat(tr.find('.LengthWidth').val()).toFixed(12);
                    var total_sqm_b = (new_length_width_b)/10000;
                    var result_total_sqm_b = parseFloat(total_sqm_b).toFixed(12);
                    var num_sqm_b = result_total_sqm_b.toString();
                    //num_sqm_b = num_sqm_b.slice(0, (num_sqm_b.indexOf("."))+3); //With 3 exposing the hundredths place
                    //var num_sqm_b = upto2Decimal(result_total_sqm_b);
                    Number(num_sqm_b); //If you need it back as a Number
                    tr.find('.TotalSQM').val(num_sqm_b);

                    //per sqm price calc
                    var unit_sqm_price_b = parseFloat(tr.find('.UnitPerSQMPrice').val()).toFixed(12);
                    var per_sqm_price_b = ((parseFloat(num_sqm_b).toFixed(12)) * unit_sqm_price_b);
                    //var per_total_b = per_sqm_price_b.toString();
                    //console.log(per_total_b);
                    //per_total_b = per_total_b.slice(0, (per_total_b.indexOf("."))+4); //With 3 exposing the hundredths place
                    var per_total_b = upto3Decimal(per_sqm_price_b);
                    Number(per_total_b); //If you need it back as a Number
                    tr.find('.PerSQMPrice').val(per_total_b);

                    //total price calc
                    var per_sqm_price_b_n = parseFloat(tr.find('.PerSQMPrice').val()).toFixed(12);
                    var total_sqm_price_b = 0;
                    if(no_cal == 'on'){
                        total_sqm_price_b = (unit_sqm_price_b * qty);
                    }
                    else{
                        total_sqm_price_b = (per_sqm_price_b_n * qty);
                    }

                    //var num_total_b = total_sqm_price_b.toString();
                    //num_total_b = num_total_b.slice(0, (num_total_b.indexOf("."))+4); //With 3 exposing the hundredths place
                    //Number(num_total_b); //If you need it back as a Number

                    var num_total_b = upto3Decimal(total_sqm_price_b);
                    tr.find('.Total').val(num_total_b);
                }
                else{
                    //for inch
                    var new_length_width_b_i = parseFloat(tr.find('.LengthWidth').val()).toFixed(12);
                    var total_sqm_b_i = (new_length_width_b_i)/1550;
                    var result_total_sqm_b_i = parseFloat(total_sqm_b_i).toFixed(12);
                    var num_sqm_b_i = result_total_sqm_b_i.toString();
                    //num_sqm_b_i = num_sqm_b_i.slice(0, (num_sqm_b_i.indexOf("."))+3); //With 3 exposing the hundredths place
                    Number(num_sqm_b_i); //If you need it back as a Number
                    tr.find('.TotalSQM').val(num_sqm_b_i);

                    //per sqm price calc
                    var unit_sqm_price_b_i = parseFloat(tr.find('.UnitPerSQMPrice').val()).toFixed(12);
                    var per_sqm_price_b_i = ((parseFloat(num_sqm_b_i).toFixed(12)) * unit_sqm_price_b_i);
                    //var per_total_b_i = per_sqm_price_b_i.toString();
                    //per_total_b_i = per_total_b_i.slice(0, (per_total_b_i.indexOf("."))+4); //With 3 exposing the hundredths place
                    var per_total_b_i = upto3Decimal(per_sqm_price_b_i);
                    Number(per_total_b_i); //If you need it back as a Number
                    tr.find('.PerSQMPrice').val(per_total_b_i);

                    //total price calc
                    var per_sqm_price_b_i_n = parseFloat(tr.find('.PerSQMPrice').val()).toFixed(12);
                    var total_sqm_price_b_i = 0;
                    if(no_cal == 'on'){
                        total_sqm_price_b_i = (unit_sqm_price_b_i * qty);
                    }
                    else{
                        total_sqm_price_b_i = (per_sqm_price_b_i_n * qty);
                    }

                    //var num_total_b_i = total_sqm_price_b_i.toString();
                    //num_total_b_i = num_total_b_i.slice(0, (num_total_b_i.indexOf("."))+4); //With 3 exposing the hundredths place
                    var num_total_b_i = upto3Decimal(total_sqm_price_b_i);
                    Number(num_total_b_i); //If you need it back as a Number
                    tr.find('.Total').val(num_total_b_i);
                }
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

    </script>
@endsection()


