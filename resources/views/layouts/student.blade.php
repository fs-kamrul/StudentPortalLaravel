<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Portal')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom_style.css') }}" rel="stylesheet">
    
    @yield('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-custom fixed-top">
        <div class="container-fluid">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-md-none" id="sidebarToggle" onclick="toggleSidebar()">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand-custom" href="{{ route('student.dashboard') }}">
                    <span>🎓</span>
                    <span>StudentPortal</span>
                </a>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="user-info d-none d-md-block">
                    <div class="user-name">{{ $student->name ?? 'Student' }}</div>
                    <div class="user-id">ID: {{ $student->id }}</div>
                </div>
                <form method="POST" action="{{ route('student.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Dashboard Layout -->
    <div class="d-flex" style="margin-top: 80px;">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-menu">
                <!-- Main Menu -->
                <div class="menu-section">
                    <div class="menu-section-title">Main</div>
                    <a href="{{ route('student.dashboard') }}" class="menu-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                        <span class="menu-icon">🏠</span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">👤</span>
                        <span class="menu-text">My Profile</span>
                    </a>
                </div>

                <!-- Academic -->
                <div class="menu-section">
                    <div class="menu-section-title">Academic</div>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">📚</span>
                        <span class="menu-text">My Courses</span>
                        <span class="menu-badge">4</span>
                    </a>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">📊</span>
                        <span class="menu-text">Grades</span>
                    </a>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">📝</span>
                        <span class="menu-text">Assignments</span>
                        <span class="menu-badge">3</span>
                    </a>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">📅</span>
                        <span class="menu-text">Schedule</span>
                    </a>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">📖</span>
                        <span class="menu-text">Attendance</span>
                    </a>
                </div>

                <!-- Resources -->
                <div class="menu-section">
                    <div class="menu-section-title">Resources</div>
                    <a href="{{ route('student.testimonials.index') }}" class="menu-item {{ request()->routeIs('student.testimonials.*') ? 'active' : '' }}">
                        <span class="menu-icon">📜</span>
                        <span class="menu-text">Testimonials</span>
                    </a>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">📄</span>
                        <span class="menu-text">Documents</span>
                    </a>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">📚</span>
                        <span class="menu-text">Library</span>
                    </a>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">💬</span>
                        <span class="menu-text">Messages</span>
                        <span class="menu-badge">2</span>
                    </a>
                </div>

                <!-- Settings -->
                <div class="menu-section">
                    <div class="menu-section-title">Settings</div>
                    <a href="{{ route('student.password.change') }}" class="menu-item {{ request()->routeIs('student.password.*') ? 'active' : '' }}">
                        <span class="menu-icon">🔒</span>
                        <span class="menu-text">Change Password</span>
                    </a>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">⚙️</span>
                        <span class="menu-text">Settings</span>
                    </a>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">❓</span>
                        <span class="menu-text">Help & Support</span>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        // Close sidebar when clicking on a menu item on mobile
        if (window.innerWidth <= 768) {
            document.querySelectorAll('.menu-item').forEach(item => {
                item.addEventListener('click', () => {
                    toggleSidebar();
                });
            });
        }
    </script>

    @yield('scripts')
</body>
</html>
