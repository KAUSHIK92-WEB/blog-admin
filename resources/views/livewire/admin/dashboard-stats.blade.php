<div>
    <div class="p-6 lg:p-8 bg-white border-b border-gray-200 shadow-sm rounded-t-lg">
        <h1 class="mt-2 text-2xl font-medium text-gray-900">
            Welcome back, {{ auth()->user()->name }}!
        </h1>
        <p class="mt-2 text-gray-500 leading-relaxed">
            Here is a quick overview of the current blog activity.
        </p>
    </div>

    <div class="bg-gray-100 bg-opacity-50 grid grid-cols-1 md:grid-cols-2 gap-6 p-6 lg:p-8 rounded-b-lg">
        @if(auth()->user()->role === 'admin')
            <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6 border border-gray-100 transition duration-150 transform hover:scale-105">
                <div class="flex items-center text-indigo-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    <h2 class="ms-3 text-xl font-semibold text-gray-900">Total Blogs</h2>
                </div>
                <p class="mt-4 text-gray-900 text-4xl font-black">
                    {{ $totalPosts }}
                </p>
            </div>
            
            <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6 border border-gray-100 transition duration-150 transform hover:scale-105">
                <div class="flex items-center text-teal-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <h2 class="ms-3 text-xl font-semibold text-gray-900">Total Authors</h2>
                </div>
                <p class="mt-4 text-gray-900 text-4xl font-black">
                    {{ $totalAuthors }}
                </p>
            </div>
        @else
            <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6 border border-gray-100 transition duration-150 transform hover:scale-105">
                <div class="flex items-center text-indigo-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    <h2 class="ms-3 text-xl font-semibold text-gray-900">My Blogs</h2>
                </div>
                <p class="mt-4 text-gray-900 text-4xl font-black">
                    {{ $myPosts }}
                </p>
            </div>
        @endif
    </div>
</div>
