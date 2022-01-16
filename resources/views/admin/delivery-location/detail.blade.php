@extends('layouts.admin.admin-master')

@section('title')
    Delivery Location
@endsection
@section('content')
    <style type="text/css">
        th{
            background-color: #0689bd;
            color: white;
        }
        .tile-body{
            background-color: white;
        }
        .tile-header{
            color: white;
        }
        .tile-header{
            background-color:#105e7d;
        }
    </style>
    <div class="page page-profile">
        <div class="pageheader">
            <h2>Unit <span>// Detail</span></h2>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{route('home')}}"><i class="fa fa-home"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#"> Administration</a>
                    </li>
                    <li>
                        <a href="{{route('admin.delivery-location')}}"> Delivery Locations</a>
                    </li>
                    <li>
                        <a href="{{route('admin.delivery-location.detail', ['id' => $master->id])}}"> {{$master->name}}</a>
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
                            <h4 class="mb-0"><strong>{{$master->name}}</strong></h4>
                            <span class="text-muted">{{$master->address}}</span>
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
                                    <li role="presentation" class="active"><a href="#itemList" aria-controls="itemList" role="tab" data-toggle="tab">Detail Setup</a></li>
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
                                                                <h1 class="custom-font"><strong>Detail Setup</strong> Entry Form</h1>
                                                                <a><button id="iconChange" class="pull-right btn-info btn-xs" type="submit"><i class="fa fa-check"></i></button></a>
                                                            </div>
                                                            <!-- /tile header -->
                                                            <!-- tile body -->
                                                            <div class="tile-body">
                                                                <div class="row" style="padding: 0px 15px;">
                                                                    <div class="col-md-1 no-padding">
                                                                        <div class="form-group">
                                                                            <input type="hidden" id="ID" name="id" value="">
                                                                            <input type="hidden" id="DeliveryLocationID" name="delivery_location_id" value="{{old('delivery_location_id', $master->id)}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-10 no-padding">
                                                                        <div class="form-group">
                                                                            <label for="CPInfo" class="control-label">Contact Person Info</label>
                                                                            <input type="text" size="3" class="form-control" name="contact_person_info" id="CPInfo" placeholder="Enter contact person info" required="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1 no-padding"></div>
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
                                                                <h1 class="custom-font"><strong>Contact Person</strong> List</h1>
                                                                </div>
                                                            <!-- /tile header -->
                                                            <!-- tile body -->
                                                            <div class="tile-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-hover table-bordered table-condensed table-responsive" id="advanced-usage">
                                                                        <thead>
                                                                        <tr style="background-color: #1693A5; color: white;">
                                                                            <th class="text-center">Sl No.</th>
                                                                            <th class="text-center">Contact Person</th>
                                                                            <th class="text-center">Action</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @php($i = 1)
                                                                            @foreach($details as $item)
                                                                                <tr>
                                                                                    <td class="text-center">{{$i++}}</td>
                                                                                    <td class="text-left">{{$item->contact_person_info}}</td>
                                                                                    <td class="text-center">
                                                                                        <a onclick="iconChange()" data-id = "{{ $item->id }}" class="EditFactory btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
{{--                                                                                        <a title="Delete" class="DeleteDetail btn btn-danger btn-xs" data-id = "{{ $item->id }}"><i class="fa fa-trash"></i></a>--}}
                                                                                    </td>
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
                var url = '{{ route('admin.save-delivery-location-detail') }}';
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

        $('#advanced-usage').on('click',".EditFactory", function(){
            var button = $(this);
            var FactoryID = button.attr("data-id");
            //$('body').animate({scrollTop:0}, 400);
            //console.log(FactoryID);
            //return;
            window.scrollTo({
                top: 0,
                left: 0,
                behavior: 'smooth'
            });
            var url = '{{ route('admin.edit-delivery-location-detail') }}';
            $.ajax({
                url: url,
                method:'POST',
                data:{id: FactoryID},
                success:function(data){
                    //console.log(data);
                    //return;
                    // $("#RoleID option[value = '" + data.to_unit_id + "']").attr('selected', 'selected').change();
                    //$("#TrimsTypeID option[value = '" + data.trims_type_id + "']").attr('selected', 'selected').change();

                    //$('input[name=gross_calculation_amount]').val(data.gross_calculation_amount);
                    $('input[name=contact_person_info]').val(data.contact_person_info);
                    //console.log();

                    $('input[name=id]').val(data.id);
                },
                error:function(error){
                    swal({
                        title: "No Data Found!",
                        text: "no data!",
                        icon: "error",
                        button: "Ok!",
                        className: "myClass",
                    });
                }
            })

        });


    </script>
@endsection()


