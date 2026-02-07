<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Portal')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom_style.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-custom fixed-top" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
        <div class="container-fluid">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-md-none" id="sidebarToggle" onclick="toggleSidebar()">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand-custom" href="{{ route('admin.dashboard') }}">
                    <span>👨‍💼</span>
                    <span>Admin Portal</span>
                </a>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="user-info d-none d-md-block">
                    <div class="user-name">{{ $admin->admin_name ?? 'Admin' }}</div>
                    <div class="user-id">{{ $admin->admin_email_address }}</div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
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
                    <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="menu-icon">🏠</span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </div>

                <!-- Student Management -->
                <div class="menu-section">
                    <div class="menu-section-title">Student Management</div>
                    <a href="{{ route('admin.students.index') }}" class="menu-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                        <span class="menu-icon">👥</span>
                        <span class="menu-text">All Students</span>
                    </a>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">➕</span>
                        <span class="menu-text">Add Student</span>
                    </a>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">📋</span>
                        <span class="menu-text">Student Records</span>
                    </a>
                </div>

                <!-- Academic -->
                <div class="menu-section">
                    <div class="menu-section-title">Academic</div>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">📚</span>
                        <span class="menu-text">Courses</span>
                    </a>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">📊</span>
                        <span class="menu-text">Grades</span>
                    </a>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">📖</span>
                        <span class="menu-text">Attendance</span>
                    </a>
                    <a href="{{ route('admin.testimonials.index') }}" class="menu-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                        <span class="menu-icon">📜</span>
                        <span class="menu-text">Testimonials</span>
                    </a>
                </div>

                <!-- Creative Questions -->
                <div class="menu-section">
                    <div class="menu-section-title">Creative Questions</div>
                    <a href="{{ route('admin.cq.subjects.index') }}" class="menu-item {{ request()->routeIs('admin.cq.subjects.*') || request()->routeIs('admin.cq.chapters.*') || request()->routeIs('admin.cq.questions.*') ? 'active' : '' }}">
                        <span class="menu-icon">📚</span>
                        <span class="menu-text">Subjects</span>
                    </a>
                    <a href="{{ route('admin.cq.sets.index') }}" class="menu-item {{ request()->routeIs('admin.cq.sets.*') ? 'active' : '' }}">
        <span class="menu-icon">📝</span>
        <span class="menu-text">Question Sets</span>
    </a>
    <a href="{{ route('admin.cq.part_questions.index') }}" class="menu-item {{ request()->routeIs('admin.cq.part_questions.*') ? 'active' : '' }}">
        <span class="menu-icon">📚</span>
        <span class="menu-text">Question Bank</span>
    </a>
</div>
                </div>

                <!-- Reports -->
                <div class="menu-section">
                    <div class="menu-section-title">Reports</div>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">📈</span>
                        <span class="menu-text">Analytics</span>
                    </a>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">💰</span>
                        <span class="menu-text">Payments</span>
                    </a>
                </div>

                <!-- Settings -->
                <div class="menu-section">
                    <div class="menu-section-title">Settings</div>
                    <a href="#" class="menu-item">
                        <span class="menu-icon">⚙️</span>
                        <span class="menu-text">System Settings</span>
                    </a>
                    <a href="{{ route('admin.password.change') }}" class="menu-item {{ request()->routeIs('admin.password.change') ? 'active' : '' }}">
                        <span class="menu-icon">🔒</span>
                        <span class="menu-text">Change Password</span>
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

    @stack('scripts')
</body>
</html>
