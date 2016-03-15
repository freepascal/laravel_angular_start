<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="libs/jquery-2.2.0.js"></script>
    <script src="libs/bootstrap.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js"></script>
    <script src="libs/angular-route.js"></script>
    <script src="libs/angular-cookies.js"></script>
    <script src="ng-flow-standalone.min.js"></script>
    <script src="src/app.js"></script>
</head>
<body>
    <div class="container">
        @if (session('message'))
            <div class="alert alert-{{ session('message')['type'] }}">{{ session('message')['text'] }}</div>
        @endif
    </div>
    @yield('content')
</body>
</html>
