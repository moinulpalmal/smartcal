@extends('layouts.admin.admin-master')

@section('title')
    Interlining
@endsection
@section('content')
    <style type="text/css">
       /* th{
            background-color: #0689bd;
            color: white;
        }*/

        .tile-body{
            background-color: white;
        }
        .tile-header{
            color: white;
        }
        .tile-header{
            background-color:#105e7d;
        }

        #items td, #items th {
            border: 1px solid black !important;
        }
    </style>
    <div class="page page-dashboard">
        <div class="pageheader">
            <h2>Interlining <span> Booking Details</span></h2>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{route('home')}}"><i class="fa fa-home"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#"> Fabric</a>
                    </li>
                    <li>
                        <a href="{{route('interlining.booking.recent')}}"> Recent Bookings</a>
                    </li>
                    <li>
                        <a href="{{route('interlining.booking.detail', ['id' => $master->id ])}}"> LPD PO NO: {{$master->lpd_po_no}}</a>
                    </li>
                    <li>
                        <a href="#"> Print View</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- row -->
        <div class="add-nav">
            <div class="nav-heading">
                <h3>LPD PO No : <strong class="text-greensea">{{$master->lpd_po_no}}</strong></h3>
                <span class="controls pull-right">
                    <a href="{{route('interlining.booking.detail', ['id' => $master->id ])}}" class="btn btn-ef btn-ef-1 btn-ef-1-default btn-ef-1a btn-rounded-20 mr-5" data-toggle="tooltip" title="Back"><i class="fa fa-times"></i></a>
{{--                    <a href="javascript:;" class="btn btn-ef btn-ef-1 btn-ef-1-default btn-ef-1a btn-rounded-20 mr-5" data-toggle="tooltip" title="Send"><i class="fa fa-envelope"></i></a>--}}
                    <a href="javascript:window.print()" class="btn btn-ef btn-ef-1 btn-ef-1-default btn-ef-1a btn-rounded-20" data-toggle="tooltip" title="Print"><i class="fa fa-print"></i></a>
                </span>
            </div>
            <div role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Details</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="details">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <!-- tile -->
                                <section class="tile tile-simple bg-tr-black lter">
                                    <!-- tile body -->
                                    <div class="tile-body">
                                        <!-- row -->
                                        <div class="row">
                                            <!-- col -->
                                            <div class="col-md-3 text-left">
                                                <a href="#" title="Palmal Group of Industries"><img src="{{ asset('/') }}imageFolder/logo.jpg" alt="" class="thumb thumb-lg m-10 mb-20">
                                                    {{--                                                    <p class="text-default lt"> 9/Kha Confidence Center, Shahazadpur, Gulshan, Dhaka-1212</p>--}}
                                                </a>
                                            </div>
                                            <!-- /col -->
                                            <div class="col-md-5 text-center">
                                                <p class="mb-0 text-strong text-uppercase" style="font-size: x-large !important;">&nbsp;&nbsp;PURCHASE ORDER</p>
                                            </div>
                                            <!-- col -->
                                            <div class="col-md-4 text-right">
                                                <h3 class="mb-0 text-custom text-strong">Palmal Group of Industries</h3>
                                                <p class="text-default lt"> 9/Kha Confidence Center, <br>Shahazadpur, Gulshan, Dhaka-1212</p>

                                            </div>
                                            <!-- /col -->

                                        </div>
                                        <!-- /row -->


                                        <!-- row -->
                                        <!-- row -->
                                        <div class="row b-t pt-20">                                            <!-- col -->

                                            <div class="col-md-6 text-left">
                                                <ul class="list-unstyled text-default lt mb-20">
                                                    <li style="font-size: medium;"><strong>LPD PO NO:</strong> {{$master->lpd_po_no}}</li>
                                                    <li><strong>Date:</strong> {{\Carbon\Carbon::parse($master->lpd_po_date)->format('j-M-Y')}}</li>
                                                    <li><strong>Supplier Name:</strong> {{(App\Helpers\Helper::IDwiseData('suppliers','id', $master->supplier_id))->name}}</li>
                                                    <li><strong>Attention:</strong> {{(App\Helpers\Helper::IDwiseData('suppliers','id', $master->supplier_id))->primary_contact_person}}</li>
                                                    <li><strong>Delivery Place:</strong> {{(App\Helpers\Helper::IDwiseData('delivery_locations','id', $master->delivery_location_id))->name}}</li>
                                                    <li><strong>Address/Contact:</strong> {{(App\Helpers\Helper::IDwiseData('delivery_locations','id', $master->delivery_location_id))->address}}; {{(App\Helpers\Helper::IDwiseData('delivery_location_details','id', $master->delivery_location_detail_id))->contact_person_info}}</li>
                                                    <li><strong>Delivery Date:</strong> {{\Carbon\Carbon::parse($master->delivery_date)->format('j-M-Y')}}</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6 text-left">
                                                <ul class="list-unstyled text-default lt mb-20">
                                                    <li><strong>Buyer:</strong>  {{(App\Helpers\Helper::IDwiseData('buyers','id', $master->buyer_id))->name}}</li>
                                                    <li><strong>Style:</strong> {{$master->style}}</li>
                                                    <li><strong>Buyer PO No:</strong> {{$master->buyer_po_no}}</li>
                                                    <li><strong>Garments Qty:</strong> {!! number_format($master->garments_quantity, 0, '.', ',') !!} Pcs</li>
                                                    <li><strong>Consumption PCS/ INCH/ DZ:</strong> {{$master->consumption_per_dz}}</li>
                                                </ul>
                                            </div>
                                            <!-- /col -->
                                        </div>

                                    </div>
                                    <!-- /tile body -->
                                </section>
                                <!-- /tile -->
                                <!-- tile -->
                                <section class="tile tile-simple">
                                    <!-- tile body -->
                                    <div class="tile-body p-0">
{{--                                        <p class="mb-0 text-strong text-center text-uppercase" style="font-size: medium !important;">&nbsp;&nbsp;Elastic Booking</p>--}}
                                    @foreach($uniqueProducts as $uproduct)
                                        <div class="table-responsive">
                                            <table class="table table-hover table-condensed" id="items">
                                                <thead>
                                                    <tr style="height: 3px !important;">
                                                        {{--                                                        <th class="text-uppercase text-center" style="font-size: xx-small !important;">Sl#</th>--}}
                                                        <th class="text-uppercase text-center" style=" font-size: xx-small !important;">Article No</th>
                                                        <th class="text-uppercase text-center" style="font-size: xx-small !important;">Order Qty</th>
                                                        <th class="text-uppercase text-center" style="font-size: xx-small !important;">Unit</th>
                                                        <th class="text-uppercase text-center" style="font-size: xx-small !important;">Unit Price</th>
                                                        <th class="text-uppercase text-center" style="font-size: xx-small !important;">Total Price</th>
                                                        <th class="text-uppercase text-center" style="font-size: xx-small !important;">Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                {{--                                                @php($i = 1)--}}
                                                <h5 class="text-left"><strong>{{$uproduct->name}}</strong></h5>
                                                @foreach($details as $item)
                                                    @if($item->interlining_product_setup_id == $uproduct->id)
                                                        <tr style="height: 1px !important;">
                                                            {{--                                                        <td class="text-center" style="font-size: small !important;"><P>{!! $i++ !!}</P></td>--}}
                                                            <td style="font-size: small !important;"><p>{{ (App\Helpers\Helper::IDwiseData('interlining_product_price_setups','id',$item->article_id))->article_no }}</p></td>
                                                            <td style="font-size: small !important;" class="text-right"><P>{!! number_format($item->order_quantity, 0, '.', ',') !!}</P></td>
                                                            <td style="font-size: small !important;" class="text-right"><p>{!! (\App\Helpers\Helper::IDwiseData('units', 'id', $item->input_unit_id))->short_unit !!}</p></td>
                                                            <td style="font-size: small !important;" class="text-right"><P>{{$item->currency}} {!! number_format($item->unit_price  , 3, '.', ',') !!}</P></td>
                                                            <td style="font-size: small !important;" class="text-right"><P>{{$item->currency}} {!!  number_format($item->total_price, 3, '.', ',') !!}</P></td>
                                                            <td style="font-size: xx-small !important;" class="text-right"><P>{!! $item->remarks !!}</P></td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @endforeach
                                        <div class="table-responsive">
                                            <table class="table table-hover table-condensed" id="items">
                                                <tfoot>
                                                <tr style="height: 3px !important;">
                                                    <td colspan="2" style="font-size: small !important;" class="text-right"><p><b>Total:</b></p></td>
                                                    <td colspan="1" style="font-size: x-small !important;" class="text-right">
                                                        <P>
                                                            <b>
                                                                {!! number_format($order_quantity, 0, '.', ',') !!}
                                                            </b>
                                                        </P>
                                                    </td>
                                                    <td colspan="2" style="font-size: x-small !important;" class="text-right">
                                                        <P>
                                                            <b>
                                                                @if(!empty($uniqueProducts) {{$uniqueProducts[0]->currency}} @endif{!! number_format($total_price, 3, '.', ',') !!}
                                                            </b>
                                                        </P>
                                                    </td>
                                                    <td style="font-size: x-small !important;" class="text-right">

                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /tile body -->
                                </section>
                                <!-- /tile -->
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <!-- col -->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <!-- tile -->
                                <section class="tile tile-simple bg-tr-black lter">
                                    <div class="tile-body">
                                        <!-- row -->
                                        <div class="row">
                                            <!-- col -->
                                            <div class="col-md-6 text-left no-padding">
                                                <p class="text-strong mb-40 custom-font text-black-50">
                                                    <b class="text-uppercase" style="font-size: medium">&nbsp; Remarks</b><br>
                                                    &nbsp; {!! $master->remarks !!}
                                                    <br>
                                                    <br>
                                                    <b class="text-uppercase" style="font-size: medium">&nbsp; NOTE</b><br>
                                                    &nbsp; 1.  Copy of this order should be enclosed with challan on delivery.<br>
                                                    &nbsp; 2.  P/Invoice must be supported by original Challan and P.O.
                                                </p>
                                            </div>
                                            <div class="col-md-6 text-right no-padding">
                                                <p class="text-strong mb-40 custom-font">
                                                    @if($master->is_urgent)
                                                        <b class="text-uppercase text-danger" style="font-size: medium">&nbsp; Urgent</b><br>
                                                    @endif
                                                        @if($master->is_revised)
                                                            <b class="text-uppercase text-danger" style="font-size: medium">&nbsp; Revised</b><br>
                                                            <strong>Revise Date:</strong> {{\Carbon\Carbon::parse($master->last_revise_date)->format('j-M-Y')}}
                                                        @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- tile body -->

                                </section>
                                <!-- /tile -->
                            </div>
                            <!-- /col -->
                        </div>
                        <!-- /row -->
                        <!-- row -->
                        <div class="row">
                            <!-- col -->
                            <div class="col-md-12">
                                <!-- tile -->
                                <section class="tile tile-simple bg-tr-black lter">
                                    <!-- tile body -->
                                    <div class="tile-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-condensed">
                                                <tfoot>
                                                <tr>
                                                    <td class="text-center" style="font-size: small !important;">
                                                        <hr>
                                                        <P><strong>ORDERED BY</strong></P>
                                                    </td>
                                                    <td class="text-center" style="font-size: small !important;">
                                                        <hr>
                                                        <P><strong>DEPT. HEAD APPROVAL</strong></P>
                                                    </td>
                                                    <td class="text-center" style="font-size: small !important;">
                                                        <hr>
                                                        <P><strong>MERCHANDISER APPROVAL</strong></P>
                                                    </td>
                                                    {{--<td class="text-center" style="font-size: small !important;">
                                                        <hr>
                                                        <P><strong>Authorized Signature</strong></P>
                                                    </td>--}}
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                    </div>
                                    <!-- /tile body -->
                                    <div class="tile-footer">
                                        <p class="text-right" style="font-size: xx-small !important;">Order Generated From <strong>"Smart Cal"</strong>-Date:{{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                                    </div>
                                </section>
                                <!-- /tile -->
                            </div>
                            <!-- /col -->
                        </div>

                        <!-- /row -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /row -->

    </div>
@endsection


@section('pageVendorScripts')

@endsection
@section('pageScripts')
    {{--    <script src="{{ asset('back-end/assets/MyJS/jquery.min.js') }}"></script>--}}

    <script>
        $(window).load(function(){

        });

        function refresh()
        {
            window.location.href = window.location.href.replace(/#.*$/, '');
        }

        function iconChange() {

            $('#iconChange').find('i').addClass('fa-edit');

        }


    </script>
@endsection()




