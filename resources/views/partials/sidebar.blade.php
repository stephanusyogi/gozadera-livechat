<div class="kleon-vertical-nav">
    <!-- Logo  -->
    <div class="p-0 logo d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard.index') }}" class="d-flex align-items-center gap-3 flex-shrink-0">
            <img src="{{ asset('images/logo-transparent.png') }}" alt="logo" style="width: 20%">
            <div class="position-relative flex-shrink-0">
                <h4 class="logo-text mb-0 mt-1">Livechat</h4>
                <h4 class="logo-text-white mb-0 mt-1">Livechat</h4>
            </div>
        </a>
        <button type="button" class="kleon-vertical-nav-toggle"><i class="bi bi-list"></i></button>
    </div>

    <div class="kleon-navmenu">
        <ul class="main-menu">
            <li class="menu-section-title text-gray ff-heading fs-16 fw-bold text-uppercase mt-4 mb-2"><span>Dashboard</span></li>
            <li class="menu-item {{ $url === '/' ? 'active' : '' }}"><a href="{{ route('dashboard.index') }}"><span class="nav-icon flex-shrink-0"><i class="bi bi-speedometer fs-18"></i></span> <span class="nav-text">Dashboard</span></a></li>
            
            <li class="menu-section-title text-gray ff-heading fs-16 fw-bold text-uppercase mt-4 mb-2"><span>Events Management</span></li>
            <li class="menu-item {{ $url === '/all-event' ? 'active' : '' }}"><a href="{{ route('all-event') }}"><span class="nav-icon flex-shrink-0"><i class="bi bi-megaphone-fill fs-18"></i></span> <span class="nav-text">All Event</span></a></li>
            <li class="menu-item{{ $url === '/all-event/add' ? 'active' : '' }}"><a href="{{ route('all-event.add') }}"><span class="nav-icon flex-shrink-0"><i class="bi bi-plus-circle-fill fs-18"></i></span> <span class="nav-text">Create Event</span></a></li>
            
            <li class="menu-section-title text-gray ff-heading fs-16 fw-bold text-uppercase mt-4 mb-2"><span>Admin Management</span></li>                    
            <li class="menu-item {{ $url === '/all-administrator' ? 'active' : '' }}"><a href="{{ route('all-administrator') }}"><span class="nav-icon flex-shrink-0"><i class="bi bi-person-lines-fill fs-18"></i></span> <span class="nav-text">All Administrator</span></a></li>
            <li class="menu-item {{ $url === '/all-administrator/add' ? 'active' : '' }}"><a href="{{ route('all-administrator.add') }}"><span class="nav-icon flex-shrink-0"><i class="bi bi-plus-circle-fill fs-18"></i></span> <span class="nav-text">Add Administrator</span></a></li>
            
            <li class="menu-section-title text-gray ff-heading fs-16 fw-bold text-uppercase mt-4 mb-2"><span>Table Management</span></li>                    
            <li class="menu-item {{ $url === '/all-table' ? 'active' : '' }}"><a href="{{ route('all-table') }}"><span class="nav-icon flex-shrink-0"><i class="bi bi-file-ruled-fill fs-18"></i></span> <span class="nav-text">All Table</span></a></li>
            <li class="menu-item {{ $url === '/all-table/add' ? 'active' : '' }}"><a href="{{ route('all-table.add') }}"><span class="nav-icon flex-shrink-0"><i class="bi bi-plus-circle-fill fs-18"></i></span> <span class="nav-text">Add Table</span></a></li>
        </ul>
    </div>
</div>