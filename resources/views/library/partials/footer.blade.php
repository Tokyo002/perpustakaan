@php($userQuery = $selectedUser?->id ? ['user_id' => $selectedUser->id] : [])

<footer class="site-footer mt-5">
    <div class="container py-4 py-lg-5">
        <div class="row g-4 align-items-start justify-content-between">
            <div class="col-lg-6">
                <h3 class="h4 mb-2">Perpustakaan SMA Muhammadiyah 25</h3>
                <p class="mb-2 text-footer-soft">
                    Pusat literasi sekolah dengan layanan katalog, peminjaman online, forum diskusi, dan referensi digital.
                </p>
                <p class="mb-0 text-footer-soft">
                    Jl. Setiabudi Pamulang | perpus@sma25.sch.id | 0812-0000-2525
                </p>
            </div>
            <div class="col-sm-6 col-lg-4">
                <h4 class="h6 text-uppercase mb-2">Navigasi</h4>
                <div class="row g-2">
                    <div class="col-6">
                        <ul class="list-unstyled mb-0 footer-links">
                            <li><a href="{{ route('library.katalog', $userQuery) }}">Katalog</a></li>
                            <li><a href="{{ route('library.artikel', $userQuery) }}">Artikel & Jurnal</a></li>
                            <li><a href="{{ route('library.pengumuman', $userQuery) }}">Pengumuman</a></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled mb-0 footer-links">
                            <li><a href="{{ route('library.forum', $userQuery) }}">Forum</a></li>
                            <li><a href="{{ route('library.galeri', $userQuery) }}">Galeri</a></li>
                            <li><a href="{{ route('library.faq', $userQuery) }}">FAQ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-4 footer-divider">
        <div class="d-flex flex-column flex-md-row justify-content-between gap-2 small text-footer-soft">
            <span>Copyright {{ now()->year }} Perpustakaan SMA Muhammadiyah 25.</span>
            <span>Dibangun dengan Laravel untuk layanan perpustakaan modern.</span>
        </div>
    </div>
</footer>
