    <!-- App Bottom Menu -->
    <div class="appBottomMenu">
        <a href="{{ url('dashboard', []) }}" class="item {{ request()->is('dashboard') ? 'active' : '' }}">
            <div class="col">
                <ion-icon name="home-outline"></ion-icon>
                <strong>Home</strong>
            </div>
        </a>
        <a href="{{ url('/absensi/histori') }}" class="item {{ request()->is('absensi/histori') ? 'active' : '' }}">
            <div class="col">
                <ion-icon name="document-text-outline" role="img" class="md hydrated"
                    aria-label="document text outline"></ion-icon>
                <strong>Histori</strong>
            </div>
        </a>
        <a href="{{ url('/absensi/create') }}" class="item">
            <div class="col">
                <div class="action-button large">
                    <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                </div>
            </div>
        </a>
        <a href="{{ url('/absensi/izin') }}" class="item {{ request()->is('absensi/izin') ? 'active' : '' }}">
            <div class="col">
                <ion-icon name="calendar-outline" role="img" class="md hydrated"
                    aria-label="document text outline"></ion-icon>
                <strong>Izin</strong>
            </div>
        </a>
        <a href="{{ url('/profile/edit', []) }}" class="item {{ request()->is('profile/edit') ? 'active' : '' }}">
            <div class="col">
                <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
                <strong>Profile</strong>
            </div>
        </a>
    </div>
    <!-- * App Bottom Menu -->