@extends('layouts.admin.admin-master')

@section('title')
QC Sticker
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
            <h2>QC Sticker <span> Booking Report</span></h2>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{route('home')}}"><i class="fa fa-home"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#"> QC Sticker</a>
                    </li>
                    <li>
                        <a href="{{route('qcsticker.booking.report')}}"> Booking Report</a>
                    </li>
                    <li>
                        <a class="active" href="#">Print View</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- row -->
        <div class="add-nav">
            <div class="nav-heading">
                <h3>QC Sticker : <strong class="text-greensea">Booking Report</strong></h3>
                <span class="controls pull-right">
                    <a href="{{route('qcsticker.booking.report')}}" class="btn btn-ef btn-ef-1 btn-ef-1-default btn-ef-1a btn-rounded-20 mr-5" data-toggle="tooltip" title="Back"><i class="fa fa-times"></i></a>
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
                                                <p class="mb-0 text-strong text-uppercase" style="font-size: x-large !important;">&nbsp;&nbsp;Booking Report</p>
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
                                        <div class="row b-t pt-20">
                                            <!-- col -->
                                            <div class="col-md-6 text-left">
                                                <ul class="list-unstyled text-default lt mb-20">
                                                    <li style="font-size: medium;"><strong>Booking Report:</strong> QC Sticker</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <ul class="list-unstyled text-default lt mb-20">
                                                    @if(!empty($request->from_date))
                                                        <li><strong>From Date:</strong>  {{\Carbon\Carbon::parse($request->from_date)->format('d/m/Y')}}</li>
                                                    @else
                                                        <li><strong>From Date:</strong>  {{\Carbon\Carbon::parse(\Carbon\Carbon::now()->addYear(-30))->format('d/m/Y')}}</li>
                                                    @endif
                                                        @if(!empty($request->to_date))
                                                            <li><strong>To Date:</strong>  {{\Carbon\Carbon::parse($request->to_date)->format('d/m/Y')}}</li>
                                                        @else
                                                            <li><strong>To Date:</strong>  {{\Carbon\Carbon::parse(\Carbon\Carbon::today())->format('d/m/Y')}}</li>
                                                        @endif
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
                                        <div {{--class="table-responsive"--}}>
                                            <table class="table table-hover table-condense table-success" id="items">
                                                <thead>
                                                    <tr style="height: 3px !important;">
                                                        <th class="text-uppercase text-center" style=" font-size: small !important;">Sl No.</th>
                                                        <th class="text-uppercase text-center" style=" font-size: small !important;">LPD PO NO</th>
                                                        <th class="text-uppercase text-center" style=" font-size: small !important;">PO Date</th>
                                                        <th class="text-uppercase text-center" style=" font-size: small !important;">Supplier</th>
                                                        <th class="text-uppercase text-center" style=" font-size: small !important;">Buyer</th>
                                                        <th class="text-uppercase text-center" style=" font-size: small !important;">Delivery Location</th>
                                                        <th class="text-uppercase text-center" style=" font-size: small !important;">Delivery Date</th>
                                                        <th class="text-uppercase text-center" style=" font-size: small !important;">TNA Start Date</th>
                                                        <th class="text-uppercase text-center" style=" font-size: small !important;">TNA End Date</th>
                                                        <th class="text-uppercase text-center" style=" font-size: small !important;">Delivery Complete Date</th>
                                                        <th class="text-uppercase text-center" style=" font-size: small !important;">Status</th>
                                                        <th class="text-uppercase text-center" style=" font-size: small !important;">Total Value</th>
                                                        <th class="text-uppercase text-center" style=" font-size: small !important;">Remarks</th></tr>
                                                </thead>

                                                <tbody>
                                                @php($i = 1)
                                                @foreach($purchaseOrders as $item)
                                                    <tr>
                                                        <td class="text-center" style=" font-size: x-small !important;">{{$i++}}</td>
                                                        <td class="text-center" style=" font-size: x-small !important;">{{$item->lpd_po_no}}</td>
                                                        <td class="text-center" style=" font-size: x-small !important;"> {{\Carbon\Carbon::parse($item->lpd_po_date)->format('d/m/Y')}}</td>
                                                        <td class="text-left" style=" font-size: x-small !important;">{{(App\Helpers\Helper::IDwiseData('suppliers','id',$item->supplier_id))->name}}</td>
                                                        <td class="text-left" style=" font-size: x-small !important;">{{(App\Helpers\Helper::IDwiseData('buyers','id',$item->buyer_id))->name}}</td>
                                                        <td class="text-left" style=" font-size: x-small !important;">{{(App\Helpers\Helper::IDwiseData('delivery_locations','id',$item->delivery_location_id))->name}}</td>
                                                        <td class="text-center" style=" font-size: x-small !important;"> {{\Carbon\Carbon::parse($item->delivery_date)->format('d/m/Y')}}</td>
                                                        <td class="text-center" style=" font-size: x-small !important;">
                                                            @if($item->tna_start_date != null)
                                                                {{ \Carbon\Carbon::parse($item->tna_start_date)->format('d/m/Y') }}
                                                            @endif
                                                        </td>
                                                        <td class="text-center" style=" font-size: x-small !important;">
                                                            @if($item->tna_end_date != null)
                                                                {{ \Carbon\Carbon::parse($item->tna_end_date)->format('d/m/Y') }}
                                                            @endif
                                                        </td>
                                                        <td class="text-center" style=" font-size: x-small !important;">
                                                            @if($item->delivery_complete_date != null)
                                                                {{ \Carbon\Carbon::parse($item->delivery_complete_date)->format('d/m/Y') }}
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($item->status == 'I')
                                                                <span class="label label-info">Waiting for approval</span>
                                                            @elseif($item->status == 'A')
                                                                <span class="label label-success">Active</span>
                                                            @elseif($item->status == 'B')
                                                                <span class="label label-danger">Blocked</span>
                                                            @elseif($item->status == 'IN')
                                                                <span class="label label-warning">In-Active</span>
                                                            @elseif($item->status == 'DC')
                                                                <span class="label label-info">Delivery Complete</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-right">
                                                            <strong style="float: left;">$</strong>{!! number_format((App\Model\QCStickerPODetail::getSumTotalPrice($item->id)), 3, '.', ',') !!}
                                                        </td>
                                                        <td class="text-right">

                                                        </td>
                                                @endforeach
                                                </tbody>
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
                            <div class="col-md-12">
                                <!-- tile -->
                                <section class="tile tile-simple bg-tr-black lter">
                                   {{-- <!-- tile body -->
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
                                                    --}}{{--<td class="text-center" style="font-size: small !important;">
                                                        <hr>
                                                        <P><strong>Authorized Signature</strong></P>
                                                    </td>--}}{{--
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                    </div>
                                    <!-- /tile body -->--}}
                                    <div class="tile-footer">
                                        <p class="text-right" style="font-size: xx-small !important;">Report Generated From <strong>"Smart Cal"</strong>-Date:{{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
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




