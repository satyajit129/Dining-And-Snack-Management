<aside class="left-sidebar sidebar-dark" id="left-sidebar">
    <div id="sidebar" class="sidebar sidebar-with-footer">
        <!-- Aplication Brand -->
        @php
            $settings = App\Models\Setting::first(); // Fetch the settings
        @endphp

        <div class="app-brand">
            <a href="{{ route('adminDashboard') }}">
                <img src="{{ asset('admin/settings/logo/' . $settings->website_logo) }}" alt=""
                    style="width: 50px; border-radius:50%;">
                <span class="brand-name">{{ $settings->website_name }}</span>
            </a>
        </div>

        <!-- begin sidebar scrollbar -->
        <div class="sidebar-left" data-simplebar style="height: 100%;">
            <!-- sidebar menu -->
            <ul class="nav sidebar-inner" id="sidebar-menu">
                <li class="{{ request()->route()->getName() == 'adminDashboard' ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('adminDashboard') }}">
                        <i class="mdi mdi-briefcase-account-outline"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="section-title">
                    Elements
                </li>
                <li class="{{ request()->route()->getName() == 'shiftWiseMenuIndex' ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('shiftWiseMenuIndex') }}">
                        <i class="mdi mdi-wechat"></i>
                        <span class="nav-text">Shift Wise Menu</span>
                    </a>
                </li>
                <li class="section-title">
                    Managements
                </li>
                <li class="{{ request()->route()->getName() == 'manpowerIndex' ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('manpowerIndex') }}">
                        <i class="mdi mdi-wechat"></i>
                        <span class="nav-text">ManPower Management</span>
                    </a>
                </li>
                <li class="{{ request()->route()->getName() == 'menuItemIndex' ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('menuItemIndex') }}">
                        <i class="mdi mdi-wechat"></i>
                        <span class="nav-text">Menu Management</span>
                    </a>
                </li>
                <li class="{{ request()->route()->getName() == 'predictionReportIndex' ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('predictionReportIndex') }}">
                        <i class="mdi mdi-wechat"></i>
                        <span class="nav-text">Prediction and Reporting</span>
                    </a>
                </li>
            </ul>


        </div>

        <div class="sidebar-footer">
            <div class="sidebar-footer-content">
                <ul class="d-flex">
                    <li>
                        <a href="#"></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>
