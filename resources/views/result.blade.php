<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Circle</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="wrapper">
        <div class="image-container">
            <img src="{{ str_replace('normal', '400x400', $currentUser['profile_image_url_https']) }}" class="img" alt="" style="border-radius: 100%;">
            @foreach($users as $key => $user)
                <img src="{{ $user['avatar'] }}" style="border-radius: 100%;" alt="" class="img @if($key >= 0 && $key <= 7) img-1 @elseif($key >= 8 && $key <= 23) img-2 @elseif($key >= 24 && $key <= 51) img-3 @endif">
            @endforeach
            <a class="brand" href="{{ url('/') }}">circle.ibio.link</a>
        </div>
        @if($fromCache)
            <div class="text-center my-2">These data have been loaded from our cache. We keep These data for only one day</div>
        @endif
    </div>
</body>
</html>
