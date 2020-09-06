<!doctype html>
<html lang="en">

<head>
<title>TATX | Payments</title>
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
                                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                        </ol>
                                    </nav>
                                </div>            
                               
                            </div>
                        </div>
            </div>
            <div class="row clearfix">
                <!-- Start Statisatical -->
                                <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="body">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-in-bg bg-azura text-white rounded-circle"><i class="fa fa-credit-card"></i></div>
                                            <div class="ml-4">
                                                <span>Today's Total</span>
                                                <h4 class="mb-0 font-weight-medium">100</h4>
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
                                                <span>Current Month</span>
                                                <h4 class="mb-0 font-weight-medium">100</h4>
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
                                                <span>Last Month</span>
                                                <h4 class="mb-0 font-weight-medium">100</h4>
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
                                                <span>Tax</span>
                                                <h4 class="mb-0 font-weight-medium">100</h4>
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
                                                <span>Government</span>
                                                <h4 class="mb-0 font-weight-medium">100</h4>
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
                                                <span>Marketers Total</span>
                                                <h4 class="mb-0 font-weight-medium">100</h4>
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
                                                <span>Fleets Total</span>
                                                <h4 class="mb-0 font-weight-medium">100</h4>
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
                                                <span>Drivers Total</span>
                                                <h4 class="mb-0 font-weight-medium">100</h4>
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
                                                <span>Users Total</span>
                                                <h4 class="mb-0 font-weight-medium">100</h4>
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
                                                <span>Total Discount</span>
                                                <h4 class="mb-0 font-weight-medium">100</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <!-- End Statistical -->
                <div class="col-lg-12">
                    <div class="card">
                        <ul class="nav nav-tabs2">
                            <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#EmployeeSalary">Employee Salary</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Payslip">Payslip</a></li>                
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="EmployeeSalary">
                                <div class="table-responsive invoice_list mb-4">
                                    <table class="table table-hover table-custom spacing8">
                                        <thead>
                                            <tr> 
                                                <th style="width: 20px;">#</th>
                                                <th>Employee</th>
                                                <th class="w100">Role</th>
                                                <th class="w60">Salary</th>
                                                <th class="w60">Status</th>
                                                <th class="w60">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span>01</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avtar-pic w35 bg-red" data-toggle="tooltip" data-placement="top" title="Avatar Name"><span>SS</span></div>
                                                        <div class="ml-3">
                                                            <a href="" title="">South Shyanne</a>
                                                            <p class="mb-0">south.shyanne@example.com</p>
                                                        </div>
                                                    </div>                                        
                                                </td>
                                                <td>Web Developer</td>
                                                <td>$1200</td>
                                                <td><span class="badge badge-success ml-0 mr-0">Done</span></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-default" title="Send Invoice" data-toggle="tooltip" data-placement="top"><i class="icon-envelope text-info"></i></button>
                                                    <button type="button" class="btn btn-sm btn-default " title="Print" data-toggle="tooltip" data-placement="top"><i class="icon-printer"></i></button>
                                                    <button type="button" class="btn btn-sm btn-default" title="Delete" data-toggle="tooltip" data-placement="top"><i class="icon-trash text-danger"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span>02</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="../assets/images/xs/avatar2.jpg" data-toggle="tooltip" data-placement="top" title="Avatar Name" alt="Avatar" class="w35 h35 rounded">
                                                        <div class="ml-3">
                                                            <a href="" title="">Zoe Baker</a>
                                                            <p class="mb-0">zoe.baker@example.com</p>
                                                        </div>
                                                    </div>                                        
                                                </td>
                                                <td>Graphics Desgber</td>
                                                <td>$378</td>
                                                <td><span class="badge badge-success ml-0 mr-0">Done</span></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-default" title="Send Invoice" data-toggle="tooltip" data-placement="top"><i class="icon-envelope text-info"></i></button>
                                                    <button type="button" class="btn btn-sm btn-default " title="Print" data-toggle="tooltip" data-placement="top"><i class="icon-printer"></i></button>
                                                    <button type="button" class="btn btn-sm btn-default" title="Delete" data-toggle="tooltip" data-placement="top"><i class="icon-trash text-danger"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span>03</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                            <div class="avtar-pic w35 bg-indigo" data-toggle="tooltip" data-placement="top" title="Avatar Name"><span>CB</span></div>
                                                        <div class="ml-3">
                                                            <a href="" title="">Colin Brown</a>
                                                            <p class="mb-0">colinbrown@example.com</p>
                                                        </div>
                                                    </div>                                        
                                                </td>
                                                <td>HTML Developer</td>
                                                <td>$653</td>
                                                <td><span class="badge badge-success ml-0 mr-0">Done</span></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-default" title="Send Invoice" data-toggle="tooltip" data-placement="top"><i class="icon-envelope text-info"></i></button>
                                                    <button type="button" class="btn btn-sm btn-default " title="Print" data-toggle="tooltip" data-placement="top"><i class="icon-printer"></i></button>
                                                    <button type="button" class="btn btn-sm btn-default" title="Delete" data-toggle="tooltip" data-placement="top"><i class="icon-trash text-danger"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span>04</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avtar-pic w35 bg-green" data-toggle="tooltip" data-placement="top" title="Avatar Name"><span>KG</span></div>
                                                        <div class="ml-3">
                                                            <a href="" title="">Kevin Gill</a>
                                                            <p class="mb-0">kevin.gill@example.com</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Mobile</td>
                                                <td>$451</td>
                                                <td><span class="badge badge-warning  ml-0 mr-0">Panding</span></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-default" title="Send Invoice" data-toggle="tooltip" data-placement="top"><i class="icon-envelope text-info"></i></button>
                                                    <button type="button" class="btn btn-sm btn-default " title="Print" data-toggle="tooltip" data-placement="top"><i class="icon-printer"></i></button>
                                                    <button type="button" class="btn btn-sm btn-default" title="Delete" data-toggle="tooltip" data-placement="top"><i class="icon-trash text-danger"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span>05</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="../assets/images/xs/avatar5.jpg" data-toggle="tooltip" data-placement="top" title="Avatar Name" alt="Avatar" class="w35 h35 rounded">
                                                        <div class="ml-3">
                                                            <a href="" title="">Brandon Smith</a>
                                                            <p class="mb-0">Maria.gill@example.com</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>VueJs FrontEnd</td>
                                                <td>$1,989</td>
                                                <td><span class="badge badge-success  ml-0 mr-0">Done</span></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-default" title="Send Invoice" data-toggle="tooltip" data-placement="top"><i class="icon-envelope text-info"></i></button>
                                                    <button type="button" class="btn btn-sm btn-default " title="Print" data-toggle="tooltip" data-placement="top"><i class="icon-printer"></i></button>
                                                    <button type="button" class="btn btn-sm btn-default" title="Delete" data-toggle="tooltip" data-placement="top"><i class="icon-trash text-danger"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span>06</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="../assets/images/xs/avatar6.jpg" data-toggle="tooltip" data-placement="top" title="Avatar Name" alt="Avatar" class="w35 h35 rounded">
                                                        <div class="ml-3">
                                                            <a href="javascript:void(0);" title="">Kevin Baker</a>
                                                            <p class="mb-0">kevin.baker@example.com</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Java Developer</td>
                                                <td>$343</td>
                                                <td><span class="badge badge-warning  ml-0 mr-0">Panding</span></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-default" title="Send Invoice" data-toggle="tooltip" data-placement="top"><i class="icon-envelope text-info"></i></button>
                                                    <button type="button" class="btn btn-sm btn-default " title="Print" data-toggle="tooltip" data-placement="top"><i class="icon-printer"></i></button>
                                                    <button type="button" class="btn btn-sm btn-default" title="Delete" data-toggle="tooltip" data-placement="top"><i class="icon-trash text-danger"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span>13</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="../assets/images/xs/avatar3.jpg" data-toggle="tooltip" data-placement="top" title="Avatar Name" alt="Avatar" class="w35 h35 rounded">
                                                        <div class="ml-3">
                                                            <a href="javascript:void(0);" title="">Colin Brown</a>
                                                            <p class="mb-0">colin-brown@example.com</p>
                                                        </div>
                                                    </div>                                        
                                                </td>
                                                <td>Designer</td>
                                                <td>$653</td>
                                                <td><span class="badge badge-success ml-0 mr-0">Done</span></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-default" title="Send Invoice" data-toggle="tooltip" data-placement="top"><i class="icon-envelope text-info"></i></button>
                                                    <button type="button" class="btn btn-sm btn-default " title="Print" data-toggle="tooltip" data-placement="top"><i class="icon-printer"></i></button>
                                                    <button type="button" class="btn btn-sm btn-default" title="Delete" data-toggle="tooltip" data-placement="top"><i class="icon-trash text-danger"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span>14</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="../assets/images/xs/avatar4.jpg" data-toggle="tooltip" data-placement="top" title="Avatar Name" alt="Avatar" class="w35 h35 rounded">
                                                        <div class="ml-3">
                                                            <a href="javascript:void(0);" title="">Kevin Gill</a>
                                                            <p class="mb-0">kevin-gill@example.com</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Team Leader</td>
                                                <td>$451</td>
                                                <td><span class="badge badge-warning  ml-0 mr-0">Panding</span></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-default" title="Send Invoice" data-toggle="tooltip" data-placement="top"><i class="icon-envelope text-info"></i></button>
                                                    <button type="button" class="btn btn-sm btn-default " title="Print" data-toggle="tooltip" data-placement="top"><i class="icon-printer"></i></button>
                                                    <button type="button" class="btn btn-sm btn-default" title="Delete" data-toggle="tooltip" data-placement="top"><i class="icon-trash text-danger"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="Payslip">
                                <div class="card">
                                    <article class="media body mb-0">
                                        <div class="mr-3">
                                            <img class="rounded" src="../assets/images/xs/avatar4.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="content">
                                                <span><strong>Order ID: </strong> C09</span>
                                                <p class="h5">John Smith <small class="float-right badge badge-primary">AUG 15, 2018</small></p>
                                                <p>795 Folsom Ave, Suite 546 San Francisco, CA 54656</p>
                                            </div>
                                            <nav class="d-flex text-muted">
                                                <a href="javascript:void(0);" class="icon mr-3"><i class="icon-envelope text-info"></i></a>
                                                <a href="javascript:void(0);" class="icon mr-3"><i class="icon-printer"></i></a>
                                            </nav>
                                        </div>
                                    </article>
                                    <div class="row clearfix">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-custom spacing5">
                                                    <thead>
                                                        <tr>
                                                            <th class="w60">#</th>
                                                            <th></th>
                                                            <th class="w100">Earnings</th>
                                                            <th class="w100">Deductions</th>
                                                            <th class="w100 text-right">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>
                                                                <span>Basic Salary</span>
                                                            </td>                                                    
                                                            <td>$1,500</td>
                                                            <td>-</td>
                                                            <td class="text-right">$380</td>
                                                        </tr>
                                                        <tr>
                                                            <td>02</td>
                                                            <td>
                                                                <span>House Rent Allowance (H.R.A.)</span>
                                                            </td>
                                                            <td>$62</td>
                                                            <td>-</td>
                                                            <td class="text-right">$250</td>
                                                        </tr>
                                                        <tr>
                                                            <td>03</td>
                                                            <td>
                                                                <span>Tax Deducted at Source (T.D.S.)</span>
                                                            </td>
                                                            <td>-</td>
                                                            <td>$80</td>
                                                            <td class="text-right">$120</td>
                                                        </tr>                                                
                                                        <tr>
                                                            <td>04</td>
                                                            <td>
                                                                <span>C/Bank Loan</span>
                                                            </td>
                                                            <td>-</td>
                                                            <td>$120</td>
                                                            <td class="text-right">$120</td>
                                                        </tr>                                                
                                                        <tr>
                                                            <td>05</td>
                                                            <td>
                                                                <span>Other Allowance</span>
                                                            </td>
                                                            <td>$121</td>
                                                            <td>-</td>
                                                            <td class="text-right">$120</td>
                                                        </tr>                                                
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2"><span><strong>Note:</strong> Ipsum is simply dummy text of the printing and typesetting industry.</span></td>
                                                            <td>$1683</td>
                                                            <td>$200</td>
                                                            <td class="text-right">
                                                                <strong class="text-success">$1483.00</strong>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-12 text-right">
                                            <button class="btn btn-info"><i class="icon-printer"></i> Print</button>
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

<!-- Javascript -->
<script src="../assets/bundles/libscripts.bundle.js"></script>
<script src="../assets/bundles/vendorscripts.bundle.js"></script>

<script src="../assets/bundles/mainscripts.bundle.js"></script>
</body>
</html>
