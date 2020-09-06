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
                                    <li class="breadcrumb-item active" aria-current="page">Categories</li>
                                    </ol>
                                </nav>
                            </div>            
                            
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                            <ul class="nav nav-tabs2">
                                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Services">Categories</a></li>
                                    <li class="nav-item"  onclick="$('#success').hide();$('#error').hide();"><a class="nav-link" data-toggle="tab" href="#addUser">Add Category</a></li>                
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
                                                <th>Category English</th>
                                                <th>Category Arabic</th>
                                                <th>Sub Category English</th>
                                                <th>Sub Category Arabic</th>
                                                <th>Date</th>
                                                <th class="w100">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableData">
                                            @if($Services)
                                            @foreach($Services as $Service)
                                            <tr id="DIVOFDOC{{$Service->id}}">
                        
                                                <td>
                                                    <h6 class="mb-0">{{$Service->category_english}}</h6>
                                                </td>
                                                <td>{{$Service->category_arabic}}</td>
                                                <td id="subEn{{$Service->id}}">
                                                    {{count($Service->subCategory_english)}}</td>
                                                    <input value="@foreach($Service->subCategory_english as $item){{$item . ','}}@endforeach" type="hidden" id="subEnArr{{$Service->id}}">
                                                <td id="subAr{{$Service->id}}">
                                                    {{count($Service->subCategory_arabic)}}</td>
                                                    <input value="@foreach($Service->subCategory_arabic as $item){{$item . ','}}@endforeach" type="hidden" id="subArArr{{$Service->id}}">
                                                <td >{{$Service->created_at}}</td>
                                                
                                                <td>
                                                    <button id="updateBtn{{$Service->id}}" onclick="openUpdateService('{{$Service->id}}')" type="button" class="btn btn-sm btn-default" title="Edit"><i class="fa fa-edit"></i></button>
                                                    </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>                
                                </div>
                            </div>
                            <div class="tab-pane" id="addUser">
                                <form  id="upload_form"  enctype="multipart/form-data" class="body mt-2">
                                    {{ csrf_field() }}
                                            <div class="row clearfix" id="inputs">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                
                                                <div class="form-group">
                                                        <label class="form-label">Category English</label>
                                                        <input name="category_english" type="text" class="form-control" placeholder="Category English">
                                                    </div>
                                                <div class="form-group">
                                                        <label class="form-label">Category Arabic</label>
                                                        <input name="category_arabic" type="text" class="form-control" placeholder="Category Arabic">
                                                    </div>                    
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
<button style="display: none" data-toggle="modal" id="view" data-target=".bd-example-modal-lg"></button>
<!-- Large modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="tab-content mt-0">
                            <div class="tab-pane active" id="addUser">
                                <form id="upload_form2" style="padding: 0px 18px 18px 18px;" enctype="multipart/form-data" class="body mt-2">
                                    {{csrf_field()}}
                                    
                                            <div class="row clearfix">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                                    <input type="text" name="subCategoryEn" class="form-control" placeholder="Sub Category English">
                                                                </div>  
                                                                <div class="form-group">  
                                                                <input type="text" name="subCategoryAr" class="form-control" placeholder="Sub Category Arabic">
                                                                </div>
                                                    <div class="col-12">
                                        <ul>
                                               <li style="color: green;display: none" id="success"></li> 
                                               <li style="color: red;display: none" id="error"></li>
                                           </ul>
                                            <button type="button" onclick="updateService()" id="updateBtn2" class="btn btn-primary">Save</button>
                                            <button type="button" id="closeEdit" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                        </div>            
                                                    <input type="hidden" id="service_id" name="category_id">
                                                        <div class="form-group">
                                                                <label class="form-label">Sub Category English</label>
                                                                <ul id="new_subEn">
                                                                </ul>
                                                            </div>
                                                            <div class="form-group">
                                                                    <label class="form-label">Sub Category Arabic</label>
                                                                  <ul id="new_subAr">
                                                                  </ul>
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
    var add = false
    function addService(){
        $('#ADD').prop('disabled', true);
        $.ajax({
            url: "/addCategory", 
            data: new FormData($("#upload_form")[0]) ,
            dataType:'json',
            type:'post',
            processData: false,
            contentType: false,
        }).done(function(data){
            if(data['status'] == 0){
            var HTML = '<tr> <td> <h6  class="mb-0">'+$("input[name='category_english']").val()+'</h6> </td> <td>'+$("input[name='category_arabic']").val()+'</td> <td>0</td><td>0</td><td>NOW</td><td><button id="updateBtn'+data['id']+'" onclick="openUpdateService('+"'"+data['id']+"'"+')" type="button" class="btn btn-sm btn-default" title="Edit"><i class="fa fa-edit"></i></button></td></tr>'
                $('#tableData').prepend(HTML)
                $('#success').html(data['result'])
                $('#error').hide()
                $('#success').hide()
                $('#success').show('slow')
                $("#inputs").find("input, select").val("");
                add = true
            }else{
                $('#error').html(data['error'])
                $('#error').hide()
                $('#error').show('slow')
            }
            $('#ADD').prop('disabled', false);
        });
    }
    function openUpdateService(id){
        if(add == true)
            location.reload()
        $('#DIVOFDOC'+id).find('button').prop('disabled', true);
        var new_subEn = ''
        var new_subAr = ''
        var sEn = $('#subEnArr'+id).val().split(',')
        var sAr = $('#subArArr'+id).val().split(',')
        for(var i = 0 ; i < (sEn.length - 1) ; i++){
            new_subEn += '<li>'+sEn[i]+'</li>'
            new_subAr += '<li>'+sAr[i]+'</li>'
    }
        $('#new_subEn').empty().append(new_subEn)
        $('#new_subAr').empty().append(new_subAr)
        $('#service_id').val(id)
        $("#view").click()

        $('#DIVOFDOC'+id).find('button').prop('disabled', false);
    }
    function updateService(){
        $('#updateBtn2').prop('disabled', true);
        var id = $('#service_id').val()
        $.ajax({
            url: "/addSubCategory", 
            data: new FormData($("#upload_form2")[0]) ,
            dataType:'json',
            type:'post',
            processData: false,
            contentType: false,
        }).done(function(data){
            if(data['status'] == 0){
                $('#subEn'+id).html(data['subEnCount'])
                $('#subAr'+id).html(data['subArCount'])
                $('#subEnArr'+id).val($('#subEnArr'+id).val() + $('input[name="subCategoryEn"]').val() + ',')
                $('#subArArr'+id).val($('#subArArr'+id).val() + $('input[name="subCategoryAr"]').val() + ',')
                $('#new_subEn').append($('input[name="subCategoryEn"]').val()+'<br>')
                $('#new_subAr').append($('input[name="subCategoryAr"]').val()+'<br>')
                $('input[name="subCategoryEn"]').val('')
                $('input[name="subCategoryAr"]').val('')
            }else{
                alert(data['error'])
            }
        $('#updateBtn2').prop('disabled', false);
        });
    }
</script>
</body>
</html>
