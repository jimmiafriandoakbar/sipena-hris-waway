<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pegawai - SIPENA</title>
    @vite('resources/css/app.css')

    <style>
@media print {

    @page {
        size: A4;
        margin: 25mm 20mm;
    }

    body {
        font-family: Arial, sans-serif;
        color: #000;
    }

    /* SEMBUNYIKAN SEMUA */
    body * {
        display: none !important;
    }

    /* TAMPILKAN HANYA PRINT AREA */
    #printArea, #printArea * {
        display: block !important;
    }

    #printArea {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }

}
</style>
</head>

<body class="bg-gray-100">

    <div class="flex">

        <!-- SIDEBAR -->
        @include('layouts.pegawai.sidebar')

        <!-- CONTENT -->
        <main class="ml-64 p-6 w-full">
            @yield('content')
        </main>

    </div>

    <!-- 🔥 TARUH DI SINI -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>

</body>

</html>