<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Random Login Form</title>


    <!---->
    <!--/* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */-->
    <!--/*@import url(https://fonts.googleapis.com/css?family=Exo:100,200,400);*/-->
    <!--/*@import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:700,400,300);*/-->


    <!--&lt;!&ndash;<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>&ndash;&gt;-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body>
<div class="body"></div>
<div class="grad"></div>
<br>

<div class="col-xs-2"  width="20%" height="20%" >
    <img src="{{ asset('images/logo.jpg') }}" >
</div>
<div class="login">
    <div class="col-xs-9 ">
        @yield('content')
    </div>

</div>
</body>
</html>