<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link class="favicon" rel="icon" type="image/png" href="{{$logo}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link href="{{asset("public/css/app.css")}}" rel="stylesheet" />
    <script src="{{asset("public/js/app.js")}}" defer></script>
    @routes
    <script>
        var lang = "{{app()->getLocale()}}";
        var lang_to_vue = @json(all_lang());
    </script>
</head>
<body>
@inertia
</body>
</html>
