<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 relative overflow-hidden">
    <!-- Abstract Shapes Background -->
    <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
    <div class="absolute top-0 -right-4 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>

    <div class="relative z-10 mb-8 transform hover:scale-105 transition duration-300">
        {{ $logo }}
    </div>

    <div class="relative z-10 w-full sm:max-w-md px-10 py-10 bg-white/90 backdrop-blur-lg border border-white/20 shadow-2xl overflow-hidden sm:rounded-2xl">
        {{ $slot }}
    </div>
</div>
