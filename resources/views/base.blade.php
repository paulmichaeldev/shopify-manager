<!doctype html>
<html>
    <head>
        <script src="/js/jquery.min.js"></script>
        <script src="/js/dropzone.js"></script>
        <script src="/js/main.js"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous" />

        <link rel="stylesheet" href="/css/main.css" />
        <link rel="stylesheet" href="/css/dropzone.css" />

        <meta name="csrf-token" content="{{ csrf_token() }}" />
    </head>

    <body>
        @yield('content')
    </body>

</html>