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
<link rel="stylesheet" href="<?php echo e(asset('assets/vendor/bootstrap/css/bootstrap.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/vendor/font-awesome/css/font-awesome.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/vendor/animate-css/vivify.min.css')); ?>">

<link rel="stylesheet" href="<?php echo e(asset('assets/vendor/c3/c3.min.css')); ?>"/>
<link rel="stylesheet" href="<?php echo e(asset('assets/vendor/chartist/css/chartist.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/vendor/jvectormap/jquery-jvectormap-2.0.3.css')); ?>">

<!-- MAIN CSS -->
<link rel="stylesheet" href="<?php echo e(asset('assets/css/site.min.css')); ?>">

</head>
<body class="theme-cyan font-montserrat light_version">
      
<div id="wrapper">
    <div id="left-sidebar" class="sidebar">
        <div class="navbar-brand">
            <a href="index.html"><img src="<?php echo e(asset('assets/images/icon.svg')); ?>" alt="TATX Logo" class="img-fluid logo"><span>TATX</span></a>
            <button type="button" class="btn-toggle-offcanvas btn btn-sm float-right"><i class="lnr lnr-menu icon-close"></i></button>
        </div>
        <div class="sidebar-scroll">
            <div class="user-account">
                <div class="user_div">
                    <img src="<?php echo e(asset('assets/images/user.png')); ?>" class="user-photo" alt="User Profile Picture">
                </div>
                <div class="dropdown">
                    <span>Welcome,</span>
                    <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>Abdulrhmane</strong></a>
                    <ul class="dropdown-menu dropdown-menu-right account vivify flipInY">
                        <li><a href="profile.html"><i class="icon-user"></i>My Profile</a></li>
                        <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li>
                        <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="page-login.html"><i class="icon-power"></i>Logout</a></li>
                    </ul>
                </div>                
            </div>  
            <?php echo $__env->make('layouts/nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>   
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
                                            <h4 class="mb-0 font-weight-medium"><?php echo e($CurrentOrders); ?></h4>
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
                                                <h4 class="mb-0 font-weight-medium"><?php echo e($Online_Users); ?></h4>
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
                                                    <h4 class="mb-0 font-weight-medium"><?php echo e($Online_Providers); ?></h4>
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
                                                        <h4 class="mb-0 font-weight-medium">$<?php echo e($Total_Income); ?></h4>
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
                                                            <h4 class="mb-0 font-weight-medium"><?php echo e($Completed_Orders); ?></h4>
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
                                                                <h4 class="mb-0 font-weight-medium"><?php echo e($Best_Price_Orders); ?></h4>
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
                                                                    <h4 class="mb-0 font-weight-medium"><?php echo e($Canceled_Orders); ?></h4>
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
                                                                        <h4 class="mb-0 font-weight-medium"><?php echo e($Scheduled_Orders); ?></h4>
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
                                    <?php if(isset($Orders)): ?>
                                    <?php $__currentLoopData = $Orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                            <td><span>TX123456789</span></td>
                                            <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avtar-pic w35 bg-red" data-toggle="tooltip" data-placement="top" title="<?php echo e($Order->provider_first_name); ?>"><span><?php echo e(substr($Order->provider_first_name, 0, 1)); ?></span></div>
                                                        <div class="ml-3">
                                                            <p class="mb-0"><?php echo e($Order->provider_first_name); ?> <?php echo e($Order->provider_last_name); ?></p>
                                                            <p class="mb-0">966 <?php echo e($Order->provider_mobile); ?></p>
                                                        </div>
                                                    </div>                                        
                                                </td>
                                        
                                        <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avtar-pic w35 bg-red" data-toggle="tooltip" data-placement="top" title="<?php echo e($Order->user_first_name); ?>"><span><?php echo e(substr($Order->user_first_name, 0, 1)); ?></span></div>
                                                    <div class="ml-3">
                                                        <p class="mb-0"><?php echo e($Order->user_first_name); ?> <?php echo e($Order->user_last_name); ?></p>
                                                        <p class="mb-0">966 <?php echo e($Order->user_mobile); ?></p>
                                                    </div>
                                                </div>                                        
                                            </td>
                                        <td><?php echo e(explode(' ',$Order->created_at)[0]); ?></td>
                                        <td><?php echo e($Order->status); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
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
<script src="<?php echo e(asset('assets/bundles/libscripts.bundle.js')); ?>"></script>
<script src="<?php echo e(asset('assets/bundles/vendorscripts.bundle.js')); ?>"></script>

<script src="<?php echo e(asset('assets/bundles/c3.bundle.js')); ?>"></script>
<script src="<?php echo e(asset('assets/bundles/flotscripts.bundle.js')); ?>"></script>
<script src="<?php echo e(asset('assets/bundles/jvectormap.bundle.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/jvectormap/jquery-jvectormap-us-aea-en.js')); ?>"></script>

<script src="<?php echo e(asset('assets/bundles/mainscripts.bundle.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/hrdashboard.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Admin\resources\views/dashboard.blade.php ENDPATH**/ ?>