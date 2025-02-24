<!-- Hamburger Menu -->
<div class="hamburger-menu" onclick="toggleSidebar()">
    <div class="line"></div>
    <div class="line"></div>
    <div class="line"></div>
</div>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-header">
        <h3>SITA</h3>
    </div>
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</aside>
