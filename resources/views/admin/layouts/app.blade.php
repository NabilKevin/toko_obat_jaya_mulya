<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Admin - Toko Obat Jaya Mulya')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        background: 'hsl(222.2 84% 4.9%)',
                        foreground: 'hsl(210 40% 98%)',
                        muted: 'hsl(217.2 32.6% 17.5%)',
                        'muted-foreground': 'hsl(215 20.2% 65.1%)',
                        border: 'hsl(217.2 32.6% 17.5%)',
                        primary: 'hsl(210 40% 98%)',
                        'primary-foreground': 'hsl(222.2 84% 4.9%)',
                        secondary: 'hsl(217.2 32.6% 17.5%)',
                        'secondary-foreground': 'hsl(210 40% 98%)',
                        sidebar: 'hsl(222.2 84% 4.9%)',
                        'sidebar-foreground': 'hsl(210 40% 98%)',
                        'sidebar-border': 'hsl(217.2 32.6% 17.5%)',
                        'sidebar-accent': 'hsl(217.2 32.6% 17.5%)',
                        'sidebar-accent-foreground': 'hsl(210 40% 98%)',
                        destructive: 'hsl(0 62.8% 30.6%)',
                        'destructive-foreground': 'hsl(210 40% 98%)',
                    }
                }
            }
        }
    </script>
    
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body class="min-h-screen bg-background text-foreground">
    <div class="flex relative h-screen overflow-hidden">
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>
        
        @include('admin.partials.sidebar')
        
        <div class="flex-1 min-w-0 flex flex-col">
            @include('admin.partials.header')
            
            <main class="flex-1 overflow-auto bg-background">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (window.innerWidth < 1024) { // Mobile/tablet
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            } else { // Desktop
                sidebar.classList.toggle('w-64');
                sidebar.classList.toggle('w-16');
                
                // Toggle text visibility
                const sidebarTexts = sidebar.querySelectorAll('.sidebar-text');
                const sidebarLabels = sidebar.querySelectorAll('.sidebar-label');
                
                sidebarTexts.forEach(text => text.classList.toggle('hidden'));
                sidebarLabels.forEach(label => label.classList.toggle('hidden'));
            }
        }
        
        // Close sidebar on window resize if mobile
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
        
        // Simple modal functionality
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    </script>
    
    @stack('scripts')
</body>
</html>
