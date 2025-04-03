<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body>
    <div class="container-login">
        <div class="card-login">
            <div class="bg-image">
                <img src="{{ asset('img/custom_background.png') }}" alt="">
            </div>
            <div class="authentication">

                <div class="flex flex-col gap-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
    @fluxScripts
</body>

</html>
