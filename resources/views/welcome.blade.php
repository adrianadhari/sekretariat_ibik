<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Institut Bisnis & Informatika Kesatuan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <nav class="bg-white">
        <div class="container py-5 mx-auto flex items-center space-x-5">
            <img src="{{ asset('images/logo.png') }}" alt="Logo IBIK" class="h-16">
            <h1 class="text-2xl font-semibold">Sekretariat IBIK</h1>
        </div>
    </nav>

    <div class="w-full flex flex-col justify-center items-center bg-center bg-no-repeat bg-cover min-h-[90vh]"
        style="background-image: url('{{ asset('images/building.jpg') }}')">

        <div class="container mx-auto flex flex-col items-center justify-center space-y-16 text-center">
            <h1 class="text-5xl font-bold text-[#8369ad] max-w-4xl">INSTITUT BISNIS & INFORMATIKA KESATUAN</h1>

            <a href="{{ filament()->getLoginUrl() }}" class="px-6 py-16 bg-white rounded-xl flex flex-col space-y-4 w-72  shadow-md hover:shadow-lg hover:scale-105 transition">
                <x-heroicon-o-building-office class="h-12 w-12 text-[#8369ad] mx-auto" />
                <p class="font-semibold text-xl text-[#8369ad]">Sekretariat IBIK</p>
                <p class="text-gray-400 font-medium">Login</p>
            </a>
        </div>

    </div>
</body>

</html>
