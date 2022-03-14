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
            <h2>Poly <span>// Detail</span></h2>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{route('home')}}"><i class="fa fa-home"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#"> Poly</a>
                    </li>
                    <li>
                        <a href="{{route('poly.product')}}"> Product Setup</a>
                    </li>
                    <li>
                        <a href="{{route('poly.product.detail', ['id' => $product->id])}}"> {{$product->name}}</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- page content -->
        <div class="pagecontent">
            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="col-md-2">
                    <!-- tile -->
                    <section id="purchase-order" class="tile tile-simple">
                        <!-- tile widget -->
                        <div class="tile-widget p-30 text-center">
                            <h5 class="mb-0"><strong>{{$product->name}}</strong></h5>
                            {{--                            <span class="text-muted">{{$unit->short_unit}}</span>--}}
                        </div>
                    </section>
                    <!-- /tile -->
                </div>
                <!-- /col -->
                <!-- col -->
                <div class="col-md-10">
                    <!-- tile -->
                    <section class="tile tile-simple">
                        <!-- tile body -->
                        <div class="tile-body p-0">
                            <div role="tabpanel">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs tabs-dark" role="tablist">
                                    <li role="presentation" class="active"><a href="#itemList" aria-controls="itemList" role="tab" data-toggle="tab">Price Setup</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="itemList">
                                        <div class="wrap-reset">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                                                    <form method="post" id="ItemAdd" name="ItemAddForm" enctype="multipart/form-data">
                                                        {{ csrf_field() }}
                                                        <section class="tile">
                                                            <!-- tile header -->
                                                            <div class="tile-header dvd dvd-btm">
                                                                <h1 class="custom-font"><strong>Price Setup</strong> Insert/Update Form</h1>
                                                                <a><button id="iconChange" class="pull-right btn-info btn-xs" type="submit"><i class="fa fa-check"></i></button></a>
                                                            </div>
                                                            <!-- /tile header -->
                                                            <!-- tile body -->
                                                            <div class="tile-body">
                                                                <div class="row" style="padding: 0px 15px;">
                                                                    <input type="hidden" id="PSetupID" name="poly_product_setup_id" value="{{old('poly_product_setup_id', $product->id)}}">
                                                                    <div class="col-md-4 no-padding">
                                                                        <div class="form-group">
                                                                            <label for="RoleID" class="control-label">Supplier Name</label>
                                                                            <select class="form-control select2" name="supplier"  id="RoleID" style="width: 100%;" required>
                                                                                <option value="" selected="selected">- - - Select - - -</option>
                                                                                @if(!empty($supplierByGroup))
                                                                                    @foreach($supplierByGroup as $type)
                                                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 no-padding">
                                                                        <div class="form-group">
                                                                            <label for="UnitID" class="control-label">Price Unit</label>
                                                                            <select class="form-control select2" name="price_unit"  id="UnitID" style="width: 100%;" required>
                                                                                <option value="" selected="selected">- - - Select - - -</option>
                                                                                <option value="DZN" >DZN</option>
                                                                                <option value="LBS" >LBS</option>
                                                                                <option value="PCS" >PCS</option>
                                                                                <option value="LBS" >LBS</option>
                                                                                <option value="SQ INCH" >SQ INCH</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 no-padding">
                                                                        <div class="form-group">
                                                                            <label for="CurrencyID" class="control-label">Approved Currency</label>
                                                                            <select class="form-control select2" name="currency"  id="CurrencyID" style="width: 100%;" required>
                                                                                <option value="" selected="selected">- - - Select - - -</option>
                                                                                <option value="৳" >BDT</option>
                                                                                <option value="$" >USD</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row" style="padding: 0px 15px;">
                                                                    <div class="col-md-3 no-padding">
                                                                        <div class="form-group">
                                                                            <label for="FUSD" class="control-label">First USD Conv. Value</label>
                                                                            <input type="number" step="any" class="form-control" name="first_usd_conversion_value" id="FUSD">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 no-padding">
                                                                        <div class="form-group">
                                                                            <label for="SUSD" class="control-label">Second USD Conv. Value</label>
                                                                            <input type="number" step="any" class="form-control" name="second_usd_conversion_value" id="SUSD">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 no-padding">
                                                                        <div class="form-group">
                                                                            <label for="UPrice" class="control-label">Unit Price</label>
                                                                            <input type="number" step="any" class="form-control" name="unit_price" id="UPrice" required="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 no-padding">
                                                                        <div class="form-group">
                                                                            <label for="APrice" class="control-label">Adhesive Price</label>
                                                                            <input type="number" step="any" class="form-control" name="adhesive_price" id="APrice">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 no-padding">
                                                                        <div class="form-group">
                                                                            <label for="PPrice" class="control-label">Printing Price</label>
                                                                            <input type="number" step="any" class="form-control" name="printing_price" id="PPrice">
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
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                                                    <section class="tile">
                                                        <!-- tile header -->
                                                        <div class="tile-header dvd dvd-btm">
                                                            <h1 class="custom-font"><strong>Supplier Wise</strong> Price List</h1>
                                                        </div>
                                                        <!-- /tile header -->
                                                        <!-- tile body -->
                                                        <div class="tile-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover table-bordered table-condensed table-responsive" id="advanced-usage">
                                                                    <thead>
                                                                    <tr style="background-color: #1693A5; color: white;">
                                                                        <th class="text-center">Sl No.</th>
                                                                        <th class="text-center">Supplier Name</th>
                                                                        <th class="text-center">First USD Conv. Value</th>
                                                                        <th class="text-center">Second USD Conv. Value</th>
                                                                        <th class="text-center">Price Unit</th>
                                                                        <th class="text-center">Unit Price</th>
                                                                        <th class="text-center">Adhesive Price</th>
                                                                        <th class="text-center">Printing Price</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @php($i = 1)
                                                                    @foreach($productPriceSetups as $item)
                                                                        <tr>
                                                                            <td class="text-center">{{$i++}}</td>
                                                                            <td class="text-left">{{(App\Helpers\Helper::IDwiseData('suppliers','id',$item->supplier_id))->name}}</td>
                                                                            <td class="text-center">{{$item->first_usd_conversion_value}}</td>
                                                                            <td class="text-center">{{$item->second_usd_conversion_value}}</td>
                                                                            <td class="text-center">{{$item->price_unit}}</td>
                                                                            <td class="text-right">{{$item->currency}} {{$item->unit_price}}</td>
                                                                            <td class="text-right">{{$item->currency}} {{$item->adhesive_price}}</td>
                                                                            <td class="text-right">{{$item->currency}} {{$item->printing_price}}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <!-- /tile body -->
                                                        </div>
                                                    </section>
                                                    <!-- /tile -->
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

@section('page-modals')

@endsection

@section('pageScripts')
    <script>
        $(window).load(function(){
            $('#advanced-usage').DataTable({
                "lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]]
            });

            $('.select2').select2();
            //sessionStorage.clear();
        });

        function refresh()
        {
            window.location.href = window.location.href.replace(/#.*$/, '');
        }

        function iconChange() {

            $('#iconChange').find('i').addClass('fa-edit');

        }

        $(function(){
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
            });
            $('#ItemAdd').submit(function(e){
                e.preventDefault();
                var data = $(this).serialize();
                //console.log(data);
                //return;

                var id = $('#ConvID').val();
                //var masterId = $('#MasterID').val();
                //console.log(masterId);
                //return;
                var url = '{{ route('poly.product.save-price-setup') }}';
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




    </script>
@endsection()


