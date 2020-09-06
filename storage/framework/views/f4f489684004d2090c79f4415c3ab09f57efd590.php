<!doctype html>
<html lang="en">

<head>
<title>TATX | Promocodes</title>
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
                                    <li class="breadcrumb-item active" aria-current="page">Promocodes</li>
                                    </ol>
                                </nav>
                            </div>            
                           
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                            <ul class="nav nav-tabs2">
                                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Services">Promocodes</a></li>    
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
                                                    <th class="w100"> CODE</th>
                                                <th> Descriptions</th>
                                                <th class="w100"> Percentage</th>
                                                <th class="w100"> Max Amount</th>
                                                <th class="w120"> Expiration</th>
                                                <th class="w120"> Status</th>
                                                <th class="w100"> Used Count</th>
                                                <th class="w100">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($Promocodes): ?>
                                            <?php $__currentLoopData = $Promocodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Promocode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr id="DIVOFDOC<?php echo e($Promocode->id); ?>">
                                                    <td><?php echo e($Promocode->promo_code); ?></td>
                                                <td>
                                                        <div class="d-flex align-items-center">
                                                                <div class="avtar-pic w35 bg-red" data-toggle="tooltip" data-placement="top" title="<?php echo e($Promocode->name); ?>"><span><img width="100%" src="<?php echo e($Promocode->image); ?>"></span></div>
                                                                <div class="ml-3">
                                                                        <p class="mb-0"><?php echo e($Promocode->name); ?></p>
                                                                    <p class="mb-0"><?php echo e($Promocode->mobile); ?></p>
                                                                </div>
                                                            </div> 
                                                </td>
                                                <td><span id="percentage<?php echo e($Promocode->id); ?>"><?php echo e($Promocode->percentage); ?></span> %</td>
                                                <td id="max_amount<?php echo e($Promocode->id); ?>"><?php echo e($Promocode->max_amount); ?></td>
                                                <td id="expiration<?php echo e($Promocode->id); ?>"><?php echo e(explode(' ',$Promocode->expiration)[0]); ?></td>
                                                <td><span id="status<?php echo e($Promocode->id); ?>" class="badge <?php if($Promocode->status == 'APPROVED'): ?> badge-success <?php else: ?> badge-danger <?php endif; ?> ml-0 mr-0"><?php echo e($Promocode->status); ?></span></td>
                                                <td><?php echo e($Promocode->used); ?></td>
                                                <td>
                                                        <button type="button" id="updateBtn<?php echo e($Promocode->id); ?>" onclick="openUpdateService('<?php echo e($Promocode->id); ?>')" class="btn btn-sm btn-default" title="Edit"><i class="fa fa-edit"></i></button>
                                                        <button onclick="deletePromocode('<?php echo e($Promocode->id); ?>')" type="button" class="btn btn-sm btn-default js-sweetalert" title="Delete" ><i class="fa fa-trash-o text-danger"></i></button>
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
<button style="display: none" data-toggle="modal" id="view" data-target=".bd-example-modal-lg"></button>
<!-- Large modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="tab-content mt-0">
                            <div class="tab-pane active" id="addUser">
                                <form id="upload_form2" style="padding: 0px 18px 18px 18px;" enctype="multipart/form-data" class="body mt-2">
                                    <?php echo e(csrf_field()); ?>

                                            <div class="row clearfix">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                        <label class="form-label">Expiration</label>
                                                        <input id="new_expiration" name="expiration" type="text" class="form-control" placeholder="Like : 2020-01-01">
                                                    </div>
                                                    <input type="hidden" id="promocode_id" name="promocode_id">
                                                        <div class="form-group">
                                                                <label class="form-label">Percentage</label>
                                                                <input id="new_percentage" name="percentage" type="number" class="form-control" placeholder="Percentage">
                                                            </div>
                                                            <div class="form-group">
                                                                    <label class="form-label">Max Amount</label>
                                                                    <input id="new_max_amount" name="max_amount" type="number" class="form-control" placeholder="Max Amount">
                                                                </div>
                                      <div class="col-12">
                                        <ul>
                                               <li style="color: green;display: none" id="success"></li> 
                                               <li style="color: red;display: none" id="error"></li>
                                           </ul>
                                            <button type="button" onclick="updateService()" id="updateBtn2" class="btn btn-primary">Update</button>
                                            <button type="button" id="closeEdit" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
    function deletePromocode(id){
        $('#DIVOFDOC'+id).find('button').prop('disabled', true);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/deletePromocode", 
            data: {_token:"<?php echo e(csrf_token()); ?>", id:id }
        }).done(function(data){
            if(data['status'] == 0){
                if(data['result'] == 'APPROVED'){
                    $("#status"+id).html('APPROVED')
                    $('#status'+id).removeClass('badge-danger').addClass('badge-success');
                }else{
                    $("#status"+id).html('ADDED')
                    $('#status'+id).removeClass('badge-success').addClass('badge-danger');
                }
            }else{
                alert(data['error'])
            }
        $('#DIVOFDOC'+id).find('button').prop('disabled', false);
        });
    }
    function openUpdateService(id){
        $('#DIVOFDOC'+id).find('button').prop('disabled', true);
        var expiration      = $('#expiration'+id).html()
        var percentage      = $('#percentage'+id).html()
        var max_amount      = $('#max_amount'+id).html()

        $('#new_expiration').val(expiration)
        $('#new_percentage').val(percentage)
        $('#new_max_amount').val(max_amount)
        $('#promocode_id').val(id)
        $("#view").click()

        $('#DIVOFDOC'+id).find('button').prop('disabled', false);
    }
    function updateService(){
        $('#updateBtn2').prop('disabled', true);
        var id = $('#promocode_id').val()
        $.ajax({
            url: "/updatePromocode", 
            data: new FormData($("#upload_form2")[0]) ,
            dataType:'json',
            type:'post',
            processData: false,
            contentType: false,
        }).done(function(data){
            if(data['status'] == 0){
                $('#expiration'+id).html($('#new_expiration').val())
                $('#percentage'+id).html($('#new_percentage').val())
                $('#max_amount'+id).html($('#new_max_amount').val())
                $('#closeEdit').click()
            }else{
                alert(data['error'])
            }
        $('#updateBtn2').prop('disabled', false);
        });
    }
</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Admin\resources\views/Admin/promocodes.blade.php ENDPATH**/ ?>