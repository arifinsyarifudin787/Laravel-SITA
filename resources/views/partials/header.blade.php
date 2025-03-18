<header class="header-container">
    <h1>Halo {{ auth()->user()->name }}</h1>

    @if(auth()->user()->role === 'admin' && ($title === 'Dashboard' || $title === 'Pencarian'))
    <div class="search-section">
        <form action="{{ route('ta.search') }}" method="GET" class="search-form">
            <input 
                type="text" 
                name="nama" 
                placeholder="Cari nama mahasiswa..." 
                value="" 
                class="search-input"
                id="searchInput"
            >
            <button type="submit" id="toggleSearch" class="search-icon">
                <i class="fas fa-search"></i> 
            </button>
        </form>
    </div>
    @endif
</header>