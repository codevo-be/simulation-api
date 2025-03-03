<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <style>
        @page {
            margin: 40px;
            size: A4 portrait;
        }

        .page-break {
            page-break-before: always;
            margin-top: -20px;
        }

        .avoid-page-break {
            page-break-inside: avoid;
        }

        body{
            padding:0;
            margin:0;
            font-family: sans-serif;
            font-weight: 400;
            font-style: normal;
        }
        p, h1,h2,h3,h4,h5,h6{
            font-size: 18px;
            margin:0;
            line-height: 1.5;
        }

        table{
            text-align: left;
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
<main>
    @yield('content')
</main>
</body>
</html>
