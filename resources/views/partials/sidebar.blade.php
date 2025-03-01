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
            <a href="{{ route('dashboard') }}" class="{{ $title === 'Dashboard' ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt" ></i> Dashboard
            </a>
        </li>
        @if (auth()->user()->role === 'admin')
        <li>
            <a href="{{ route('ta.create') }}" class="{{ $title === 'Tambah Tugas Akhir' ? 'active' : '' }}">
                <i class="fas fa-file"></i> Tambah Tugas Akhir
            </a>
        </li>
        @endif
        @if (auth()->user()->role === 'mahasiswa')
        <li>
            <a href="{{ route('bimbingan.create') }}" class="{{ $title === 'Tambah Bimbingan' ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher"></i> Tambah Bimbingan
            </a>
        </li>
        @endif
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
