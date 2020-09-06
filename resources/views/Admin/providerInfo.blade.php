<!doctype html>
<html lang="en">

<head>
<title>Oculux | Profile</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, Provider-scalable=0">
<meta name="description" content="Oculux Bootstrap 4x admin is super flexible, powerful, clean &amp; modern responsive admin dashboard with unlimited possibilities.">
<meta name="author" content="GetBootstrap, design by: puffintheme.com">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../assets/vendor/animate-css/vivify.min.css">

<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">

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

<!-- Theme Setting -->
<div class="themesetting">
    <a href="javascript:void(0);" class="theme_btn"><i class="icon-magic-wand"></i></a>
    
    <div class="card theme_color">
        <div class="header">
            <h2>Theme Color</h2>
        </div>
        <ul class="choose-skin list-unstyled mb-0">
            <li data-theme="green"><div class="green"></div></li>
            <li data-theme="orange"><div class="orange"></div></li>
            <li data-theme="blush"><div class="blush"></div></li>
            <li data-theme="cyan" class="active"><div class="cyan"></div></li>
            <li data-theme="indigo"><div class="indigo"></div></li>
            <li data-theme="red"><div class="red"></div></li>
        </ul>
    </div>
    <div class="card font_setting">
        <div class="header">
            <h2>Font Settings</h2>
        </div>
        <div>
            <div class="fancy-radio mb-2">
                <label><input name="font" value="font-krub" type="radio"><span><i></i>Krub Google font</span></label>
            </div>
            <div class="fancy-radio mb-2">
                <label><input name="font" value="font-montserrat" type="radio" checked><span><i></i>Montserrat Google font</span></label>
            </div>
            <div class="fancy-radio">
                <label><input name="font" value="font-roboto" type="radio"><span><i></i>Robot Google font</span></label>
            </div>
        </div>
    </div>
    <div class="card setting_switch">
        <div class="header">
            <h2>Settings</h2>
        </div>
        <ul class="list-group">
            <li class="list-group-item">
                Light Version
                <div class="float-right">
                    <label class="switch">
                        <input type="checkbox" class="lv-btn" checked>
                        <span class="slider round"></span>
                    </label>
                </div>
            </li>
            <li class="list-group-item">
                RTL Version
                <div class="float-right">
                    <label class="switch">
                        <input type="checkbox" class="rtl-btn">
                        <span class="slider round"></span>
                    </label>
                </div>
            </li>
            <li class="list-group-item">
                Horizontal Henu
                <div class="float-right">
                    <label class="switch">
                        <input type="checkbox" class="hmenu-btn" >
                        <span class="slider round"></span>
                    </label>
                </div>
            </li>
            <li class="list-group-item">
                Mini Sidebar
                <div class="float-right">
                    <label class="switch">
                        <input type="checkbox" class="mini-sidebar-btn">
                        <span class="slider round"></span>
                    </label>
                </div>
            </li>
        </ul>
    </div>   
</div>

<!-- Overlay For Sidebars -->
<div class="overlay"></div>

<div id="wrapper">
@include('layouts/Admin/topNav')
    <div class="search_div">
        <div class="card">
            <div class="body">
                <form id="navbar-search" class="navbar-form search-form">
                    <div class="input-group mb-0">
                        <input type="text" class="form-control" placeholder="Search...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="icon-magnifier"></i></span>
                            <a href="javascript:void(0);" class="search_toggle btn btn-danger"><i class="icon-close"></i></a>
                        </div>
                    </div>
                </form>
            </div>            
        </div>
        <span>Search Result <small class="float-right text-muted">About 90 results (0.47 seconds)</small></span>
        <div class="table-responsive">
            <table class="table table-hover table-custom spacing5">
                <tbody>
                    <tr>
                        <td class="w40">
                            <span>01</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avtar-pic w35 bg-red" data-toggle="tooltip" data-placement="top" title="" data-original-title="Avatar Name"><span>SS</span></div>
                                <div class="ml-3">
                                    <a href="page-invoices-detail.html" title="">South Shyanne</a>
                                    <p class="mb-0">south.shyanne@example.com</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>02</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="../assets/images/xs/avatar2.jpg" data-toggle="tooltip" data-placement="top" title="" alt="Avatar" class="w35 h35 rounded" data-original-title="Avatar Name">
                                <div class="ml-3">
                                    <a href="javascript:void(0);" title="">Zoe Baker</a>
                                    <p class="mb-0">zoe.baker@example.com</p>
                                </div>
                            </div>                                        
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>03</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                    <div class="avtar-pic w35 bg-indigo" data-toggle="tooltip" data-placement="top" title="" data-original-title="Avatar Name"><span>CB</span></div>
                                <div class="ml-3">
                                    <a href="javascript:void(0);" title="">Colin Brown</a>
                                    <p class="mb-0">colinbrown@example.com</p>
                                </div>
                            </div>                                        
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>04</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avtar-pic w35 bg-green" data-toggle="tooltip" data-placement="top" title="" data-original-title="Avatar Name"><span>KG</span></div>
                                <div class="ml-3">
                                    <a href="javascript:void(0);" title="">Kevin Gill</a>
                                    <p class="mb-0">kevin.gill@example.com</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>05</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="../assets/images/xs/avatar5.jpg" data-toggle="tooltip" data-placement="top" title="" alt="Avatar" class="w35 h35 rounded" data-original-title="Avatar Name">
                                <div class="ml-3">
                                    <a href="javascript:void(0);" title="">Brandon Smith</a>
                                    <p class="mb-0">Maria.gill@example.com</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>06</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="../assets/images/xs/avatar6.jpg" data-toggle="tooltip" data-placement="top" title="" alt="Avatar" class="w35 h35 rounded" data-original-title="Avatar Name">
                                <div class="ml-3">
                                    <a href="javascript:void(0);" title="">Kevin Baker</a>
                                    <p class="mb-0">kevin.baker@example.com</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>07</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="../assets/images/xs/avatar2.jpg" data-toggle="tooltip" data-placement="top" title="" alt="Avatar" class="w35 h35 rounded" data-original-title="Avatar Name">
                                <div class="ml-3">
                                    <a href="javascript:void(0);" title="">Zoe Baker</a>
                                    <p class="mb-0">zoe.baker@example.com</p>
                                </div>
                            </div>                                        
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="megamenu" class="megamenu particles_js">
        <a href="javascript:void(0);" class="megamenu_toggle btn btn-danger"><i class="icon-close"></i></a>
        <div class="container">
            <div class="row clearfix">
                <div class="col-12">
                    <ul class="q_links">
                        <li><a href="app-inbox.html"><i class="icon-envelope"></i><span>Inbox</span></a></li>
                        <li><a href="app-chat.html"><i class="icon-bubbles"></i><span>Messenger</span></a></li>
                        <li><a href="app-calendar.html"><i class="icon-calendar"></i><span>Event</span></a></li>
                        <li><a href="page-profile.html"><i class="icon-user"></i><span>Profile</span></a></li>
                        <li><a href="page-invoices.html"><i class="icon-printer"></i><span>Invoice</span></a></li>
                        <li><a href="page-timeline.html"><i class="icon-list"></i><span>Timeline</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="row clearfix w_social3">
                <div class="col-lg-3 col-md-6">
                    <div class="card facebook-widget">
                        <div id="slider2" class="carousel slide" data-ride="carousel" data-interval="2000">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="icon"><i class="fa fa-facebook"></i></div>
                                    <div class="content">
                                        <div class="text">Like</div>
                                        <div class="number">10K</div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="icon"><i class="fa fa-facebook"></i></div>
                                    <div class="content">
                                        <div class="text">Comment</div>
                                        <div class="number">217</div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="icon"><i class="fa fa-facebook"></i></div>
                                    <div class="content">
                                        <div class="text">Share</div>
                                        <div class="number">78</div>
                                    </div>
                                </div>
                            </div>
                        </div>                                            
                    </div>
                </div>                                                    
                <div class="col-lg-3 col-md-6">
                    <div class="card google-widget">
                        <div id="slider2" class="carousel slide vert" data-ride="carousel" data-interval="2000">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="icon"><i class="fa fa-google"></i></div>
                                    <div class="content">
                                        <div class="text">Like</div>
                                        <div class="number">10K</div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="icon"><i class="fa fa-google"></i></div>
                                    <div class="content">
                                        <div class="text">Comment</div>
                                        <div class="number">217</div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="icon"><i class="fa fa-google"></i></div>
                                    <div class="content">
                                        <div class="text">Share</div>
                                        <div class="number">78</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card twitter-widget">
                        <div id="slider2" class="carousel slide" data-ride="carousel" data-interval="2000">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="icon"><i class="fa fa-twitter"></i></div>
                                    <div class="content">
                                        <div class="text">Followers</div>
                                        <div class="number">10K</div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="icon"><i class="fa fa-twitter"></i></div>
                                    <div class="content">
                                        <div class="text">Twitt</div>
                                        <div class="number">657</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card instagram-widget">
                        <div class="icon"><i class="fa fa-instagram"></i></div>
                        <div class="content">
                            <div class="text">Followers</div>
                            <div class="number">231</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-4 col-sm-12">
                    <div class="card w_card3">
                        <div class="body">
                            <div class="text-center"><i class="icon-picture text-info"></i>
                                <h4 class="m-t-25 mb-0">104 Picture</h4>
                                <p>Your gallery download complete</p>
                                <a href="javascript:void(0);" class="btn btn-info btn-round">Download now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card w_card3">
                        <div class="body">
                            <div class="text-center"><i class="icon-diamond text-success"></i>
                                <h4 class="m-t-25 mb-0">813 Point</h4>
                                <p>You are doing great job!</p>
                                <a href="javascript:void(0);" class="btn btn-success btn-round">Read now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card w_card3">
                        <div class="body">
                            <div class="text-center"><i class="icon-social-twitter text-primary"></i>
                                <h4 class="m-t-25 mb-0">3,756</h4>
                                <p>New Followers on Twitter</p>
                                <a href="javascript:void(0);" class="btn btn-primary btn-round">Find more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="particles-js"></div>
    </div>

    <div id="rightbar" class="rightbar">
        <div class="body">
            <ul class="nav nav-tabs2">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Chat-one">Chat</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Chat-list">List</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Chat-groups">Groups</a></li>
            </ul>
            <hr>
            <div class="tab-content">
                <div class="tab-pane vivify fadeIn delay-100 active" id="Chat-one">
                    <div class="slim_scroll">
                        <div class="chat_detail">
                            <ul class="chat-widget clearfix">
                                <li class="left float-left">
                                    <div class="avtar-pic w35 bg-pink"><span>KG</span></div>
                                    <div class="chat-info">       
                                        <span class="message">Hello, John<br>What is the update on Project X?</span>
                                    </div>
                                </li>
                                <li class="right">
                                    <img src="../assets/images/xs/avatar1.jpg" class="rounded" alt="">
                                    <div class="chat-info">
                                        <span class="message">Hi, Alizee<br> It is almost completed. I will send you an email later today.</span>
                                    </div>
                                </li>
                                <li class="left float-left">
                                    <div class="avtar-pic w35 bg-pink"><span>KG</span></div>
                                    <div class="chat-info">
                                        <span class="message">That's great. Will catch you in evening.</span>
                                    </div>
                                </li>
                                <li class="right">
                                    <img src="../assets/images/xs/avatar1.jpg" class="rounded" alt="">
                                    <div class="chat-info">
                                        <span class="message">Sure we'will have a blast today.</span>
                                    </div>
                                </li>
                            </ul>
                            <div class="input-group p-t-15">
                                <textarea rows="3" class="form-control" placeholder="Enter text here..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane vvivify fadeIn delay-100" id="Chat-list">
                    <ul class="right_chat list-unstyled mb-0">
                        <li class="offline">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <div class="avtar-pic w35 bg-red"><span>FC</span></div>
                                    <div class="media-body">
                                        <span class="name">Folisise Chosielie</span>
                                        <span class="message">offline</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="../assets/images/xs/avatar3.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Marshall Nichols</span>
                                        <span class="message">online</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <div class="avtar-pic w35 bg-red"><span>FC</span></div>
                                    <div class="media-body">
                                        <span class="name">Louis Henry</span>
                                        <span class="message">online</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <div class="avtar-pic w35 bg-orange"><span>DS</span></div>
                                    <div class="media-body">
                                        <span class="name">Debra Stewart</span>
                                        <span class="message">online</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="offline">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <div class="avtar-pic w35 bg-green"><span>SW</span></div>
                                    <div class="media-body">
                                        <span class="name">Lisa Garett</span>
                                        <span class="message">offline since May 12</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="../assets/images/xs/avatar5.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Debra Stewart</span>
                                        <span class="message">online</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="offline">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="../assets/images/xs/avatar2.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Lisa Garett</span>
                                        <span class="message">offline since Jan 18</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <div class="avtar-pic w35 bg-indigo"><span>FC</span></div>
                                    <div class="media-body">
                                        <span class="name">Louis Henry</span>
                                        <span class="message">online</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <div class="avtar-pic w35 bg-pink"><span>DS</span></div>
                                    <div class="media-body">
                                        <span class="name">Debra Stewart</span>
                                        <span class="message">online</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="offline">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <div class="avtar-pic w35 bg-info"><span>SW</span></div>
                                    <div class="media-body">
                                        <span class="name">Lisa Garett</span>
                                        <span class="message">offline since May 12</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                    </ul>
                </div>
                <div class="tab-pane vivify fadeIn delay-100" id="Chat-groups">
                    <ul class="right_chat list-unstyled mb-0">
                        <li class="offline">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <div class="avtar-pic w35 bg-cyan"><span>DT</span></div>
                                    <div class="media-body">
                                        <span class="name">Designer Team</span>
                                        <span class="message">offline</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <div class="avtar-pic w35 bg-azura"><span>SG</span></div>
                                    <div class="media-body">
                                        <span class="name">Sale Groups</span>
                                        <span class="message">online</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <div class="avtar-pic w35 bg-orange"><span>NF</span></div>
                                    <div class="media-body">
                                        <span class="name">New Fresher</span>
                                        <span class="message">online</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="offline">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <div class="avtar-pic w35 bg-indigo"><span>PL</span></div>
                                    <div class="media-body">
                                        <span class="name">Project Lead</span>
                                        <span class="message">offline since May 12</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

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
                        <h2>Provider Profile</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Oculux</a></li>
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Provider Profile</li>
                            </ol>
                        </nav>
                    </div>            
                    <div class="col-md-6 col-sm-12 text-right hidden-xs">
                        <button  id="approveBtn" onclick='approve({{basename((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]")}})' class="btn btn-primary btn-sm" @if($Provider->status == 'approved') disabled @endif>@if($Provider->status == 'approved') Approved @else Approve @endif</button>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card social">
                        <div class="profile-header d-flex justify-content-between justify-content-center">
                            <div class="d-flex">
                                <div class="mr-3">
                                    <img src="../assets/images/user.png" class="rounded" alt="">
                                </div>
                                <div class="details">
                                    <h5 class="mb-0">{{$Provider->first_name}} {{$Provider->last_name}}</h5>
                                    <span class="text-light">966 {{$Provider->mobile}}</span>
                                    <p class="mb-0"><span>Orders: <strong>{{$COMPLETED}}</strong></span> <span>Scheduled: <strong>{{$SCHEDULED}}</strong></span> <span>Cancelled: <strong>{{$CANCELLED}}</strong></span></p>
                                </div>                                
                            </div>
                            <div>
                            <button id="block" onclick="blockProvider('{{$provider_id}}')" @if($Provider->status == 'banned') disabled @endif class="btn btn-primary btn-sm">@if($Provider->status == 'banned') Blocked @else Block @endif</button>
                                <button class="btn btn-success btn-sm">Message</button>
                            </div>
                        </div>
                    </div>                    
                </div>               
                <div class="card">
                        <div class="header">
                            <h2>Provider Documents</h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                    <div class="table-responsive">
                                            <table class="table table-hover js-basic-example dataTable table-custom spacing5 mb-0">
                                                <thead>
                                                    <tr>
                                                        
                                                        <th>Id</th>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                        <th>Expiry Date</th>
                                                        <th>Action</th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($ProviderDocuments) > 0)
                                                    @foreach( $ProviderDocuments as $Document )
                                                    <tr id="DIVOFDOC{{$Document->id}}">
                                                        <td><span>{{$Document->id}}</span></td>
                                                        <td>{{$Document->doc_name}}</td>
                                                        <td class="static"><span id="status{{$Document->id}}" class="badge @if($Document->status == 'ACTIVE') badge-success @else badge-danger @endif ml-0 mr-0">{{$Document->status}}</span></td>
                                                        <td><input placeholder="Like : 2020-01-01" type="text" id="input{{$Document->id}}" value="{{$Document->expires_at}}"><button id="btnEx{{$Document->id}}" onclick="updateExpiry({{$Document->id}})">Save</button></td>
                                                        <td>
                                                                <button data-toggle="modal" data-target="#modal{{$loop->iteration}}" type="button" class="btn btn-sm btn-default " title="Print" data-toggle="tooltip" data-placement="top"><i class="icon-printer"></i></button>
                                                                <button onclick="deleteDocument('{{$Document->id}}')" type="button" class="btn btn-sm btn-default" title="Delete" data-toggle="tooltip" data-placement="top"><i class="icon-trash text-danger"></i></button>
                                                            </td>
<!-- Start Modal Box Image Viewer -->
<div class="col-lg-4 col-md-12 mb-4">
    <!--Modal: Name-->
    <div class="modal fade" id="modal{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-lg image-viewer" role="document">

        <!--Content-->
        <div class="modal-content">
            <img style="width: 100%;" src="https://api.tatx.com/{{$Document->url}}">
          <!--Footer-->
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-outline-primary btn-rounded btn-md ml-4" data-dismiss="modal">Close</button>

          </div>

        </div>
        <!--/.Content-->

      </div>
    </div>
  </div>
  <!-- End Modal Box Image Viewer -->

                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                </div>
                            </div>
                            <!-- <button type="button" class="btn btn-round btn-primary">Update</button> &nbsp;&nbsp;
                            <button type="button" class="btn btn-round btn-default">Cancel</button> -->
                        </div>
                <div class="col-xl-4 col-lg-4 col-md-5">
                    <div class="card">
                        <div class="header">
                            <h2>Info</h2>
                            <ul class="header-dropdown dropdown">                                
                                <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another Action</a></li>
                                        <li><a href="javascript:void(0);">Something else</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                                <small class="text-muted">Provider Sattus : </small>
                                <p style="display: block;width: 79px;" class="badge @if($Provider->provider_status == 'Online') badge-success @else badge-danger @endif ml-0 mr-0">{{$Provider->provider_status}}</p>
                                <hr>
                                <small class="text-muted">Service Status : </small>
                            <p id="status" style="display: block;width: 79px;" class="badge @if($Provider->status == 'approved') badge-success @else badge-danger @endif ml-0 mr-0">@if($Provider->status == 'approved'){{'APPROVED'}}@else {{$Provider->status}} @endif</p>
                            <hr>
                                <small class="text-muted">Rating : </small>
                                <p>{{$Provider->rating}}</p>                            
                            <hr>
                            <small class="text-muted">Email address : </small>
                            <p>{{$Provider->email}}</p>                            
                            <hr>
                            <small class="text-muted">Mobile: </small>
                            <p>+966 {{$Provider->mobile}}</p>
                            
                            <small class="text-muted">Provider Services : </small>
                            <div class="col-12">
                                
                                <ul class="list-group mb-3 tp-setting" id="ProviderService">
                                    @if(count($ProviderService) > 0)
                                    @foreach($ProviderService as $service)
                                    <li class="list-group-item">
                                        {{$service->name}}
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>

                            <small class="text-muted">SMART Services : </small>
                            <div class="col-12">
                                
                                <ul class="list-group mb-3 tp-setting" id="TOGGLE">
                                    @if(count($serviceTypeSmart) > 0)
                                    @foreach($serviceTypeSmart as $service)
                                    <li class="list-group-item">
                                        {{$service->name}}
                                        <div class="float-right">
                                            <label class="switch">
                                            <input id="status{{$service->id}}" onclick="changeSmartService('{{$service->id}}','{{$provider_id}}')" type="checkbox" @if($service->status == 'ON') checked @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8 col-lg-8 col-md-7">
                    <div class="card">
                        <div class="header">
                            <h2>Provider Service Type</h2>
                            <ul class="header-dropdown dropdown">                                
                                <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another Action</a></li>
                                        <li><a href="javascript:void(0);">Something else</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div id="Provider_Service" class="body">
                            <ul>
                                <span id="error" style="color:red"></span>
                                <span id="success" style="color:green"></span>
                            </ul>
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                    <select id="service" class="form-control">
                                                        <option value="">-- Select Service --</option>
                                                        @if(count($serviceType) > 0)
                                                        @foreach($serviceType as $service)
                                                        <option id="option{{$service->id}}" value="{{$service->id}}">{{$service->name}}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                        <div class="form-group">   
                                            <label >Model</label>                                             
                                            <input id="model" type="text" class="form-control" placeholder="Model">
                                        </div>
                                        <div class="form-group">   
                                            <label >Plate #</label>                                             
                                            <input id="plate" type="text" class="form-control" placeholder="Plate #">
                                        </div> 
                                    </div>
                                </div>
                                <button type="button" onclick="updateService()" class="btn btn-round btn-primary">Update</button> &nbsp;&nbsp;
                                <button type="button" class="btn btn-round btn-default">Cancel</button>
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

<script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="../assets/bundles/mainscripts.bundle.js"></script>
<script>
function deleteDocument(id){
        $('#DIVOFDOC'+id).find('button').prop('disabled', true);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/deleteProviderDocument", 
            data: {_token:"{{csrf_token()}}", id:id }
        }).done(function(data){   
            if(data['status'] == 0){
                if(data['result'] == 'ACTIVE'){
                    $("#status"+id).html('ACTIVE')
                    $('#status'+id).removeClass('badge-danger').addClass('badge-success');
                }else{
                    $("#status"+id).html('ASSESSING')
                    $('#status'+id).removeClass('badge-success').addClass('badge-danger');
                }
            }else{
                alert(data['error'])
            }
        $('#DIVOFDOC'+id).find('button').prop('disabled', false);
        });
    }
function changeSmartService(service_id,provider_id){
    $('#TOGGLE').find('input').prop('disabled', true);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/changeSmartService", 
            data: {_token:"{{csrf_token()}}", service_id:service_id , provider_id:provider_id }
        }).done(function(data){ 
            if(data['status'] == 0){
                if(data['result'] == 'ON'){
                    $("#status"+service_id).prop('checked', true);
                }else{
                    $("#status"+service_id).prop('checked', false);
                }
            }else{
                alert(data['error'])
            }
        $('#TOGGLE').find('input').prop('disabled', false);
        });
} 
function updateService(){
    $('#Provider_Service').find('input').prop('disabled', true);
    var service_id  =  $("#service").val()
    var model       =  $("#model").val()
    var plate       =  $("#plate").val()
    var service_name = $("#option"+service_id).html()
    $.ajax({
            type: "POST",
            dataType: "json",
            url: "/updateService", 
            data: {_token:"{{csrf_token()}}", service_type_id:service_id 
            , service_model:model ,service_number:plate , provider_id: "{{$provider_id}}" }
        }).done(function(data){ 
            if(data['status'] == 0){
                $('#success').html(data['result'])
                $('#error').hide()
                $('#success').hide()
                $('#success').show('slow')
                $('#Provider_Service').find("input, select").val("");
                $('#ProviderService').append('<li class="list-group-item">'+service_name+'</li>')
            }else{
                $('#success').hide()
                $('#error').html(data['error'])
                $('#error').hide()
                $('#error').show('slow')
            }
        $('#Provider_Service').find('input').prop('disabled', false);
        });

}   
function blockProvider(id){
    $('#block').prop('disabled', true);
    $.ajax({
            type: "POST",
            dataType: "json",
            url: "/blockProvider", 
            data: {_token:"{{csrf_token()}}", provider_id:id  }
        }).done(function(data){ 
            if(data['status'] == 0){
                $('#block').html('Blocked')
                $('#status').html('BANNED')
                $("#status").toggleClass("badge-danger");
                $("#status").toggleClass("badge-success");
                $('#approveBtn').html('Approve')
                $('#approveBtn').prop('disabled', false);
                return 0;
            }else{
                alert(data['error'])
            }
        $('#block').prop('disabled', false);
        });
}
function updateExpiry(id){
    $('#btnEx'+id).prop('disabled', true);
    var expires_at = $('#input'+id).val()
    $.ajax({
            type: "POST",
            dataType: "json",
            url: "/updateExpiry", 
            data: {_token:"{{csrf_token()}}",  expires_at:expires_at , id:id }
        }).done(function(data){ 
            if(data['status'] == 0){
                alert('Updated Successfully')
            }else{
                alert(data['error'])
            }
            $('#btnEx'+id).prop('disabled', false);
        });
}
function approve(provider_id){
    var status = $('#status').html()
    if(status == 'APPROVED')
        return 0;
    $('#approveBtn').prop('disabled', true);
    $.ajax({
            type: "POST",
            dataType: "json",
            url: "/approveProvider", 
            data: {_token:"{{csrf_token()}}", provider_id:provider_id }
        }).done(function(data){ 
            if(data['status'] == 0){
                $('#block').prop('disabled', false);
                $('#block').html('Block')
                $('#status').html('APPROVED')
                $("#status").toggleClass("badge-danger");
                $("#status").toggleClass("badge-success");
                $('#approveBtn').html('Approved')
                return 0;
            }else{
                alert(data['error'])
            }
            $('#approveBtn').prop('disabled', false);
        });
}
</script>
</body>
</html>