<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Circle</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-md-4 col-lg-4">
                <div class="card mb-4">
                    @include('partials.errors')
                    <div class="card-header">Know your Twitter circle</div>
                    <div class="card-body">
                        <form action="{{ url('/generate') }}" method="post">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="username" class="form-label mb-2">Twitter username</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">@</span>
                                    <input id="username" name="username" required type="text" class="form-control" placeholder="Username" aria-label="Username">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Generate</button>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        @if(get_limit()->available)
                            <div class="text-center">{{ get_limit()->available }} slot is available</div>
                        @else
                            <div class="alert alert-warning text-center mb-0">
                                <p>There is no slots available</p>
                                <p class="mb-0">Next slot will be available after {{ get_limit()->available_after }} minutes</p>
                            </div>
                        @endif
                    </div>
                </div>
                <p class="text-center mt-5">Made with ❤️ by
                    <a href="https://twitter.com/saeedvaziry">Saeed Vaziry</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
