
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Partner Dashboard</title>
        <!-- Favicons -->
		<link href="<?php echo e(asset('assets/img/favicon.png')); ?>" rel="icon">

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <style type="text/css">
    	 html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .code {
                border-right: 2px solid;
                font-size: 26px;
                padding: 0 15px 0 15px;
                text-align: center;
            }

            .message {
                font-size: 18px;
                text-align: center;
            }
            .btn{
            	height: 40px;
    			width: 90px;
    			outline: none;
    			border: none;
    			cursor: pointer;
    			color: #fdfdfd;
    			background-color: #009688;
    			transition: .3s all ease-in-out;
    			-webkit-transition: .3s all ease-in-out;
    			-moz-transition: .3s all ease-in-out;
            }
            .btn:hover{
            	background-color: #0f675f;
            }
    </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="code">
                404            </div>

            <div class="message" style="padding: 10px;">
                Not Found            </div>
                <button class="btn" onclick="history.back(-1)">Back</button>
        </div>
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\Admin\resources\views/404.blade.php ENDPATH**/ ?>