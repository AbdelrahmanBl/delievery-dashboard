<!doctype html>
<html lang="en">

<head>
<title>TATX | Partners</title>
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
                                        <li class="breadcrumb-item active" aria-current="page">Clients</li>
                                        </ol>
                                    </nav>
                                    <div class="content">
                            <h3>Users</h3>
                            <div class="users mt-2">
                                <?php $__currentLoopData = $Users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $User): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="user" href="/chat/<?php echo e($User->roomID); ?>" target="_blank">
                                        <div class="user mt-2 d-flex bg-white rounded-lg shadow p-2">
                                            <div class="image">
                                                <img style="height: 80px; width: 80px;" src="/assets/images/client.gif" title="client" alt="client"/>
                                            </div>
                                            <div class="content pl-2">
                                                <h6>Name <span style="font-weight: 500"><?php echo e($User->Name); ?></span> </h6>
                                                <h6 class="mt-1">Email <span style="font-weight: 500"><?php echo e($User->Email); ?></span> </h6>
                                                <h6 class="mt-1">Phone <span style="font-weight: 500"><?php echo e($User->Phone); ?></span> </h6>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<!-- Jquery Slim JS -->
        <!-- <script src="/assets/js/jquery.min.js"></script> -->
        <!-- Popper JS -->
        <!-- <script src="/assets/js/popper.min.js"></script> -->
        <!-- Bootstrap JS -->
        <!-- <script src="/assets/js/bootstrap.min.js"></script> -->
        <!-- Moment JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
        <!-- Live Chat Support JS -->
        <script src="/assets/js/Socket.js"></script>
        <script>
            $(() => {
                var socket = io('https://tatx.com'); 
                socket.on('newUser', (data) => {
                    $(".users").prepend(`
                        <a class="user" href="/chat/${ data.roomID }" target="_blank">
                            <div class="user mt-2 d-flex bg-white rounded-lg shadow p-2">
                                <div class="image">
                                    <img style="height: 80px; width: 80px;" src="/assets/Images/client.webp" title="client" alt="client"/>
                                </div>
                                <div class="content pl-2">
                                    <h6>Name <span style="font-weight: 500">${ data.Name }</span> </h6>
                                    <h6 class="mt-1">Email <span style="font-weight: 500">${ data.Email }</span> </h6>
                                    <h6 class="mt-1">Phone <span style="font-weight: 500">${ data.Phone }</span> </h6>
                                </div>
                            </div>
                        </a>
                    `)
                })
            })
        </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Admin\resources\views/Admin/clients.blade.php ENDPATH**/ ?>