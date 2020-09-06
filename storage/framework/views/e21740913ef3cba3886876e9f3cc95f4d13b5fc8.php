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
        <div class="container-fluid">
            <div class="block-header">
                    <div class="block-header">
                            <div class="row clearfix">
                                <div class="col-md-6 col-sm-12">
                                    <h1>Dashboard</h1>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#">TATX</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                                        </ol>
                                    </nav>
                                </div>            
                               
                            </div>
                        </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="Providers">
                                <div class="table-responsive invoice_list mb-4">
                                    <table class="table table-hover table-custom spacing8">
                                        <thead>
                                            <tr> 
                                                <th style="width: 20px;">#</th>
                                                <th>Users</th>
                                                <th class="w120">Wallet</th>
                                                <th class="w100">Completed</th>
                                                <th class="w100">Canceled</th>
                                                <th class="w100">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($Orders)): ?>
                                            <?php $__currentLoopData = $Orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <span><?php echo e($loop->iteration); ?></span>
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
                                                <td>SAR <?php echo e($Order->user_wallet_balance); ?></td>
                                                <td><?php echo e($Order->Completed_Orders); ?></td>
                                                <td><?php echo e($Order->Canceled_Orders); ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-default " onclick="loadWallet(<?php echo e($Order->user_id); ?>)" id="walletBtn<?php echo e($Order->user_id); ?>"  title="Print" ><i class="icon-wallet"></i></button>
                                                    <button type="button" class="btn btn-sm btn-default" title="Delete" data-toggle="tooltip" data-placement="top"><i class="icon-trash text-danger"></i></button>
                                                </td>
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
            url: "/loadWalletUser", 
            data: {_token:"<?php echo e(csrf_token()); ?>", user_id:user_id }
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
<?php /**PATH C:\xampp\htdocs\Admin\resources\views/Admin/users.blade.php ENDPATH**/ ?>