<header class="header kleon-default-nav">				
    <div class="d-none d-xl-block">
        <div class="header-inner d-flex align-items-center justify-content-around justify-content-xl-between flex-wrap flex-xl-nowrap gap-3 gap-xl-5">
            <div class="header-left-part d-flex align-items-center flex-grow-1 w-100"></div>

            <div class="header-right-part d-flex align-items-center flex-shrink-0">
                <ul class="nav-elements d-flex align-items-center list-unstyled m-0 p-0">
                    <li class="nav-item nav-color-switch d-flex align-items-center gap-3">
                        <div class="sun"><img src="{{ asset('templates/assets/img/sun.svg') }}" alt="img"></div>
                        <div class="switch">
                            <input type="checkbox" id="colorSwitch" value="false" name="defaultMode"  {{ session('color_mode') == 'dark' ? 'checked' : '' }}>
                            <div class="shutter">
                                <span class="lbl-off"></span>
                                <span class="lbl-on"></span>
                                <div class="slider bg-primary"></div>
                            </div>
                        </div>
                        <div class="moon"><img src="{{ asset('templates/assets/img/moon.svg') }}" alt="img"></div>
                    </li>
                    
                    <li class="nav-item nav-author">
                        <a href="#" class="nav-toggler" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('images/user.png') }}" alt="img" width="54" class="rounded-2">
                            <div class="nav-toggler-content">
                                <h6 class="mb-0">{{ strlen($admin->name) > 15 ? substr($admin->name, 0, 15) . '...' : $admin->name }}</h6>
                                <div class="ff-heading fs-14 fw-normal text-gray">{{ $admin->type }}</div>
                            </div>
                        </a>
                        <div class="dropdown-widget dropdown-menu p-0 admin-card">
                            <div class="dropdown-wrapper">
                                <div class="card mb-0">
                                    <div class="card-header p-3 text-center">
                                        <img src="{{ asset('images/user.png') }}" alt="img" width="80" class="rounded-circle avatar">
                                        <div class="mt-2">
                                            <h6 class="mb-0 lh-18">{{ strlen($admin->name) > 15 ? substr($admin->name, 0, 15) . '...' : $admin->name }}</h6>
                                            <div class="fs-14 fw-normal text-gray">{{ $admin->type }}</div>
                                        </div>
                                    </div>
                                    <div class="card-footer p-3">
                                        <a href="{{ route('logout') }}" class="btn btn-outline-gray bg-transparent w-100 py-1 rounded-1 text-dark fs-14 fw-medium"><i class="bi bi-box-arrow-right"></i> Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="small-header d-flex align-items-center justify-content-between d-xl-none">
        <div class="logo">
            <a href="/" class="d-flex align-items-center gap-3 flex-shrink-0">
                <img src="{{ asset('templates/assets/img/logo-icon.svg') }}" alt="logo">
                <div class="position-relative flex-shrink-0">
                    <img src="{{ asset('templates/assets/img/logo-text.svg') }}" alt="" class="logo-text">
                    <img src="{{ asset('templates/assets/img/logo-text-white.svg') }}" alt="" class="logo-text-white">
                </div>
            </a>
        </div>
        <div>
            <button type="button" class="kleon-header-expand-toggle"><span class="fs-24"><i class="bi bi-three-dots-vertical"></i></button>
            <button type="button" class="kleon-mobile-menu-opener"><span class="close"><i class="bi bi-arrow-left"></i></span> <span class="open"><i class="bi bi-list"></i></span></button>
        </div>
    </div>

    <div class="header-mobile-option">
        <div class="header-inner">
            <div class="d-flex align-items-center justify-content-end flex-shrink-0">
                <ul class="nav-elements d-flex align-items-center list-unstyled m-0 p-0">
                    <li class="nav-item nav-author px-3">
                        <a href="#" class="nav-toggler" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('images/user.png') }}" alt="img" width="40" class="rounded-2">
                            <div class="nav-toggler-content">
                                <h6 class="mb-0">Franklin Jr.</h6>
                                <div class="ff-heading fs-14 fw-normal text-gray">Super Admin</div>
                            </div>
                        </a>
                        <div class="dropdown-widget dropdown-menu p-0 admin-card">
                            <div class="dropdown-wrapper">
                                <div class="card mb-0">
                                    <div class="card-header p-3 text-center">
                                        <img src="{{ asset('images/user.png') }}" alt="img" width="60" class="rounded-circle avatar">
                                        <div class="mt-2">
                                            <h6 class="mb-0 lh-18">Franklin Jr.</h6>
                                            <div class="fs-14 fw-normal text-gray">Super Admin</div>
                                        </div>
                                    </div>
                                    <div class="card-footer p-3">
                                        <a href="#" class="btn btn-outline-gray bg-transparent w-100 py-1 rounded-1 text-dark fs-14 fw-medium"><i class="bi bi-box-arrow-right"></i> Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>