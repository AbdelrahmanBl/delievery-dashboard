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
                                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Current">Current <span class="badge"><?php echo e($Current_count); ?></span></a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Completed">Completed <span class="badge"><?php echo e($Completed_count); ?></span></a></li>
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
                                    <?php if(isset($Orders)): ?>
                                    <?php $__currentLoopData = $Orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($Order->status == 'SEARCHING' || $Order->status == 'ACCEPTED' || $Order->status == 'STARTED'): ?>
                                    <tr>
                                            <td><span><?php echo e($Order->booking_id); ?></span></td>
                                        <td><?php echo e(explode(' ',$Order->created_at)[0]); ?></td>
                                        <td><?php echo e($Order->status); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-default " onclick="Details('<?php echo e($Order->id); ?>')" id="detailsBtn<?php echo e($Order->id); ?>" title="Print"><i class="icon-wallet"></i></button>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
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
                                    <?php $__currentLoopData = $Orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($Order->status == 'COMPLETED'): ?>
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
            data: {_token:"<?php echo e(csrf_token()); ?>", order_id:order_id }
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
<?php /**PATH C:\xampp\htdocs\Admin\resources\views/Admin/delievery_orders.blade.php ENDPATH**/ ?>