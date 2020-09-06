<!doctype html>
<html lang="en">

<head>
<title>TATX | Providers</title>
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
        <div class="container-fluid">
            <div class="block-header">
                    <div class="block-header">
                            <div class="row clearfix">
                                <div class="col-md-6 col-sm-12">
                                    <h1>Dashboard</h1>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#">TATX</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Providers</li>
                                        </ol>
                                    </nav>
                                </div>            
                               
                            </div>
                        </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <ul class="nav nav-tabs2">
                            <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Providers">Providers</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Add">Add Provider</a></li>                
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="Providers">
                                <div class="table-responsive invoice_list mb-4">
                                    <table class="table table-hover table-custom spacing8">
                                        <thead>
                                            <tr> 
                                                <th style="width: 20px;">#</th>
                                                <th>Providers</th>
                                                <th class="w120">Wallet</th>
                                                <th class="w100">Completed</th>
                                                <th class="w100">Canceled</th>
                                                <th class="w60">Rate</th>
                                                <th class="w100">Status</th>
                                                <th class="w100">Online</th>
                                                <th class="w100">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($Orders))
                                            @foreach( $Orders as $Order )
                                            <tr>
                                                <td>
                                                    <span>{{$loop->iteration}}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avtar-pic w35 bg-red" data-toggle="tooltip" data-placement="top" title="{{$Order->provider_first_name}}"><span>{{substr($Order->provider_first_name, 0, 1)}}</span></div>
                                                        <div class="ml-3">
                                                                <p class="mb-0">{{$Order->provider_first_name}} {{$Order->provider_last_name}}</p>
                                                            <p class="mb-0">966 {{$Order->provider_mobile}}</p>
                                                        </div>
                                                    </div>                                        
                                                </td>
                                                <td>SAR {{$Order->provider_wallet_balance}}</td>
                                                <td>{{$Order->Completed_Orders}}</td>
                                                <td>{{$Order->Canceled_Orders}}</td>
                                                <td>{{$Order->provider_rate}}</td>
                                                <td><span class="badge @if($Order->provider_status == 'document') badge-danger @else badge-success @endif ml-0 mr-0">{{$Order->provider_status}}</span></td>
                                                <td><span class="badge @if($Order->provider_online == 'Offline') badge-danger @else badge-success @endif ml-0 mr-0">{{$Order->provider_online}}</span></td>
                                                <td>
                                                        <button type="button" class="btn btn-sm btn-default" onclick="location.href = '{{asset('providers')}}/{{$Order->provider_id}}'" title="Documents" data-toggle="tooltip" data-placement="top"><i class="icon-printer"></i></button>
                                                    <button type="button" onclick="loadWallet({{$Order->provider_id}})" id="walletBtn{{$Order->provider_id}}" class="btn btn-sm btn-default " title="Wallet" data-toggle="tooltip" data-placement="top"><i class="icon-wallet"></i></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="Add">
                                    <div class="body mt-2">
                                           
    
                                        <div class="row clearfix">
                                
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                               
                                                <div class="form-group">
                                                        <label class="form-label">Mobile #</label>
                                                        <input type="number" class="form-control" placeholder="Mobile #">
                                                    </div>
                                                    <div class="form-group">
                                                            <label class="form-label">Code</label>
                                                            <input type="number" class="form-control" placeholder="Code">
                                                        </div>

                                               
                                            </div>
                                            
                
                                            <div class="col-12">
            
                                                <button type="button" class="btn btn-primary">Add</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>            
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<button style="display: none" data-toggle="modal" id="view" data-target=".bd-example-modal-lg"></button>
<!-- Large modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="table-responsive-xl">
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Type</th>
        <th scope="col">Amount</th>
        <th scope="col">Open Balance</th>
        <th scope="col">Close Balance</th>
        <th scope="col">Date</th>
        <th scope="col">Transaction ID</th>
      </tr>
    </thead>
    <tbody id="wallet">
    </tbody>
  </table>
</div>
    </div>
  </div>
</div>
<!-- Javascript -->
<script src="../assets/bundles/libscripts.bundle.js"></script>
<script src="../assets/bundles/vendorscripts.bundle.js"></script>
<script src="../assets/bundles/mainscripts.bundle.js"></script>
<script>
function loadWallet(user_id){
    $('#walletBtn'+user_id).prop('disabled', true);
    $.ajax({
            type: "POST",
            dataType: "json",
            url: "/loadWalletProvider", 
            data: {_token:"{{csrf_token()}}", user_id:user_id }
        }).done(function(data){ 
            if(data['status'] == 0){
                $("#wallet").empty()
                for(var i = 0 ; i < data['result'].length ; i++){
                var Type = (data['result'][i]['type'] == 'D')?"Deposite":"Collect"
                var append = '<tr> <th scope="row">'+(i+1)+'</th> <td>'+Type+'</td> <td>'+data['result'][i]['amount']+'</td> <td>'+data['result'][i]['open_balance']+'</td> <td>'+data['result'][i]['close_balance']+'</td> <td>'+data['result'][i]['created_at']+'</td> <td>'+data['result'][i]['transaction_id']+'</td> </tr>'
                $("#wallet").append(append)
                }
                $("#view").click()
            }else{
                alert(data['error'])
            }
            $('#walletBtn'+user_id).prop('disabled', false);
        });
}
</script>
</body>
</html>
