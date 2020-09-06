<!doctype html>
<html lang="en">

<head>
<title>TATX | Documents</title>
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
                <div class="row clearfix">
                        <div class="col-md-6 col-sm-12">
                                <h1>Dashboard</h1>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">TATX</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Documents</li>
                                    </ol>
                                </nav>
                            </div>            
                           
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                            <ul class="nav nav-tabs2">
                                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Services">Documents</a></li>
                                    <li class="nav-item" onclick="$('#success').hide();$('#error').hide();"><a class="nav-link" data-toggle="tab" href="#add">Add Document</a></li>                
                                </ul>

                        <!-- <ul class="nav nav-tabs">
                            <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Users">Services Types</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#addUser">Add Service</a></li>        
                        </ul> -->
                        <div class="tab-content mt-0">
                            <div class="tab-pane show active" id="Services">
                                <div class="table-responsive">
                                    <table class="table table-hover table-custom spacing8">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th class="w100">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="docs">
                                            <?php if($Documents): ?>
                                            <?php $__currentLoopData = $Documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr id="DIVOFDOC<?php echo e($Document->id); ?>">
                                                    <td><?php echo e($Document->name); ?></td>
                                                <td><?php echo e($Document->type); ?></td>                                        
                                                <td>
                                                        <button onclick="deleteDoc('<?php echo e($Document->id); ?>')" type="button" class="btn btn-sm btn-default js-sweetalert" title="Delete" ><i class="fa fa-trash-o text-danger"></i></button>
                                                    </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>                
                                </div>
                            </div>
                            <div class="tab-pane" id="add">
                                <div class="body mt-2">                                            
                                    <div class="row clearfix">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                           <ul>
                                               <li style="color: green;display: none" id="success"></li> 
                                               <li style="color: red;display: none" id="error"></li>
                                           </ul>
                                            <div class="form-group">
                                                    <label class="form-label">Service Name</label>
                                                    <input id="service_name" type="text" class="form-control" placeholder="Service Name">
                                                </div>
                                                <div class="form-group">
                                                        <label class="form-label">Service Type</label>
                                                        <select id="service_type" class="form-control">
                                                            <option value="">-- Select Type --</option>
                                                            <option value="DRIVER">DRIVER</option>
                                                            <option value="VEHICLE">VEHICLE</option>
                                                        </select>
                                                    </div>

                                        </div>
                                                 
                                        <div class="col-12">
                                            <button type="button" id="ADD" onclick="addDoc()" class="btn btn-primary">Add</button>
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

<!-- Javascript -->
<script src="../assets/bundles/libscripts.bundle.js"></script>
<script src="../assets/bundles/vendorscripts.bundle.js"></script>

<script src="../assets/vendor/sweetalert/sweetalert.min.js"></script>

<script src="../assets/bundles/mainscripts.bundle.js"></script>
<script src="../assets/js/pages/ui/dialogs.js"></script>
<script>
    function addDoc(){
        $('#ADD').prop('disabled', true);
        var service_name = $('#service_name').val();
        var service_type = $('#service_type').val();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/addDoc", 
            data: {_token:"<?php echo e(csrf_token()); ?>", service_name:service_name , service_type:service_type }
        }).done(function(data){
            if(data['status'] == 0){
                $('#docs').append('<tr id="DIVOFDOC'+data['id']+'"> <td>'+service_name+'</td> <td>'+service_type+'</td> <td> <button type="button" onclick="deleteDoc('+data['id']+')" class="btn btn-sm btn-default js-sweetalert" title="Delete" ><i class="fa fa-trash-o text-danger"></i></button> </td> </tr>')
                $('#success').html(data['result'])
                $('#error').hide()
                $('#success').hide()
                $('#success').show('slow')
                $('#add').find("input, select").val("");
            }else{
                $('#error').html(data['error'])
                $('#error').hide()
                $('#error').show('slow')
            }
            $('#ADD').prop('disabled', false);
        }); 
    }
    function deleteDoc(id){
        $('#DIVOFDOC'+id).find('button').prop('disabled', true);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/deleteDoc", 
            data: {_token:"<?php echo e(csrf_token()); ?>", id:id }
        }).done(function(data){
            if(data['status'] == 0){
                $('#DIVOFDOC'+id).hide('fast')
            }else{
                alert(data['error'])
            }
        $('#DIVOFDOC'+id).find('button').prop('disabled', false);
        });
    }
</script>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\Admin\resources\views/Admin/documents.blade.php ENDPATH**/ ?>