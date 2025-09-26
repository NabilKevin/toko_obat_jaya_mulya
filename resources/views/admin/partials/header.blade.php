<header class="bg-background border-b border-border p-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <button onclick="toggleSidebar()" class="group lg:hidden p-2.5 rounded-xl hover:bg-gradient-to-r hover:from-gray-100 hover:to-gray-200 dark:hover:from-gray-800 dark:hover:to-gray-700 transition-all duration-200 transform hover:scale-110 hover:shadow-md">
                <i data-lucide="menu" class="h-5 w-5 text-foreground transition-transform duration-200 group-hover:scale-110"></i>
            </button>
            
            <button onclick="toggleSidebar()" class="group hidden lg:flex items-center justify-center p-2.5 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 dark:hover:from-blue-900/20 dark:hover:to-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-200 transform hover:scale-110 hover:shadow-md">
                <i data-lucide="panel-left" class="h-5 w-5 text-foreground group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-all duration-200 group-hover:scale-110"></i>
            </button>
            
            <h1 class="text-lg lg:text-xl font-semibold text-foreground">@yield('page-title', 'Dashboard')</h1>
        </div>
        
        <div class="flex items-center space-x-2 lg:space-x-4">
            <div class="relative hidden sm:block">
                <input type="text" 
                       placeholder="Cari..." 
                       class="w-48 lg:w-64 px-4 py-2.5 pl-11 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition-all duration-200 hover:shadow-md focus:shadow-lg">
                <i data-lucide="search" class="absolute left-4 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground"></i>
            </div>
            
            <button class="group sm:hidden p-2.5 rounded-xl hover:bg-gradient-to-r hover:from-gray-100 hover:to-gray-200 dark:hover:from-gray-800 dark:hover:to-gray-700 transition-all duration-200 transform hover:scale-110 hover:shadow-md">
                <i data-lucide="search" class="h-5 w-5 text-foreground transition-transform duration-200 group-hover:scale-110"></i>
            </button>
            
            <div class="group relative">
                <button class="flex items-center space-x-2 px-3 py-2 rounded-xl hover:bg-gradient-to-r hover:from-gray-100 hover:to-gray-200 dark:hover:from-gray-800 dark:hover:to-gray-700 transition-all duration-200 transform hover:scale-105 hover:shadow-md">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-200">
                        <i data-lucide="user" class="h-4 w-4 text-white"></i>
                    </div>
                    <div class="hidden sm:block text-left">
                        <span class="text-sm font-medium text-foreground">Admin</span>
                        <p class="text-xs text-muted-foreground">Administrator</p>
                    </div>
                    <i data-lucide="chevron-down" class="h-4 w-4 text-muted-foreground transition-transform duration-200 group-hover:rotate-180"></i>
                </button>
            </div>
        </div>
    </div>
</header>
