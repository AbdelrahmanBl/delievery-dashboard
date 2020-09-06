<!doctype html>
<html lang="en">

<head>
<title>TATX | Sign Up</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="TATX Bootstrap 4x admin is super flexible, powerful, clean &amp; modern responsive admin dashboard with unlimited possibilities.">
<meta name="author" content="GetBootstrap, design by: puffintheme.com">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../assets/vendor/animate-css/vivify.min.css">

<!-- MAIN CSS -->
<link rel="stylesheet" href="../assets/css/site.min.css">

</head>

<body class="theme-cyan font-montserrat light_version">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
        <div class="bar4"></div>
        <div class="bar5"></div>
    </div>
</div>

<div class="pattern">
    <span class="red"></span>
    <span class="indigo"></span>
    <span class="blue"></span>
    <span class="green"></span>
    <span class="orange"></span>
</div>
<div class="auth-main particles_js">
    <div class="auth_div vivify popIn">
        <div class="auth_brand">
            <a class="navbar-brand" href="javascript:void(0);"><img src="../assets/images/icon.svg" width="30" height="30" class="d-inline-block align-top mr-2" alt="">TATX</a>                                                
        </div>
        <div class="card">
            <div class="body">
                <p class="lead">Create an account</p>
                <?php if($errors->any()): ?>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span style="color: red;font-size: 11px;"><?php echo e($error); ?></span><br>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <form action="register" method="post" class="form-auth-small m-t-20">
                            <?php echo e(CSRF_field()); ?>

                        <div class="form-group">
                                <!-- <label class="form-label" align=left>Full Name</label> -->
                                <input name="name" type="text" class="form-control" placeholder="Full Name" value="<?php echo e(old('name')); ?>">
                            </div>
                            <div class="form-group">
                                    <!-- <label class="form-label">Your Email</label> -->
                                    <input name="email" type="email" class="form-control" placeholder="Your Email" value="<?php echo e(old('email')); ?>">
                                </div>
                                <div class="form-group">
                                        <!-- <label class="form-label">Password</label> -->
                                        <input name="password" type="password" class="form-control" placeholder="Password" value="<?php echo e(old('password')); ?>">
                                    </div>
                    <!-- <div class="form-group">
                        <input type="email" class="form-control round" placeholder="Your email">
                        <div class="form-group">
                                <label class="form-label">Mobile #</label>
                                <input type="number" class="form-control" placeholder="Mobile #">
                            </div>
                    </div>
                    <div class="form-group">                            
                        <input type="password" class="form-control round" placeholder="Password">
                    </div> -->
                    <button type="submit" class="btn btn-primary btn-round btn-block">Register</button>      
                    
                    <div class="bottom">
                            <span class="helper-text">Already have an account ? <a href="login">Login</a></span>
                        </div>
                </form>
                
                
        </div>
    </div>
    <div id="particles-js"></div>
</div>
<!-- END WRAPPER -->

<script src="../assets/bundles/libscripts.bundle.js"></script>    
<script src="../assets/bundles/vendorscripts.bundle.js"></script>
<script src="../assets/bundles/mainscripts.bundle.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\Admin\resources\views/Main/register.blade.php ENDPATH**/ ?>