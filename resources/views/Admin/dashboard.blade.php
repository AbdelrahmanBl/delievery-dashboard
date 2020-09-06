<!doctype html>
<html lang="en">

<head>
<title>TATX | Home</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="TATX">
<meta name="keywords" content="TATX">
<meta name="author" content="International Applications">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/animate-css/vivify.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/vendor/c3/c3.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets/vendor/chartist/css/chartist.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/jvectormap/jquery-jvectormap-2.0.3.css') }}">

<!-- MAIN CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/site.min.css') }}">

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
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-md-6 col-sm-12">
                        <h1>Dashboard</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">TATX</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </nav>
                    </div>            
                   
                </div>
            </div>
            <div class="row clearfix">
                    <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="body">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-in-bg bg-azura text-white rounded-circle"><i class="fa fa-credit-card"></i></div>
                                        <div class="ml-4">
                                            <span>Current Orders</span>
                                            <h4 class="mb-0 font-weight-medium">{{ $CurrentOrders }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="body">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-in-bg bg-azura text-white rounded-circle"><i class="fa fa-credit-card"></i></div>
                                            <div class="ml-4">
                                                <span>Online Users</span>
                                                <h4 class="mb-0 font-weight-medium">{{ $Online_Users }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="body">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-in-bg bg-azura text-white rounded-circle"><i class="fa fa-credit-card"></i></div>
                                                <div class="ml-4">
                                                    <span>Online Providers</span>
                                                    <h4 class="mb-0 font-weight-medium">{{ $Online_Providers }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                        <div class="card">
                                            <div class="body">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-in-bg bg-azura text-white rounded-circle"><i class="fa fa-credit-card"></i></div>
                                                    <div class="ml-4">
                                                        <span>Total Income</span>
                                                        <h4 class="mb-0 font-weight-medium">${{ $Total_Income }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                            <div class="card">
                                                <div class="body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-in-bg bg-azura text-white rounded-circle"><i class="fa fa-credit-card"></i></div>
                                                        <div class="ml-4">
                                                            <span>Completed Orders</span>
                                                            <h4 class="mb-0 font-weight-medium">{{ $Completed_Orders }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                                <div class="card">
                                                    <div class="body">
                                                        <div class="d-flex align-items-center">
                                                            <div class="icon-in-bg bg-azura text-white rounded-circle"><i class="fa fa-credit-card"></i></div>
                                                            <div class="ml-4">
                                                                <span>Best Price Orders</span>
                                                                <h4 class="mb-0 font-weight-medium">{{ $Best_Price_Orders }}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                    <div class="card">
                                                        <div class="body">
                                                            <div class="d-flex align-items-center">
                                                                <div class="icon-in-bg bg-azura text-white rounded-circle"><i class="fa fa-credit-card"></i></div>
                                                                <div class="ml-4">
                                                                    <span>Canceled Orders</span>
                                                                    <h4 class="mb-0 font-weight-medium">{{ $Canceled_Orders }}</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                        <div class="card">
                                                            <div class="body">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="icon-in-bg bg-azura text-white rounded-circle"><i class="fa fa-credit-card"></i></div>
                                                                    <div class="ml-4">
                                                                        <span>Scheduled Orders</span>
                                                                        <h4 class="mb-0 font-weight-medium">{{ $Scheduled_Orders }}</h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                   
                                                        
                                                            
                                                                
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2>Recent Orders</h2>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover js-basic-example dataTable table-custom spacing5 mb-0">
                                <thead>
                                    <tr>
                                        
                                        <th>Booking Id</th>
                                        <th>Provider</th>
                                        <th>User</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($Orders))
                                    @foreach( $Orders as $Order )
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
                                        <td>{{$Order->status}}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<!-- Javascript -->
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>

<script src="{{ asset('assets/bundles/c3.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/flotscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/jvectormap.bundle.js') }}"></script>
<script src="{{ asset('assets/vendor/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>

<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/hrdashboard.js') }}"></script>
</body>
</html>
