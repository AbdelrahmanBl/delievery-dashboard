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
                                    <li class="breadcrumb-item active" aria-current="page">Services Types</li>
                                    </ol>
                                </nav>
                            </div>            
                            
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                            <ul class="nav nav-tabs2">
                                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Services">Services Types</a></li>
                                    <li class="nav-item"  onclick="$('#success').hide();$('#error').hide();"><a class="nav-link" data-toggle="tab" href="#addUser">Add Service</a></li>                
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
                                                <th class="w60">Icon</th>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Capacity</th>
                                                <th>Base Price</th>
                                                <th>Price / Min</th>
                                                <th>Price / KM</th>
                                                <th>Status</th>
                                                <th class="w100">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($Services)
                                            @foreach($Services as $Service)
                                            <tr id="DIVOFDOC{{$Service->id}}">
                                                <td class="width45">
                                                    <div class="avtar-pic w35 bg-pink" data-toggle="tooltip" data-placement="top" title="{{$Service->name}}"><span><img width="100%" id="image{{$Service->id}}" src="{{$Service->image}}"></span></div>
                                                </td>
                                                <td>
                                                    <h6 id="name{{$Service->id}}" class="mb-0">{{$Service->name}}</h6>
                                                    <span>{{$Service->description}}</span>
                                                </td>
                                                <td id="type{{$Service->id}}">{{$Service->type}}</td>
                                                <td id="capacity{{$Service->id}}">{{$Service->capacity}}</td>
                                                <td id="price_fixed{{$Service->id}}">{{$Service->price_fixed}}</td>
                                                <td id="price_minute{{$Service->id}}">{{$Service->price_minute}}</td>
                                                <td id="price_distance{{$Service->id}}">{{$Service->price_distance}}</td>
                                                <td><span id="status{{$Service->id}}" class="badge @if($Service->status == 1) badge-success @else badge-danger @endif ml-0 mr-0">{{($Service->status == 1) ? 'AVAILABLE': 'LOCKED' }}</span></td>
                                                <td>
                                                        <button id="updateBtn{{$Service->id}}" onclick="openUpdateService('{{$Service->id}}')" type="button" class="btn btn-sm btn-default" title="Edit"><i class="fa fa-edit"></i></button>
                                                        <button onclick="deleteService('{{$Service->id}}')" type="button" class="btn btn-sm btn-default js-sweetalert" title="Delete" ><i class="fa fa-trash-o text-danger"></i></button>
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
                                        <div class="user_div">
                                               <img style="max-width: 100px; min-width: 100px; max-height: 100px; min-height: 100px;" id="addImage" src="" class="user-photo" alt="User Profile Picture">  
                                                <div class="form-group mt-3 mb-5">
                                                        <input onchange="readURL(this,'addImage')" name="image" type="file" class="dropify">
                                                    </div>
                                            </div>
                                            <div class="row clearfix">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                    <label class="form-label">Service Type</label>
                                                    <select name="type" class="form-control">
                                                            <option value="">-- Select Type --</option>
                                                            <option value="DRIVER">DRIVER</option>
                                                            <option value="VEHICLE">VEHICLE</option>
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                        <label class="form-label">Service Name</label>
                                                        <input name="name" type="text" class="form-control" placeholder="Service Name">
                                                    </div>
                                                <div class="form-group">
                                                        <label class="form-label">Service Descriptions</label>
                                                        <input name="description" type="text" class="form-control" placeholder="Service Descriptions">
                                                    </div>
                                                    
                                                        <div class="form-group">
                                                                <label class="form-label">Base Price</label>
                                                                <input name="price_fixed" type="text" class="form-control" placeholder="Base Price">
                                                            </div>
                                                            <div class="form-group">
                                                                    <label class="form-label">Price / KM</label>
                                                                    <input name="price_distance" type="text" class="form-control" placeholder="Price / KM">
                                                                </div>
                                                                <div class="form-group">
                                                                        <label class="form-label">Price / MIN</label>
                                                                        <input name="price_minute" type="text" class="form-control" placeholder="Price / MIN">
                                                                    </div>
                                                                    <div class="form-group">
                                                                            <label class="form-label">Capacity</label>
                                                                            <input name="capacity" type="text" class="form-control" placeholder="Capacity">
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
                                    <img id="viewImage" style="max-width: 100px; min-width: 100px; max-height: 100px; min-height: 100px;" src="">
                                        <div class="user_div">
                                               <!-- <img  src="../assets/images/user.png" class="user-photo" alt="User Profile Picture">  -->
                                                <div class="form-group mt-3 mb-5">
                                                        <input id="uploadImage" onchange="readURL(this,'viewImage')" name="image" type="file" class="dropify">
                                                    </div>
                                            </div>
                                            <div class="row clearfix">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                    <label class="form-label">Service Type</label>
                                                    <select id="new_type" name="type" class="form-control">
                                                            <option value="">-- Select Type --</option>
                                                            <option value="DRIVER">DRIVER</option>
                                                            <option value="VEHICLE">VEHICLE</option>
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                        <label class="form-label">Service Name</label>
                                                        <input id="new_name" name="name" type="text" class="form-control" placeholder="Service Name">
                                                    </div>
                                                <!-- <div class="form-group">
                                                        <label class="form-label">Service Descriptions</label>
                                                        <input id="new_description" name="description" type="text" class="form-control" placeholder="Service Descriptions">
                                                    </div> -->
                                                    <input type="hidden" id="service_id" name="service_id">
                                                        <div class="form-group">
                                                                <label class="form-label">Base Price</label>
                                                                <input id="new_price_fixed" name="price_fixed" type="text" class="form-control" placeholder="Base Price">
                                                            </div>
                                                            <div class="form-group">
                                                                    <label class="form-label">Price / KM</label>
                                                                    <input id="new_price_distance" name="price_distance" type="text" class="form-control" placeholder="Price / KM">
                                                                </div>
                                                                <div class="form-group">
                                                                        <label class="form-label">Price / MIN</label>
                                                                        <input id="new_price_minute" name="price_minute" type="text" class="form-control" placeholder="Price / MIN">
                                                                    </div>
                                                                    <div class="form-group">
                                                                            <label class="form-label">Capacity</label>
                                                                            <input id="new_capacity" name="capacity" type="text" class="form-control" placeholder="Capacity">
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
    function addService(){
        $('#ADD').prop('disabled', true);
        $.ajax({
            url: "/addService", 
            data: new FormData($("#upload_form")[0]) ,
            dataType:'json',
            type:'post',
            processData: false,
            contentType: false,
        }).done(function(data){
            if(data['status'] == 0){
                location.reload()
            }else{
                $('#error').html(data['error'])
                $('#error').hide()
                $('#error').show('slow')
                $('#ADD').prop('disabled', false);
            }
            
        });
    }
    function deleteService(id){
        $('#DIVOFDOC'+id).find('button').prop('disabled', true);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/deleteService", 
            data: {_token:"{{csrf_token()}}", id:id }
        }).done(function(data){
            if(data['status'] == 0){
                if(data['result'] == 'LOCKED'){
                $('#status'+id).html('LOCKED')
                $('#status'+id).removeClass('badge-success').addClass('badge-danger');
                }
                else{ 
                    $('#status'+id).html('AVAILABLE')
                    $('#status'+id).removeClass('badge-danger').addClass('badge-success');
                }
            }else{
                alert(data['error'])
            }
        $('#DIVOFDOC'+id).find('button').prop('disabled', false);
        });
    }
    function openUpdateService(id){
        $('#DIVOFDOC'+id).find('button').prop('disabled', true);
        var name            = $('#name'+id).html()
        var type            = $('#type'+id).html()
        var capacity        = $('#capacity'+id).html()
        var price_fixed     = $('#price_fixed'+id).html()
        var price_minute    = $('#price_minute'+id).html()
        var price_distance  = $('#price_distance'+id).html()

        $('#viewImage').attr("src", $('#image'+id).attr('src') );
        $('#uploadImage').val('')
        $('#new_name').val(name)
        $('#new_type').val(type)
        $('#new_capacity').val(capacity)
        $('#new_price_fixed').val(price_fixed)
        $('#new_price_minute').val(price_minute)
        $('#new_price_distance').val(price_distance)
        $('#service_id').val(id)
        $("#view").click()

        $('#DIVOFDOC'+id).find('button').prop('disabled', false);
    }
    function updateService(){
        $('#updateBtn2').prop('disabled', true);
        var id = $('#service_id').val()
        $.ajax({
            url: "/resetService", 
            data: new FormData($("#upload_form2")[0]) ,
            dataType:'json',
            type:'post',
            processData: false,
            contentType: false,
        }).done(function(data){
            if(data['status'] == 0){
                if(data['url'] != null){
                    d = new Date();
                    $("#image"+id).attr("src", data['url']+"?"+d.getTime());
                }
                $('#name'+id).html($('#new_name').val())
                $('#type'+id).html($('#new_type').val())
                $('#capacity'+id).html($('#new_capacity').val())
                $('#price_fixed'+id).html($('#new_price_fixed').val())
                $('#price_minute'+id).html($('#new_price_minute').val())
                $('#price_distance'+id).html($('#new_price_distance').val())
                $('#closeEdit').click()
            }else{
                alert(data['error'])
            }
        $('#updateBtn2').prop('disabled', false);
        });
    }
    function readURL(input,image) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#'+image).attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}
</script>
</body>
</html>
