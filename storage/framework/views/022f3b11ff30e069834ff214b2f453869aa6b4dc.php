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
<?php echo $__env->make('layouts/Admin/loadingAndLighting', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>       
<div id="wrapper">
    <?php echo $__env->make('layouts/Admin/topNav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div id="left-sidebar" class="sidebar">
         <?php echo $__env->make('layouts/Admin/logo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="sidebar-scroll">
            <?php echo $__env->make('layouts/Admin/info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
            <?php echo $__env->make('layouts/Admin/nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>   
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
                                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Current">Current <span class="badge"><?php echo e(count($CurrentOrders)); ?></span></a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Completed">Completed <span class="badge"><?php echo e($Completed_count); ?></span></a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Scheduled">Scheduled <span class="badge"><?php echo e($Scheduled_count); ?></span></a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#BestPrice">Best Price <span class="badge"><?php echo e($Best_Price_count); ?></span></a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Canceled">Canceled <span class="badge"><?php echo e($Canceled_count); ?></span></a></li> 
                                                 
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
                                    <?php if(isset($CurrentOrders)): ?>
                                    <?php $__currentLoopData = $CurrentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                            <td><span><?php echo e($Order->booking_id); ?></span></td>
                                        <td><?php echo e($Order->created_at); ?></td>
                                        <td><?php echo e($Order->status); ?></td>
                                        <td></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
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
                                    <?php if(isset($Orders)): ?>
                                    <?php $__currentLoopData = $Completed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                            <td><span><?php echo e($Order->booking_id); ?></span></td>
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
                                        <td><a href="Javascript:void(0)" onclick="showInvoice(<?php echo e($Order->booking_id); ?>)"><?php echo e($Order->payment_mode); ?></a></td>
                                        <td><?php echo e($Order->total); ?> SAR</td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive tab-pane show"  id="Scheduled">
                            <table class="table table-hover js-basic-example dataTable table-custom spacing5 mb-0">
                                <thead>
                                    <tr>
                                        
                                        <th>Booking Id</th>
                                        <th>Provider</th>
                                        <th>User</th>
                                        <th>Date</th>
                                        <th>Scheduled At</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($Orders)): ?>
                                    <?php $__currentLoopData = $Orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($Order-> status == 'SCHEDULED'): ?>
                                    <tr>
                                            <td><span><?php echo e($Order->booking_id); ?></span></td>
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
                                        <td><?php echo e($Order->schedule_at); ?></td>
                                        <td></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive tab-pane show"  id="BestPrice">
                            <table class="table table-hover js-basic-example dataTable table-custom spacing5 mb-0">
                                <thead>
                                    <tr>
                                        
                                        <th>Booking Id</th>
                                        <th>Provider</th>
                                        <th>User</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($Orders)): ?>
                                    <?php $__currentLoopData = $Completed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($Order->is_best_price == 'YES'): ?>
                                    <tr>
                                            <td><span><?php echo e($Order->booking_id); ?></span></td>
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
                                        <td><?php echo e($Order->total); ?> SAR</td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
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
                                    <?php if(isset($Orders)): ?>
                                    <?php $__currentLoopData = $Orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($Order->status == 'CANCELLED'): ?>
                                    <tr>
                                            <td><span><?php echo e($Order->booking_id); ?></span></td>
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
                                        <td><?php echo e($Order->cancelled_by); ?></td>
                                        <td><?php echo e($Order->cancel_reason); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
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
<button style="display: none" data-toggle="modal" id="showInvoice" data-target=".bd-example-modal-lg"></button>
<!-- Large modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="table-responsive-xl">
  <table class="table">
    <tbody>
        <tr>
          <th>payment id</th>
            <td id="payment_id"></td>
        </tr>
        <tr>
          <th>fixed</th>
            <td id="fixed"></td>
        </tr>
        <tr>
          <th>distance</th>
            <td id="distance"></td>
        </tr>
        <th>commision</th>
            <td id="commision"></td>
        </tr>
        <th>fleet</th>
            <td id="fleet"></td>
        </tr>
        <th>discount</th>
            <td id="discount"></td>
        </tr>
        <th>tax</th>
            <td id="tax"></td>
        </tr>
        <th>govt</th>
            <td id="govt"></td>
        </tr>
        <th>tax_marketing</th>
            <td id="tax_marketing"></td>
        </tr>
        <th>total</th>
            <td id="total"></td>
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
function showInvoice(booking_id){
    $.ajax({
            type: "POST",
            dataType: "json",
            url: "/showInvoice", 
            data: {_token:"<?php echo e(csrf_token()); ?>", payment_id:booking_id }
        }).done(function(data){ 
            if(data['status'] == 0){
                $('#fixed').html(data['result']['fixed'])
                $('#distance').html(data['result']['distance'])
                $('#commision').html(data['result']['commision'])
                $('#fleet').html(data['result']['fleet'])
                $('#discount').html(data['result']['discount'])
                $('#tax').html(data['result']['tax'])
                $('#govt').html(data['result']['govt'])
                $('#tax_marketing').html(data['result']['tax_marketing'])
                $('#total').html(data['result']['total'])
                $('#payment_id').html(booking_id)
                $("#showInvoice").click()
            }else{
                alert(data['error'])
            }
        });
}
</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Admin\resources\views/Admin/orders.blade.php ENDPATH**/ ?>