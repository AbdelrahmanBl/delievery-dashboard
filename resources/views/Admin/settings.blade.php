<!doctype html>
<html lang="en">

<head>
<title>TATX | Settings</title>
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
                <div class="row clearfix">
                        <div class="col-md-6 col-sm-12">
                                <h1>Dashboard</h1>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">TATX</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Settings</li>
                                    </ol>
                                </nav>
                            </div>            
                           
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                            <ul class="nav nav-tabs2">
                                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Services">Settings</a></li>
                                    <li class="nav-item" onclick="$('#success').hide();$('#error').hide();"><a class="nav-link" data-toggle="tab" href="#add">Add </a></li>                
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
                                                <th>KEY</th>
                                                <th>VALUE</th>
                                                <th class="w100">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="docs">
                                            @if($Settings)
                                            @foreach($Settings as $Setting)
                                            <tr id="DIVOFDOC{{$Setting->id}}">
                                                    <td>{{$Setting->key}}</td>>
                                                <td>{{(strlen($Setting->value) > 70)?substr($Setting->value, 0, 70) .'....':$Setting->value}}</td>                                        
                                                <td>
                                                        <button type="button" class="btn btn-sm btn-default" title="Edit"><i class="fa fa-edit"></i></button>
                                                        <button type="button" class="btn btn-sm btn-default js-sweetalert" title="Delete" onclick="deleteSetting('{{$Setting->id}}')"><i class="fa fa-trash-o text-danger"></i></button>
                                                    </td>
                                            </tr>
                                            @endforeach
                                            @endif
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
                                                        <label class="form-label">KEY</label>
                                                        <input type="text" id="key" class="form-control" placeholder="KEY">
                                                    </div>
                                                    <div class="form-group">
                                                            <label class="form-label">VALUE</label>
                                                            <input type="text" id="value" class="form-control" placeholder="VALUE">
                                                        </div>
                                        </div>
                                         
                                        <div class="col-12">
                                            <button type="button" id="ADD" onclick="addSetting()" class="btn btn-primary">Add</button>
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
    function addSetting(){
        $('#ADD').prop('disabled', true);
        var key = $('#key').val();
        var value = $('#value').val();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/addSetting", 
            data: {_token:"{{csrf_token()}}", key:key , value:value }
        }).done(function(data){
            if(data['status'] == 0){
                $('#docs').append('<tr id="DIVOFDOC'+data['id']+'"> <td>'+key+'</td> <td>'+value+'</td> <td><button type="button" class="btn btn-sm btn-default" title="Edit"><i class="fa fa-edit"></i></button> <button type="button" onclick="deleteSetting('+data['id']+')" class="btn btn-sm btn-default js-sweetalert" title="Delete" ><i class="fa fa-trash-o text-danger"></i></button> </td> </tr>')
                $('#success').html(data['result'])
                $('#error').hide()
                $('#success').hide()
                $('#success').show('slow')
                $('#key').val('');
                $('#value').val('');
            }else{
                $('#error').html(data['error'])
                $('#error').hide()
                $('#error').show('slow')
            }
            $('#ADD').prop('disabled', false);
        });
    }
    function deleteSetting(id){
        $('#DIVOFDOC'+id).find('button').prop('disabled', true);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/deleteSetting", 
            data: {_token:"{{csrf_token()}}", id:id }
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
