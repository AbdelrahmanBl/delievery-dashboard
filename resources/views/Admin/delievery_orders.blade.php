<!doctype html>
<html lang="en">

<head>
<title>TATX | Orders</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="TATX">
<meta name="keywords" content="TATX">
<meta name="author" content="International Applications">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../assets/vendor/animate-css/vivify.min.css">

<link rel="stylesheet" href="../assets/vendor/c3/c3.min.css"/>
<link rel="stylesheet" href="../assets/vendor/chartist/css/chartist.min.css">
<link rel="stylesheet" href="../assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">
<link rel="stylesheet" href="../assets/vendor/jvectormap/jquery-jvectormap-2.0.3.css">

<!-- MAIN CSS -->
<link rel="stylesheet" href="../assets/css/site.min.css">

</head>
<body class="theme-cyan font-montserrat light_version">
@include('layouts/Admin/loadingAndLighting')       
<div id="wrapper">
    @include('layouts/Admin/topNav')
    <div id="left-sidebar" class="sidebar">
         @include('layouts/Admin/logo')
        <div class="sidebar-scroll">
            @include('layouts/Admin/info') 
            @include('layouts/Admin/nav')   
        </div>
    </div>

    <div id="main-content">
            <div class="block-header">
                    <div class="row clearfix">
                        <div class="col-md-6 col-sm-12">
                            <h1>Dashboard</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">TATX</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Orders</li>
                                </ol>
                            </nav>
                        </div>            
                       
                    </div>
                </div> 
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                            <ul class="nav nav-tabs3 table-nav">
                                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Current">Current <span class="badge">{{$Current_count}}</span></a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Completed">Completed <span class="badge">{{$Completed_count}}</span></a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Canceled">Canceled <span class="badge">{{$Canceled_count}}</span></a></li> 
                                                 
                                </ul>
                    <div class="tab-content">
                        <!-- Start Content -->
                        <div class="table-responsive tab-pane show active"  id="Current">
                            <table class="table table-hover js-basic-example dataTable table-custom spacing5 mb-0">
                                <thead>
                                    <tr>    
                                        <th>Booking Id</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    @if(isset($Orders))
                                    @foreach( $Orders as $Order )
                                    @if($Order->status == 'SEARCHING' || $Order->status == 'ACCEPTED' || $Order->status == 'STARTED')
                                    <tr>
                                            <td><span>{{$Order->booking_id}}</span></td>
                                        <td>{{explode(' ',$Order->created_at)[0]}}</td>
                                        <td>{{$Order->status}}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-default " onclick="Details('{{$Order->id}}')" id="detailsBtn{{$Order->id}}" title="Print"><i class="icon-wallet"></i></button>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive tab-pane show"  id="Completed">
                            <table class="table table-hover js-basic-example dataTable table-custom spacing5 mb-0">
                                <thead>
                                    <tr>
                                        
                                        <th>Booking Id</th>
                                        <th>Provider</th>
                                        <th>User</th>
                                        <th>Date</th>
                                        <th>Payment Mode</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($Orders))
                                    @foreach( $Orders as $Order )
                                    @if($Order->status == 'COMPLETED')
                                    <tr>
                                            <td><span>{{$Order->booking_id}}</span></td>
                                            <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avtar-pic w35 bg-red" data-toggle="tooltip" data-placement="top" title="{{$Order->provider_first_name}}"><span>{{substr($Order->provider_first_name, 0, 1)}}</span></div>
                                                        <div class="ml-3">
                                                            <p class="mb-0">{{$Order->provider_first_name}} {{$Order->provider_last_name}}</p>
                                                            <p class="mb-0">966 {{$Order->provider_mobile}}</p>
                                                        </div>
                                                    </div>                                        
                                                </td>
                                        
                                        <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avtar-pic w35 bg-red" data-toggle="tooltip" data-placement="top" title="{{$Order->user_first_name}}"><span>{{substr($Order->user_first_name, 0, 1)}}</span></div>
                                                    <div class="ml-3">
                                                        <p class="mb-0">{{$Order->user_first_name}} {{$Order->user_last_name}}</p>
                                                        <p class="mb-0">966 {{$Order->user_mobile}}</p>
                                                    </div>
                                                </div>                                        
                                            </td>
                                        <td>{{explode(' ',$Order->created_at)[0]}}</td>
                                        <td><a href="Javascript:void(0)" onclick="showInvoice({{$Order->booking_id}})">{{$Order->payment_mode}}</a></td>
                                        <td>{{$Order->total}} SAR</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive tab-pane show"  id="Canceled">
                            <table class="table table-hover js-basic-example dataTable table-custom spacing5 mb-0">
                                <thead>
                                    <tr>
                                        
                                        <th>Booking Id</th>
                                        <th>Provider</th>
                                        <th>User</th>
                                        <th>Date</th>
                                        <th>Cancelled By</th>
                                        <th>Cancel Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($Orders))
                                    @foreach( $Orders as $Order )
                                    @if($Order->status == 'CANCELLED')
                                    <tr>
                                            <td><span>{{$Order->booking_id}}</span></td>
                                            <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avtar-pic w35 bg-red" data-toggle="tooltip" data-placement="top" title="{{$Order->provider_first_name}}"><span>{{substr($Order->provider_first_name, 0, 1)}}</span></div>
                                                        <div class="ml-3">
                                                            <p class="mb-0">{{$Order->provider_first_name}} {{$Order->provider_last_name}}</p>
                                                            <p class="mb-0">966 {{$Order->provider_mobile}}</p>
                                                        </div>
                                                    </div>                                        
                                                </td>
                                        
                                        <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avtar-pic w35 bg-red" data-toggle="tooltip" data-placement="top" title="{{$Order->user_first_name}}"><span>{{substr($Order->user_first_name, 0, 1)}}</span></div>
                                                    <div class="ml-3">
                                                        <p class="mb-0">{{$Order->user_first_name}} {{$Order->user_last_name}}</p>
                                                        <p class="mb-0">966 {{$Order->user_mobile}}</p>
                                                    </div>
                                                </div>                                        
                                            </td>
                                        <td>{{explode(' ',$Order->created_at)[0]}}</td>
                                        <td>{{$Order->cancelled_by}}</td>
                                        <td>{{$Order->cancel_reason}}</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    <!-- End Content -->
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<button style="display: none" data-toggle="modal" id="showDetails" data-target=".bd-example-modal-lg"></button>
<!-- Large modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="table-responsive-xl">
  <table class="table">
    <tbody>
        <tr>
          <th>Booking ID</th>
            <td id="booking_id"></td>
        </tr>
        <tr>
          <th>From</th>
            <td id="d_address"></td>
        </tr>
        <tr>
          <th>To</th>
            <td id="s_address"></td>
        </tr>
        <th>Seller</th>
            <td id="seller"></td>
        </tr>
        <th>Status</th>
            <td id="status"></td>
        </tr>
        <th>Time</th>
            <td id="created_at"></td>
        </tr>
        <th>Products</th>
        <tr id="products"></tr>
        </tr>
    </tbody>
</table>
</div>
    </div>
  </div>
</div>
<!-- Javascript -->
<script src="../assets/bundles/libscripts.bundle.js"></script>
<script src="../assets/bundles/vendorscripts.bundle.js"></script>

<script src="../assets/bundles/c3.bundle.js"></script>
<script src="../assets/bundles/flotscripts.bundle.js"></script>
<script src="../assets/bundles/jvectormap.bundle.js"></script>
<script src="../assets/vendor/jvectormap/jquery-jvectormap-us-aea-en.js"></script>

<script src="../assets/bundles/mainscripts.bundle.js"></script>
<script src="../assets/js/hrdashboard.js"></script>
<script>
    function Details(order_id){
    $('#detailsBtn'+order_id).prop('disabled', true);
    $("#showDetails").click()
    $.ajax({
            type: "POST",
            dataType: "json",
            url: "/loadOrderDetails", 
            data: {_token:"{{csrf_token()}}", order_id:order_id }
        }).done(function(data){ 
            if(data['status'] == 0){
                $('#booking_id').html(data['result']['booking_id'])
                $('#d_address').html(data['result']['d_address'])
                $('#s_address').html(data['result']['s_address'])
                $('#seller').html(data['result']['seller'])
                $('#status').html(data['result']['status'])
                $('#created_at').html(data['result']['created_at'])
                var products = data['result']['products'];
                $('#products').empty()
                for(var i = 0 ; i < products.length ; i++){
                    var image ;
                    (products[i]['image'] == null)? image = 'https://scontent.fcai3-1.fna.fbcdn.net/v/t1.15752-0/p280x280/98030129_2315653102069707_6395699993054806016_n.png?_nc_cat=104&_nc_sid=b96e70&_nc_ohc=pQgLtC91R7wAX9TDiFA&_nc_ht=scontent.fcai3-1.fna&oh=06d613b010103c36af0dae6b1c8480db&oe=5EE86037' : image = products[i]['image']

                    var a = "<br> <td><img style='max-width: 147px; min-width: 147px; max-height: 147px; min-height: 147px;' src='"+image+"' ></td> <td>"+products[i]['name']+"</td> || <td>"+products[i]['qty']+"</td> || <td>"+products[i]['category']+"</td>";
                    $('#products').append(a)
                }
                $("#showDetails").click()
            }else{
                alert(data['error'])
            }
            $('#detailsBtn'+order_id).prop('disabled', false);
        });
}
</script>
</body>
</html>
