<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPENA-WAWAY - Login</title>
    <link rel="icon" type="image/png" href="{{ asset('Logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="min-h-screen xl:h-screen flex overflow-x-hidden xl:overflow-hidden
    bg-gradient-to-br from-[#0b1120] via-[#1e1b4b] to-[#2563eb] relative">

    <!-- BACKGROUND GLOW -->
    <div
        class="absolute w-[600px] h-[600px]
        bg-cyan-400/20 rounded-full blur-3xl
        top-[-250px] left-[-250px] animate-pulse">
    </div>

    <div
        class="absolute w-[500px] h-[500px]
        bg-fuchsia-500/20 rounded-full blur-3xl
        bottom-[-200px] right-[-200px] animate-pulse">
    </div>

    <!-- GRID -->
    <div
        class="absolute inset-0 opacity-10"
        style="
        background-image:
        linear-gradient(rgba(255,255,255,.08) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.08) 1px, transparent 1px);
        background-size: 40px 40px;">
    </div>

    <!-- LEFT SIDE DESKTOP ONLY -->
    <div
        class="hidden xl:flex xl:w-1/2 relative z-10
        p-16 flex-col justify-center text-white">

        <div class="absolute top-10 left-10">
            <a href="#"
                class="px-5 py-2 rounded-full
                bg-white/10 border border-white/20 backdrop-blur-xl
                shadow-xl text-sm font-medium">
                Website HRIS-WAWAY
            </a>
        </div>

        <div class="max-w-xl">

            <div
                class="w-28 h-28 rounded-[30px]
                bg-white/10 border border-white/20 backdrop-blur-2xl
                flex items-center justify-center
                shadow-[0_10px_40px_rgba(0,0,0,0.3)]
                mb-8">

                <img src="{{ asset('Logo.png') }}"
                    class="w-20"
                    alt="Logo">
            </div>

            <h1 class="text-6xl font-black leading-tight mb-6">
                HRIS
                <span class="bg-gradient-to-r from-cyan-300 to-fuchsia-400 bg-clip-text text-transparent">
                    BANK WAWAY
                </span>
            </h1>

            <p class="text-lg leading-relaxed text-white/75 mb-8">
                HRIS BANK WAWAY adalah sistem informasi kepegawaian di
                PT BPR WAWAY LAMPUNG yang digunakan untuk memudahkan
                pengelolaan data karyawan, absensi, cuti, dan administrasi
                SDM secara lebih cepat, terintegrasi, dan efisien.
            </p>

            <div class="grid grid-cols-2 gap-5">

                <div
                    class="p-5 rounded-3xl
                    bg-white/10 border border-white/10 backdrop-blur-xl">

                    <h3 class="font-semibold text-lg mb-2">
                        Digital System
                    </h3>

                    <p class="text-sm text-white/70">
                        Pengelolaan surat modern & realtime.
                    </p>
                </div>

                <div
                    class="p-5 rounded-3xl
                    bg-white/10 border border-white/10 backdrop-blur-xl">

                    <h3 class="font-semibold text-lg mb-2">
                        Secure Access
                    </h3>

                    <p class="text-sm text-white/70">
                        Hak akses aman sesuai jabatan.
                    </p>
                </div>

            </div>

        </div>

    </div>

    <!-- RIGHT SIDE LOGIN -->
    <div
        class="w-full xl:w-1/2 min-h-screen xl:h-screen
        relative z-10
        flex items-center justify-center
        px-5 py-6 xl:p-0">

        <!-- LOGIN CARD -->
        <div
            class="w-full max-w-[430px] my-auto
            rounded-[28px] xl:rounded-[36px]
            bg-white/10 border border-white/20 backdrop-blur-3xl
            p-5 sm:p-6 xl:p-10
            text-white
            shadow-[0_15px_60px_rgba(0,0,0,0.35)]">

            <!-- HEADER -->
            <div class="text-center mb-5 xl:mb-8">

                <div
                    class="w-16 h-16 xl:w-20 xl:h-20 mx-auto mb-4 xl:mb-5
                    rounded-2xl xl:rounded-3xl
                    bg-white/10 border border-white/20 backdrop-blur-xl
                    flex items-center justify-center">

                    <img src="{{ asset('Logo.png') }}"
                        class="w-12 xl:w-16"
                        alt="Logo">
                </div>

                <h2 class="text-3xl xl:text-4xl font-bold mb-2">
                    Welcome Back
                </h2>

                <p class="text-white/70 text-sm xl:text-base">
                    Login ke sistem HRIS-BANK WAWAY
                </p>

            </div>

            @if ($errors->any())
                <div
                    class="mb-4 rounded-2xl border border-red-200
                    bg-red-50 px-5 py-4 text-sm text-red-700
                    shadow-sm">

                    <div class="flex items-start gap-3">
                        <div class="text-lg">⚠</div>
                        <div>
                            <div class="font-semibold mb-1">
                                Login Gagal
                            </div>
                            <div>
                                Email atau password salah.
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST"
                action="{{ route('login') }}"
                class="space-y-4 xl:space-y-5">

                @csrf

                <div>
                    <label class="text-sm text-white/80">
                        Username
                    </label>

                    <input
                        type="text"
                        name="email"
                        placeholder="Enter username"
                        class="w-full h-12 xl:h-14 mt-2 px-5 rounded-2xl
                        bg-white/10 border border-white/20
                        text-white placeholder:text-white/40
                        backdrop-blur-xl
                        focus:outline-none focus:ring-4 focus:ring-cyan-400/30">
                </div>

                <div>
                    <label class="text-sm text-white/80">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Enter password"
                        class="w-full h-12 xl:h-14 mt-2 px-5 rounded-2xl
                        bg-white/10 border border-white/20
                        text-white placeholder:text-white/40
                        backdrop-blur-xl
                        focus:outline-none focus:ring-4 focus:ring-fuchsia-400/30">
                </div>

                <div class="flex items-center justify-between gap-3 text-sm">

                    <label class="flex items-center gap-2 text-white/70 whitespace-nowrap">
                        <input type="checkbox"
                            class="rounded border-white/20 bg-white/10">
                        Remember me
                    </label>

                    <a href="{{ route('password.request') }}"
                        class="text-cyan-300 hover:text-white transition whitespace-nowrap">
                        Forgot Password?
                    </a>

                </div>

                <button
                    type="submit"
                    class="w-full h-12 xl:h-14 rounded-2xl
                    bg-gradient-to-r from-cyan-400 via-blue-500 to-fuchsia-500
                    font-semibold text-lg
                    hover:scale-[1.02]
                    transition duration-300
                    shadow-[0_10px_40px_rgba(99,102,241,0.45)]">
                    Sign In
                </button>

            </form>

        </div>

    </div>

</body>
</html>