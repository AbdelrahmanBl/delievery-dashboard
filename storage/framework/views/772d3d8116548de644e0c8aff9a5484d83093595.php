<!doctype html>
<html lang="en">
<head>
<title>TATX | Services Types</title>
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
                                    <li class="breadcrumb-item active" aria-current="page">Categories For Search</li>
                                    </ol>
                                </nav>
                            </div>            
                            
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                            <ul class="nav nav-tabs2">
                                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Services">Categories Search</a></li>
                                    <li class="nav-item"  onclick="$('#success').hide();$('#error').hide();"><a class="nav-link" data-toggle="tab" href="#addUser">Add Categories Search</a></li>
                                    <li class="nav-item"><a id="XML" class="nav-link" href="Javascript:void(0)" onclick="XMLCategory()" >Run XMLCategory</a></li>                
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
                                                <th>Date</th>
                                                <th>Category</th>
                                                <th>Sub Category</th>
                                                <th>Seller</th>
                                                <th>Language</th>
                                                <th>Status</th>
                                                <th class="w100">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableData">
                                            <?php if($Services): ?>
                                            <?php $__currentLoopData = $Services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr id="DIVOFDOC<?php echo e($Service->id); ?>">
                        
                                                <td>
                                                    <h6 id="name<?php echo e($Service->id); ?>" class="mb-0"><?php echo e($Service->name); ?></h6>
                                                </td>
                                                <td><?php echo e($Service->created_at); ?></td>
                                                <td id="type<?php echo e($Service->id); ?>"><?php echo e($Service->category); ?></td>
                                                <td id="capacity<?php echo e($Service->id); ?>"><?php echo e($Service->sub_category); ?></td>
                                                <td id="price_fixed<?php echo e($Service->id); ?>"><?php echo e($Service->uniqueID); ?></td>
                                                <td id="price_minute<?php echo e($Service->id); ?>"><?php echo e($Service->language); ?></td>
                                                <td><span id="status<?php echo e($Service->id); ?>" class="badge <?php if($Service->status == 1): ?> badge-success <?php else: ?> badge-danger <?php endif; ?> ml-0 mr-0"><?php echo e(($Service->status == true) ? 'ON': 'OFF'); ?></span></td>
                                                <td>
                                                        <button onclick="deleteService('<?php echo e($Service->id); ?>')" type="button" class="btn btn-sm btn-default js-sweetalert" title="Delete" ><i class="fa fa-trash-o text-danger"></i></button>
                                                    </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>                
                                </div>
                            </div>
                            <div class="tab-pane" id="addUser">
                                <form  id="upload_form"  enctype="multipart/form-data" class="body mt-2">
                                    <?php echo e(csrf_field()); ?>

                                            <div class="row clearfix" id="inputs">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">Website</label>
                                                    <select name="uniqueID" class="form-control">
                                                            <option value="">-- Select Website --</option>
                                                            <option value="tamimi">tamimi markets</option>
                                                            <option value="carfour">carrefour</option>
                                                            <option value="panda">panda</option>
                                                            <option value="extra_stores">extra stores</option>
                                                            <option value="jarir_bookstore">jarir bookstore</option>
                                                            <option value="virgin_megastore">virgin megastore</option>
                                                            <option value="nahdi_pharmacy">nahdi pharmacy</option>
                                                            <option value="kunooz_pharmacy">kunooz pharmacy</option>
                                                            <option value="aldawaa_pharmacy">aldawaa pharmacy</option>
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                        <label class="form-label">Category Search</label>
                                                        <input name="name" type="text" class="form-control" placeholder="Category Search">
                                                    </div>
                                                <div class="form-group">
                                                        <label class="form-label">Category English</label>
                                                        <select class="form-control" id="changeSelect" onchange="change('category_english',$(this).val())">
                                                            <option disabled selected>--Select--</option>
                                                            <?php $__currentLoopData = $Categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($Category->_id); ?>"><?php echo e($Category->category_english); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <input type="hidden" name="category_english">
                                                    </div>
                                                    
                                                        <div class="form-group">
                                                                <label class="form-label">sub Category English</label>
                                                                <select id="selectSub" class="form-control" name="sub_category_english">
                                                                </select>
                                                            </div>
                                                            <input type="hidden" name="category_arabic">
                                                            <input name="sub_category_arabic" type="hidden">
                                                                    
                                      <div class="col-12">
                                        <ul>
                                               <li style="color: green;display: none" id="success"></li> 
                                               <li style="color: red;display: none" id="error"></li>
                                           </ul>
                                            <button type="button" onclick="addService()" id="ADD" class="btn btn-primary">Add</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
    var subEn
    var subAr
    var categoryAr
    function addService(){
        $('#ADD').prop('disabled', true);
        var index = subEn.indexOf($('#selectSub').val())
        $('input[name="sub_category_arabic"]').val(subAr[index])
        $('input[name="category_arabic"]').val(categoryAr)
        $.ajax({
            url: "/addCategorySearch", 
            data: new FormData($("#upload_form")[0]) ,
            dataType:'json',
            type:'post',
            processData: false,
            contentType: false,
        }).done(function(data){
            if(data['status'] == 0){
            var HTMLEn = '<tr> <td> <h6  class="mb-0">'+$("input[name='name']").val()+'</h6> </td> <td>NOW</td> <td>'+$("input[name='category_english']").val()+'</td> <td>'+$("select[name='sub_category_english']").val()+'</td> <td>'+$("select[name='uniqueID']").val()+'</td> <td>en</td> <td><span  class="badge badge-success ml-0 mr-0">ON</span></td><td></td></tr>'
            var HTMLAr = '<tr> <td> <h6  class="mb-0">'+$("input[name='name']").val()+'</h6> </td> <td>NOW</td> <td>'+$("input[name='category_arabic']").val()+'</td> <td>'+$("input[name='sub_category_arabic']").val()+'</td> <td>'+$("select[name='uniqueID']").val()+'</td> <td>ar</td> <td><span  class="badge badge-success ml-0 mr-0">ON</span></td><td></td></tr>'
                $('#tableData').prepend(HTMLEn)
                $('#tableData').prepend(HTMLAr)
                $('#success').html(data['result'])
                $('#error').hide()
                $('#success').hide()
                $('#success').show('slow')
                // $("#inputs").find("input, select").val("");
                // $('#selectSub').empty()
            }else{
                $('#error').html(data['error'])
                $('#error').hide()
                $('#error').show('slow')
            }
            $('#ADD').prop('disabled', false);
        });
    }
    function deleteService(id){
        $('#DIVOFDOC'+id).find('button').prop('disabled', true);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/deleteCategorySearch", 
            data: {_token:"<?php echo e(csrf_token()); ?>", id:id }
        }).done(function(data){
            if(data['status'] == 0){
                if(data['result'] == 'OFF'){
                $('#status'+id).html('OFF')
                $('#status'+id).removeClass('badge-success').addClass('badge-danger');
                }
                else{ 
                    $('#status'+id).html('ON')
                    $('#status'+id).removeClass('badge-danger').addClass('badge-success');
                }
            }else{
                alert(data['error'])
            }
        $('#DIVOFDOC'+id).find('button').prop('disabled', false);
        });
    }
    function change(input,value){
        $('#changeSelect').prop('disabled', true);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/getCategorySub", 
            data: {_token:"<?php echo e(csrf_token()); ?>", id:$('#changeSelect').val() }
        }).done(function(data){
            if(data['status'] == 0){
                $('input[name="'+input+'"]').val(data['categoryEn'])
                subEn = data['subEn'].split(',')
                subAr = data['subAr'].split(',')
                var append = ''
                for(var i = 0 ; i < (subEn.length -1) ; i++){
                    append += '<option value="'+subEn[i]+'">'+subEn[i]+'</option>'
                }
                $('#selectSub').html(append)
                categoryAr = data['categoryAr']
            }else{
                alert(data['error'])
                $('#changeSelect').val('')
            }
        $('#changeSelect').prop('disabled', false);
        });
    }
    function XMLCategory(){
        $('#XML').prop('disabled', false);
        $('#XML').html('wait ..')
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/XMLCategory", 
            data: {_token:"<?php echo e(csrf_token()); ?>"}
        }).done(function(data){
            if(data['status'] == 0){
                alert(data['result'])
            }else{
                alert(data['error'])
            }
        $('#XML').html('Run XMLCategory')    
        $('#XML').prop('disabled', false);
        });
    }
</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Admin\resources\views/Admin/categorySearch.blade.php ENDPATH**/ ?>