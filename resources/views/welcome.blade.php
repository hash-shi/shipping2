<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;600&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer>
    </script>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
    <link rel="icon" sizes="32x32" href="/images/favicon.ico">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <title>{{env('APP_NAME')}}</title>
</head>
<body>
    <div id="app">
        <app></app>
    </div>

    <div id="waitBackground" style='position:fixed;width:100%;height:100%;left:0;top:0;background-color:#000000;opacity:0.8;z-index:111100;display:none;'>
            <img src="/images/loading.gif" style="width:150px;position:fixed;left:50%;top:50%;transform: translate(-50%, -50%);">
    </div>

</body>
</html>
