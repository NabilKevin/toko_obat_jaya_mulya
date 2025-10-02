@extends('admin.layouts.app')

@section('title', 'Data User - Toko Obat Jaya Mulya')
@section('page-title', 'Data User')

@section('content')
<!-- Added mobile-responsive padding and layout optimizations -->
@if(session('success'))
    <div class="alert absolute p-4 bg-green-700/50 text-green-500 border rounded-md border-green-600 text-center top-[12%] left-1/2 -translate-x-1/2 z-50 alertAnimate">
        {{ session('success') ?? 'Berhasil!' }}
    </div>
@endif

<div class="p-3 sm:p-4 lg:p-6 space-y-4 sm:space-y-6">
    <!-- Made header responsive with mobile-friendly button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div class="space-y-1 sm:space-y-2">
            <h1 class="text-2xl sm:text-3xl font-bold text-foreground">Data User</h1>
            <p class="text-sm sm:text-base text-muted-foreground">Kelola data pengguna sistem</p>
        </div>
        <button onclick="window.location.href='{{ route('admin.user.create') }}'" id="createUser"
                class="group relative bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 sm:px-8 py-3 sm:py-3.5 rounded-xl shadow-lg hover:shadow-2xl ring-1 ring-success/20 transition-all duration-300 flex items-center justify-center font-semibold text-sm transform hover:scale-105 hover:-translate-y-0.5 w-full sm:w-auto min-h-[48px] active:scale-95">
            <span class="relative z-10">Tambah User</span>
        </button>
    </div>

    <!-- Made search container mobile responsive -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <!-- CHANGE> Added search button next to search input -->
            <form class="flex space-x-3" action="{{ route('admin.user.index') }}">
                <div class="relative flex-1">
                    <input type="text"
                            name="search"
                            value="{{ $search }}"
                            id="search"
                            placeholder="Cari user berdasarkan nama atau username..."
                            class="w-full px-4 py-3 pl-12 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm sm:text-base min-h-[48px]">
                    <i data-lucide="search" class="absolute left-4 top-1/2 transform -translate-y-1/2 h-5 w-5 text-muted-foreground"></i>
                </div>
                <button type="submit" class="group relative bg-muted hover:bg-muted/80 border border-border text-foreground px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center font-semibold text-sm transform hover:scale-105 hover:-translate-y-0.5 min-h-[48px] active:scale-95">
                    <span class="hidden sm:inline relative z-10">Cari</span>
                    <i data-lucide="search" class="inline sm:hidden relative z-10"></i>
                </button>
                <button onclick="document.querySelector('#search').value = ''; input.closest('form').submit();" class="group relative bg-danger hover:bg-danger/80 border border-border text-foreground px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center font-semibold text-sm transform hover:scale-105 hover:-translate-y-0.5 min-h-[48px] active:scale-95">
                    <span class="hidden sm:inline relative z-10">Clear</span>
                    <i data-lucide="x" class="inline sm:hidden relative z-10"></i>
                </button>
            </form>
        </div>

        <!-- Made table responsive with horizontal scroll and mobile card layout -->
        <div class="overflow-x-auto">
            <!-- Desktop Table View -->
            <div class="hidden lg:block">
            @if (count($users) === 0)
                <h1 class="my-4 font-medium text-2xl text-foreground text-center">Tidak ada data user!</h1>
            @endif
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th class="text-left py-4 px-6 text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Username</th>
                            <th class="text-left py-4 px-6 text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                            <th class="text-left py-4 px-6 text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Role</th>
                            <th class="text-left py-4 px-6 text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors duration-150">
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-md">
                                            <i data-lucide="user" class="h-5 w-5 text-white"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $user['username'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-sm text-gray-900 dark:text-gray-100">{{ $user['nama'] }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $roleColors[$user['role']] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $user['role'] }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex space-x-2">
                                        <button onclick="window.location.href='{{ route('admin.user.edit', $user->id) }}'" class="group inline-flex items-center justify-center w-9 h-9 rounded-lg bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 dark:from-blue-900/20 dark:to-blue-900/30 dark:hover:from-blue-900/30 dark:hover:to-blue-900/50 text-blue-600 dark:text-blue-400 transition-all duration-200 hover:shadow-md transform hover:scale-110">
                                            <i data-lucide="edit" class="h-4 w-4 transition-transform duration-200 group-hover:scale-110"></i>
                                        </button>
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin hapus user tersebut?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="group inline-flex items-center justify-center w-9 h-9 rounded-lg
                                                        bg-gradient-to-r from-red-50 to-red-100 hover:from-red-100 hover:to-red-200
                                                        dark:from-red-900/20 dark:to-red-900/30 dark:hover:from-red-900/30
                                                        dark:hover:to-red-900/50 text-red-600 dark:text-red-400
                                                        transition-all duration-200 hover:shadow-md transform hover:scale-110">
                                                    <i data-lucide="trash-2"
                                                    class="h-4 w-4 transition-transform duration-200 group-hover:scale-110"></i>
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Added mobile card layout for better mobile experience -->
            <div class="lg:hidden space-y-4 p-4">
                @foreach($users as $user)
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm hover:shadow-md transition-all duration-200 active:scale-[0.98]">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-md">
                                    <i data-lucide="user" class="h-6 w-6 text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 text-base">{{ $user['username'] }}</h3>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="window.location.href='{{ route('admin.user.edit', $user->id) }}'" class="group inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 dark:from-blue-900/20 dark:to-blue-900/30 dark:hover:from-blue-900/30 dark:hover:to-blue-900/50 text-blue-600 dark:text-blue-400 transition-all duration-200 hover:shadow-md transform active:scale-95">
                                    <i data-lucide="edit" class="h-5 w-5"></i>
                                </button>
                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin hapus user tersebut?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="group inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-r from-red-50 to-red-100 hover:from-red-100 hover:to-red-200 dark:from-red-900/20 dark:to-red-900/30 dark:hover:from-red-900/30 dark:hover:to-red-900/50 text-red-600 dark:text-red-400 transition-all duration-200 hover:shadow-md transform active:scale-95">
                                            <i data-lucide="trash-2"
                                            class="h-4 w-4 transition-transform duration-200 group-hover:scale-110"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-medium mb-1">Nama</p>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $user['nama'] }}</p>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-medium mb-1">Role</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $roleColors[$user['role']] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $user['role'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Replaced simple pagination with smart pagination for handling many pages -->
        <div class="px-4 sm:px-6 py-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div class="text-sm text-gray-700 dark:text-gray-300 text-center sm:text-left">
                    Menampilkan <span class="font-medium">{{ $from }}</span> sampai <span class="font-medium">{{ $to }}</span> dari <span class="font-medium">{{ $total }}</span> hasil
                </div>

                <!-- Smart Pagination Component -->
                <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <!-- Mobile Page Info -->
                    <div class="sm:hidden text-sm text-gray-600 dark:text-gray-400 font-medium">
                        Menampilkan {{ $currentPage }} dari {{ $total }}
                    </div>

                    <!-- Pagination Controls -->
                    <div class="flex items-center space-x-1 sm:space-x-2">
                        <!-- First Page -->
                        <button class="group px-2 sm:px-3 py-2.5 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 flex items-center font-medium min-h-[44px] sm:min-h-[48px] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed" @disabled($isFirstPage) onclick="window.location.href='{{ $firstPage }}'">
                            <i data-lucide="chevrons-left" class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-0.5"></i>
                            <span class="hidden lg:inline ml-1">First</span>
                        </button>

                        <!-- Previous Page -->
                        <button class="group px-2 sm:px-3 py-2.5 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 flex items-center font-medium min-h-[44px] sm:min-h-[48px] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed" @disabled($isFirstPage) onclick="window.location.href='{{ $prevPage }}'">
                            <i data-lucide="chevron-left" class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-0.5"></i>
                            <span class="hidden sm:inline ml-1">Prev</span>
                        </button>

                        <div class="flex items-center space-x-1">
                            <!-- Current page -->
                            <button class="px-3 py-2.5 text-sm bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-medium shadow-md min-h-[48px] ring-2 ring-blue-200 dark:ring-blue-800">{{ $currentPage }}</button>
                        </div>

                        <!-- Next Page -->
                        <button class="group px-2 sm:px-3 py-2.5 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 flex items-center font-medium min-h-[44px] sm:min-h-[48px] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed" @disabled($isLastPage) onclick="window.location.href='{{ $nextPage }}'">
                            <span class="hidden sm:inline mr-1">Next</span>
                            <i data-lucide="chevron-right" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-0.5"></i>
                        </button>

                        <!-- Last Page -->
                        <button class="group px-2 sm:px-3 py-2.5 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 flex items-center font-medium min-h-[44px] sm:min-h-[48px] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed" @disabled($isLastPage) onclick="window.location.href='{{ $lastPage }}'">
                            <span class="hidden lg:inline mr-1">Last</span>
                            <i data-lucide="chevrons-right" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-0.5"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Quick Navigation -->
            <div class="sm:hidden mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-center space-x-2">
                    <button class="px-4 py-2 text-sm bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 dark:from-blue-900/20 dark:to-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg font-medium transition-all duration-200 active:scale-95" @disabled($isFirstPage) onclick="window.location.href='{{ $firstPage }}'">
                        Go to First
                    </button>
                    <button class="px-4 py-2 text-sm bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 dark:from-gray-800 dark:to-gray-700 text-gray-600 dark:text-gray-400 rounded-lg font-medium transition-all duration-200 active:scale-95" @disabled($isLastPage) onclick="window.location.href='{{ $lastPage }}'">
                        Go to Last
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordField = document.getElementById('passwordField');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeOffIcon = document.getElementById('eyeOffIcon');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeOffIcon.classList.remove('hidden');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeOffIcon.classList.add('hidden');
        }
    }
</script>

@endsection

