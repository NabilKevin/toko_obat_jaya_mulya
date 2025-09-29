<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Admin - Toko Obat Jaya Mulya')</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        background: 'hsl(var(--background))',
                        foreground: 'hsl(var(--foreground))',
                        muted: 'hsl(var(--muted))',
                        'muted-foreground': 'hsl(var(--muted-foreground))',
                        border: 'hsl(var(--border))',
                        primary: 'hsl(var(--primary))',
                        'primary-foreground': 'hsl(var(--primary-foreground))',
                        secondary: 'hsl(var(--secondary))',
                        'secondary-foreground': 'hsl(var(--secondary-foreground))',
                        accent: 'hsl(var(--accent))',
                        'accent-foreground': 'hsl(var(--accent-foreground))',
                        sidebar: 'hsl(var(--sidebar))',
                        'sidebar-foreground': 'hsl(var(--sidebar-foreground))',
                        'sidebar-border': 'hsl(var(--sidebar-border))',
                        'sidebar-accent': 'hsl(var(--sidebar-accent))',
                        'sidebar-accent-foreground': 'hsl(var(--sidebar-accent-foreground))',
                        destructive: 'hsl(var(--destructive))',
                        'destructive-foreground': 'hsl(var(--destructive-foreground))',
                        success: 'hsl(var(--success))',
                        'success-foreground': 'hsl(var(--success-foreground))',
                        card: 'hsl(var(--card))',
                        'card-foreground': 'hsl(var(--card-foreground))',
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                        'medium': '0 4px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 30px -5px rgba(0, 0, 0, 0.05)',
                        'large': '0 10px 40px -10px rgba(0, 0, 0, 0.15), 0 20px 50px -10px rgba(0, 0, 0, 0.1)',
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body class="min-h-screen bg-background text-foreground font-sans antialiased">
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

        // Theme system
        function initTheme() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.className = savedTheme;
            updateThemeIcon();
        }

        function toggleTheme() {
            const currentTheme = document.documentElement.className;
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            document.documentElement.className = newTheme;
            localStorage.setItem('theme', newTheme);
            updateThemeIcon();
        }

        function updateThemeIcon() {
            const themeIcon = document.getElementById('theme-icon');
            const isDark = document.documentElement.className === 'dark';

            if (themeIcon) {
                themeIcon.setAttribute('data-lucide', isDark ? 'sun' : 'moon');
                lucide.createIcons();
            }
        }

        // Initialize theme on page load
        document.addEventListener('DOMContentLoaded', initTheme);

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
