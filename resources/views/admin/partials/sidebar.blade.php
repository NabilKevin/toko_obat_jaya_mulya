<div id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-sidebar border-r border-sidebar-border transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="p-4 lg:p-6">
        <div class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center shadow-md">
                <i data-lucide="pill" class="h-5 w-5 text-white"></i>
            </div>
            <div class="sidebar-text">
                <h2 class="font-bold text-sidebar-foreground">Jaya Mulya</h2>
                <p class="text-xs text-muted-foreground">Toko Obat</p>
            </div>
        </div>
    </div>

    <nav class="px-4 space-y-2">
        @php
            $menuItems = [
                ['icon' => 'home', 'label' => 'Dashboard', 'route' => 'dashboard'],
                ['icon' => 'package', 'label' => 'Data Obat', 'route' => 'obat.index'],
                ['icon' => 'users', 'label' => 'Data User', 'route' => 'user.index'],
            ];
        @endphp

        @foreach($menuItems as $item)
            @php
                $isActive = request()->routeIs($item['route']) || request()->routeIs($item['route'] . '.*');
            @endphp
            <a href="{{ route($item['route']) }}" 
               class="group flex items-center w-full px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 transform hover:scale-105
                      {{ $isActive 
                         ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' 
                         : 'text-sidebar-foreground hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 dark:hover:from-blue-900/20 dark:hover:to-blue-900/30 hover:text-blue-700 dark:hover:text-blue-300 hover:shadow-md' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ $isActive ? 'bg-white/20' : 'group-hover:bg-blue-100 dark:group-hover:bg-blue-900/30' }} transition-all duration-200">
                    <i data-lucide="{{ $item['icon'] }}" class="h-4 w-4 flex-shrink-0 transition-transform duration-200 group-hover:scale-110"></i>
                </div>
                <span class="ml-3 sidebar-label transition-all duration-200">{{ $item['label'] }}</span>
                @if($isActive)
                    <div class="ml-auto w-2 h-2 bg-white rounded-full shadow-sm"></div>
                @endif
            </a>
        @endforeach
    </nav>

    <div class="absolute bottom-4 left-4 right-4">
        <button class="group flex items-center w-full px-4 py-3 rounded-xl text-sm font-medium text-red-600 dark:text-red-400 hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 dark:hover:from-red-900/20 dark:hover:to-red-900/30 hover:shadow-md transition-all duration-200 transform hover:scale-105">
            <div class="flex items-center justify-center w-8 h-8 rounded-lg group-hover:bg-red-100 dark:group-hover:bg-red-900/30 transition-all duration-200">
                <i data-lucide="log-out" class="h-4 w-4 flex-shrink-0 transition-transform duration-200 group-hover:scale-110"></i>
            </div>
            <span class="ml-3 sidebar-label transition-all duration-200">Logout</span>
        </button>
    </div>
</div>
