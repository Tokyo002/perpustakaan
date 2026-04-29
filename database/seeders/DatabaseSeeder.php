<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\AppSetting;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\DigitalResource;
use App\Models\EventSchedule;
use App\Models\Faq;
use App\Models\Fine;
use App\Models\ForumComment;
use App\Models\ForumPost;
use App\Models\GalleryItem;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Publisher;
use App\Models\ReturnRecord;
use App\Models\Review;
use App\Models\StaffUser;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = collect([
            ['name' => 'Admin Perpustakaan', 'username' => 'adminperpus', 'email' => 'admin@perpustakaan.test'],
            ['name' => 'Siti Nurhaliza', 'username' => 'siti', 'email' => 'siti@perpustakaan.test'],
            ['name' => 'Rizky Maulana', 'username' => 'rizky', 'email' => 'rizky@perpustakaan.test'],
            ['name' => 'Dewi Kartika', 'username' => 'dewi', 'email' => 'dewi@perpustakaan.test'],
        ])->map(function (array $user) {
            return User::query()->firstOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'username' => $user['username'],
                    'password' => 'password',
                ],
            );
        });

        $profiles = [
            ['member_id' => 'AGT-001', 'class_name' => 'XII IPA 1', 'phone' => '081200000001', 'address' => 'Pamulang Barat', 'bio' => 'Menyukai buku sains populer dan sejarah Islam.'],
            ['member_id' => 'AGT-002', 'class_name' => 'XI IPS 2', 'phone' => '081200000002', 'address' => 'Setiabudi', 'bio' => 'Aktif di klub literasi dan resensi buku.'],
            ['member_id' => 'AGT-003', 'class_name' => 'XII IPA 3', 'phone' => '081200000003', 'address' => 'Benda Baru', 'bio' => 'Fokus pada persiapan masuk perguruan tinggi.'],
            ['member_id' => 'AGT-004', 'class_name' => 'XI IPA 1', 'phone' => '081200000004', 'address' => 'Pondok Cabe', 'bio' => 'Suka jurnal eksperimen dan teknologi pendidikan.'],
        ];

        foreach ($users as $index => $user) {
            UserProfile::query()->updateOrCreate(
                ['user_id' => $user->id],
                $profiles[$index] ?? [],
            );
        }

        $categoryRows = [
            ['name' => 'Sains', 'description' => 'Koleksi IPA, fisika, biologi, dan matematika.'],
            ['name' => 'Teknologi', 'description' => 'Pemrograman, sistem informasi, dan komputer.'],
            ['name' => 'Sastra', 'description' => 'Novel, puisi, cerpen, dan kritik sastra.'],
            ['name' => 'Sejarah', 'description' => 'Sejarah Indonesia, dunia, dan tokoh penting.'],
            ['name' => 'Pendidikan', 'description' => 'Buku metode belajar dan pedagogi.'],
        ];

        foreach ($categoryRows as $categoryRow) {
            Category::query()->updateOrCreate(['name' => $categoryRow['name']], $categoryRow);
        }

        $categoryMap = Category::query()->pluck('id', 'name');

        $bookRows = [
            [
                'category' => 'Teknologi',
                'book_code' => 'BKU-0001',
                'title' => 'Pemrograman Web Modern dengan Laravel',
                'author' => 'Budi Santoso',
                'publisher' => 'Informatika Nusantara',
                'published_year' => 2024,
                'isbn' => '9786230011001',
                'language' => 'Indonesia',
                'genre' => 'Teknologi',
                'abstract' => 'Membahas pembuatan aplikasi web modern menggunakan Laravel dari konsep hingga deployment.',
                'cover_image' => 'template/img/buku.jpg',
                'stock' => 3,
            ],
            [
                'category' => 'Sains',
                'book_code' => 'BKU-0002',
                'title' => 'Dasar-Dasar Biologi Untuk SMA',
                'author' => 'Ratna Puspita',
                'publisher' => 'Cahaya Ilmu',
                'published_year' => 2022,
                'isbn' => '9786230011002',
                'language' => 'Indonesia',
                'genre' => 'Pendidikan',
                'abstract' => 'Ringkasan materi biologi SMA dengan latihan soal dan studi kasus kontekstual.',
                'cover_image' => 'template/img/buku.jpg',
                'stock' => 4,
            ],
            [
                'category' => 'Sastra',
                'book_code' => 'BKU-0003',
                'title' => 'Antologi Cerita Remaja Muhammadiyah',
                'author' => 'Tim Literasi Sekolah',
                'publisher' => 'Pustaka Pelajar Muda',
                'published_year' => 2021,
                'isbn' => '9786230011003',
                'language' => 'Indonesia',
                'genre' => 'Cerpen',
                'abstract' => 'Kumpulan cerita pendek karya siswa bertema karakter, pendidikan, dan persahabatan.',
                'cover_image' => 'template/img/buku.jpg',
                'stock' => 2,
            ],
            [
                'category' => 'Sejarah',
                'book_code' => 'BKU-0004',
                'title' => 'Jejak Sejarah Nusantara',
                'author' => 'Ahmad Fuadi',
                'publisher' => 'Arsip Bangsa',
                'published_year' => 2020,
                'isbn' => '9786230011004',
                'language' => 'Indonesia',
                'genre' => 'Sejarah',
                'abstract' => 'Ulasan perjalanan sejarah Indonesia disertai ilustrasi, peta, dan sumber primer.',
                'cover_image' => 'template/img/buku.jpg',
                'stock' => 3,
            ],
            [
                'category' => 'Pendidikan',
                'book_code' => 'BKU-0005',
                'title' => 'Strategi Belajar Efektif di Era Digital',
                'author' => 'Nadia Rahman',
                'publisher' => 'Edu Prime',
                'published_year' => 2023,
                'isbn' => '9786230011005',
                'language' => 'Indonesia',
                'genre' => 'Pengembangan Diri',
                'abstract' => 'Panduan praktis teknik belajar aktif, manajemen waktu, dan literasi digital untuk pelajar.',
                'cover_image' => 'template/img/buku.jpg',
                'stock' => 5,
            ],
            [
                'category' => 'Teknologi',
                'book_code' => 'BKU-0006',
                'title' => 'Jaringan Komputer Praktis',
                'author' => 'Dimas Haris',
                'publisher' => 'Tekno Press',
                'published_year' => 2019,
                'isbn' => '9786230011006',
                'language' => 'Indonesia',
                'genre' => 'Teknologi',
                'abstract' => 'Materi dasar jaringan komputer, keamanan, dan simulasi lab sekolah.',
                'cover_image' => 'template/img/buku.jpg',
                'stock' => 2,
            ],
        ];

        foreach ($bookRows as $bookRow) {
            $categoryId = $categoryMap[$bookRow['category']] ?? null;
            unset($bookRow['category']);

            Book::query()->updateOrCreate(
                ['title' => $bookRow['title']],
                array_merge($bookRow, ['category_id' => $categoryId]),
            );
        }

        $publisherNames = collect($bookRows)->pluck('publisher')->unique()->values();

        foreach ($publisherNames as $publisherName) {
            Publisher::query()->updateOrCreate(
                ['name' => $publisherName],
                [
                    'address' => 'Alamat belum diisi',
                    'contact' => '-',
                ],
            );
        }

        $publisherMap = Publisher::query()->pluck('id', 'name');

        foreach (Book::query()->get() as $book) {
            $book->update([
                'publisher_id' => $publisherMap[$book->publisher] ?? null,
            ]);
        }

        $resourceRows = [
            [
                'title' => 'Jurnal Literasi Digital Siswa SMA',
                'author' => 'Pusat Riset Pendidikan',
                'topic' => 'Literasi Digital',
                'year' => 2024,
                'abstract' => 'Analisis peningkatan literasi digital melalui program perpustakaan berbasis web.',
                'access_level' => 'open',
                'resource_type' => 'pdf',
                'resource_url' => 'https://example.org/jurnal-literasi-digital.pdf',
            ],
            [
                'title' => 'Proceeding Seminar Manajemen Perpustakaan Sekolah',
                'author' => 'Forum Pustakawan Indonesia',
                'topic' => 'Manajemen Perpustakaan',
                'year' => 2023,
                'abstract' => 'Kumpulan artikel praktik baik pengelolaan perpustakaan sekolah menengah.',
                'access_level' => 'limited',
                'resource_type' => 'link',
                'resource_url' => 'https://example.org/proceeding-perpustakaan',
            ],
            [
                'title' => 'Artikel: Integrasi Sistem Informasi Akademik dan Perpustakaan',
                'author' => 'LPPM Kampus Lokal',
                'topic' => 'Sistem Informasi',
                'year' => 2025,
                'abstract' => 'Mengkaji integrasi data anggota dan peminjaman antar platform sekolah.',
                'access_level' => 'open',
                'resource_type' => 'link',
                'resource_url' => 'https://example.org/integrasi-siakad-perpus',
            ],
        ];

        foreach ($resourceRows as $resourceRow) {
            DigitalResource::query()->updateOrCreate(['title' => $resourceRow['title']], $resourceRow);
        }

        $announcementRows = [
            [
                'title' => 'Lomba Resensi Buku 2026 Dibuka',
                'content' => 'Pendaftaran dibuka hingga 20 Mei 2026. Peserta mengirimkan resensi minimal 800 kata.',
                'type' => 'news',
                'published_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Perubahan Jam Buka Perpustakaan',
                'content' => 'Mulai Senin, jam layanan perpustakaan adalah 07.00 - 15.30 WIB.',
                'type' => 'policy',
                'published_at' => Carbon::now()->subDays(6),
            ],
            [
                'title' => 'Bedah Buku Bulanan',
                'content' => 'Diskusi terbuka buku inspiratif bersama guru bahasa Indonesia setiap Jumat pekan ketiga.',
                'type' => 'event',
                'published_at' => Carbon::now()->subDays(10),
            ],
        ];

        foreach ($announcementRows as $announcementRow) {
            Announcement::query()->updateOrCreate(['title' => $announcementRow['title']], $announcementRow);
        }

        $eventRows = [
            [
                'title' => 'Seminar Literasi Informasi',
                'description' => 'Seminar penguatan kemampuan mencari sumber kredibel untuk tugas sekolah.',
                'event_date' => Carbon::now()->addDays(4)->toDateString(),
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
                'location' => 'Aula SMA Muhammadiyah 25',
            ],
            [
                'title' => 'Kelas Menulis Resensi',
                'description' => 'Pelatihan teknik menulis resensi buku nonfiksi.',
                'event_date' => Carbon::now()->addDays(9)->toDateString(),
                'start_time' => '13:00:00',
                'end_time' => '15:00:00',
                'location' => 'Ruang Multimedia',
            ],
            [
                'title' => 'Forum Komunitas Pembaca',
                'description' => 'Sesi berbagi rekomendasi buku dan diskusi ringan antar anggota.',
                'event_date' => Carbon::now()->addDays(14)->toDateString(),
                'start_time' => '10:00:00',
                'end_time' => '11:30:00',
                'location' => 'Ruang Baca Lantai 2',
            ],
        ];

        foreach ($eventRows as $eventRow) {
            EventSchedule::query()->updateOrCreate(['title' => $eventRow['title']], $eventRow);
        }

        $galleryRows = [
            ['title' => 'Sampul Koleksi Buku', 'media_type' => 'image', 'media_url' => 'template/img/buku.jpg', 'caption' => 'Cover default koleksi buku.'],
            ['title' => 'Sampul Buku Referensi', 'media_type' => 'image', 'media_url' => 'template/img/buku.jpg', 'caption' => 'Cover buku untuk referensi katalog.'],
            ['title' => 'Sampul Buku Populer', 'media_type' => 'image', 'media_url' => 'template/img/buku.jpg', 'caption' => 'Cover buku populer perpustakaan.'],
            ['title' => 'Dokumentasi Kegiatan', 'media_type' => 'video', 'media_url' => 'https://www.youtube.com/embed/s7L2PVdrb_8', 'caption' => 'Contoh video dokumentasi kegiatan perpustakaan.'],
        ];

        foreach ($galleryRows as $galleryRow) {
            GalleryItem::query()->updateOrCreate(['title' => $galleryRow['title']], $galleryRow);
        }

        $faqRows = [
            ['question' => 'Bagaimana cara mendaftar anggota perpustakaan?', 'answer' => 'Datang ke meja layanan dengan kartu pelajar, lalu isi formulir digital anggota.', 'category' => 'Keanggotaan', 'sort_order' => 1],
            ['question' => 'Berapa lama durasi peminjaman buku?', 'answer' => 'Durasi standar peminjaman adalah 7 hari dan bisa diperpanjang 1 kali jika buku tidak dipesan anggota lain.', 'category' => 'Peminjaman', 'sort_order' => 2],
            ['question' => 'Bagaimana menghubungi admin perpustakaan?', 'answer' => 'Hubungi admin melalui email perpus@sma25.sch.id atau WhatsApp layanan 0812-0000-2525.', 'category' => 'Bantuan', 'sort_order' => 3],
        ];

        foreach ($faqRows as $faqRow) {
            Faq::query()->updateOrCreate(['question' => $faqRow['question']], $faqRow);
        }

        $bookMap = Book::query()->pluck('id', 'title');
        $userMap = User::query()->pluck('id', 'email');

        $loanRows = [
            [
                'email' => 'siti@perpustakaan.test',
                'book' => 'Pemrograman Web Modern dengan Laravel',
                'borrowed_at' => Carbon::now()->subDays(4)->toDateString(),
                'due_at' => Carbon::now()->addDays(2)->toDateString(),
                'status' => 'borrowed',
                'notes' => 'Dipakai untuk referensi tugas akhir.',
                'returned_at' => null,
            ],
            [
                'email' => 'rizky@perpustakaan.test',
                'book' => 'Dasar-Dasar Biologi Untuk SMA',
                'borrowed_at' => Carbon::now()->subDays(12)->toDateString(),
                'due_at' => Carbon::now()->subDays(2)->toDateString(),
                'status' => 'overdue',
                'notes' => 'Belum selesai membaca bab genetika.',
                'returned_at' => null,
            ],
            [
                'email' => 'dewi@perpustakaan.test',
                'book' => 'Jejak Sejarah Nusantara',
                'borrowed_at' => Carbon::now()->subDays(8)->toDateString(),
                'due_at' => Carbon::now()->subDays(1)->toDateString(),
                'status' => 'returned',
                'notes' => 'Sudah dipresentasikan di kelas sejarah.',
                'returned_at' => Carbon::now()->subDays(1)->toDateString(),
            ],
        ];

        foreach ($loanRows as $loanRow) {
            $userId = $userMap[$loanRow['email']] ?? null;
            $bookId = $bookMap[$loanRow['book']] ?? null;

            if (! $userId || ! $bookId) {
                continue;
            }

            Loan::query()->updateOrCreate(
                [
                    'user_id' => $userId,
                    'book_id' => $bookId,
                    'borrowed_at' => $loanRow['borrowed_at'],
                ],
                [
                    'due_at' => $loanRow['due_at'],
                    'status' => $loanRow['status'],
                    'notes' => $loanRow['notes'],
                    'returned_at' => $loanRow['returned_at'],
                ],
            );
        }

        foreach (Book::query()->get() as $book) {
            $book->update([
                'is_available' => ! Loan::query()->where('book_id', $book->id)->whereNull('returned_at')->exists(),
            ]);
        }

        $wishlistRows = [
            ['email' => 'siti@perpustakaan.test', 'book' => 'Strategi Belajar Efektif di Era Digital', 'notes' => 'Target dibaca minggu depan.'],
            ['email' => 'rizky@perpustakaan.test', 'book' => 'Jaringan Komputer Praktis', 'notes' => 'Butuh untuk persiapan lomba IT.'],
        ];

        foreach ($wishlistRows as $wishlistRow) {
            $userId = $userMap[$wishlistRow['email']] ?? null;
            $bookId = $bookMap[$wishlistRow['book']] ?? null;

            if (! $userId || ! $bookId) {
                continue;
            }

            Wishlist::query()->updateOrCreate(
                [
                    'user_id' => $userId,
                    'book_id' => $bookId,
                ],
                [
                    'notes' => $wishlistRow['notes'],
                ],
            );
        }

        $reviewRows = [
            ['email' => 'siti@perpustakaan.test', 'book' => 'Pemrograman Web Modern dengan Laravel', 'rating' => 5, 'review' => 'Bahasanya mudah dipahami dan cocok untuk pemula.'],
            ['email' => 'dewi@perpustakaan.test', 'book' => 'Jejak Sejarah Nusantara', 'rating' => 4, 'review' => 'Kontennya lengkap dan menarik untuk presentasi kelas.'],
        ];

        foreach ($reviewRows as $reviewRow) {
            $userId = $userMap[$reviewRow['email']] ?? null;
            $bookId = $bookMap[$reviewRow['book']] ?? null;

            if (! $userId || ! $bookId) {
                continue;
            }

            Review::query()->updateOrCreate(
                [
                    'user_id' => $userId,
                    'book_id' => $bookId,
                ],
                [
                    'rating' => $reviewRow['rating'],
                    'review' => $reviewRow['review'],
                ],
            );
        }

        $forumRows = [
            [
                'email' => 'siti@perpustakaan.test',
                'title' => 'Rekomendasi Buku Teknologi untuk Pemula',
                'topic' => 'Rekomendasi Buku',
                'content' => 'Saya merekomendasikan buku Laravel modern untuk teman-teman yang sedang belajar web.',
                'is_recommendation' => true,
                'comments' => [
                    ['email' => 'rizky@perpustakaan.test', 'content' => 'Setuju, saya juga pakai buku ini untuk latihan project kecil.'],
                    ['email' => 'dewi@perpustakaan.test', 'content' => 'Kalau ada versi lanjutan, boleh share juga ya.'],
                ],
            ],
            [
                'email' => 'dewi@perpustakaan.test',
                'title' => 'Sharing Resensi Jejak Sejarah Nusantara',
                'topic' => 'Resensi',
                'content' => 'Buku ini membantu saya memahami keterkaitan peristiwa sejarah dengan kondisi masa kini.',
                'is_recommendation' => false,
                'comments' => [
                    ['email' => 'siti@perpustakaan.test', 'content' => 'Terima kasih resensinya, jadi tertarik meminjam minggu ini.'],
                ],
            ],
        ];

        foreach ($forumRows as $forumRow) {
            $userId = $userMap[$forumRow['email']] ?? null;

            if (! $userId) {
                continue;
            }

            $post = ForumPost::query()->updateOrCreate(
                [
                    'user_id' => $userId,
                    'title' => $forumRow['title'],
                ],
                [
                    'topic' => $forumRow['topic'],
                    'content' => $forumRow['content'],
                    'is_recommendation' => $forumRow['is_recommendation'],
                ],
            );

            foreach ($forumRow['comments'] as $commentRow) {
                $commentUserId = $userMap[$commentRow['email']] ?? null;

                if (! $commentUserId) {
                    continue;
                }

                ForumComment::query()->updateOrCreate(
                    [
                        'forum_post_id' => $post->id,
                        'user_id' => $commentUserId,
                        'content' => $commentRow['content'],
                    ],
                    [],
                );
            }
        }

        $staffAdmin = StaffUser::query()->updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Utama',
                'password' => 'admin12345',
                'role' => 'admin',
                'phone' => '081200001111',
                'address' => 'SMA Muhammadiyah 25 Setiabudi Pamulang',
                'is_active' => true,
            ],
        );

        StaffUser::query()->updateOrCreate(
            ['email' => 'petugas@gmail.com'],
            [
                'name' => 'Petugas Perpustakaan',
                'password' => 'petugas123',
                'role' => 'petugas',
                'phone' => '081200002222',
                'address' => 'Ruang Perpustakaan Lt. 1',
                'is_active' => true,
            ],
        );

        foreach ($users as $index => $user) {
            $profile = $profiles[$index] ?? null;

            if (! $profile) {
                continue;
            }

            Member::query()->updateOrCreate(
                ['member_number' => $profile['member_id']],
                [
                    'name' => $user->name,
                    'member_type' => str_contains(strtolower($profile['class_name']), 'x') ? 'siswa' : 'guru',
                    'class_or_position' => $profile['class_name'],
                    'contact' => $profile['phone'],
                    'is_active' => true,
                ],
            );
        }

        foreach (Book::query()->get() as $book) {
            BookCopy::query()->updateOrCreate(
                ['copy_code' => 'CPY-' . str_pad((string) $book->id, 4, '0', STR_PAD_LEFT)],
                [
                    'book_id' => $book->id,
                    'quantity' => max(1, (int) $book->stock),
                    'rack_location' => 'R-' . str_pad((string) (($book->id % 9) + 1), 2, '0', STR_PAD_LEFT),
                    'condition' => 'baik',
                    'status' => 'tersedia',
                ],
            );
        }

        AppSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'system_name' => 'Sistem Informasi Perpustakaan SMA Muhammadiyah 25',
                'system_logo' => 'template/img/Logo.png',
                'phone' => '0812-0000-2525',
                'address' => 'Jl. Setiabudi Pamulang',
                'fine_per_day' => 2000,
                'loan_duration_days' => 7,
                'updated_by_staff_id' => $staffAdmin->id,
            ],
        );

        $memberA = Member::query()->where('member_number', 'AGT-002')->first();
        $memberB = Member::query()->where('member_number', 'AGT-003')->first();
        $bookA = Book::query()->where('title', 'Pemrograman Web Modern dengan Laravel')->first();
        $bookB = Book::query()->where('title', 'Dasar-Dasar Biologi Untuk SMA')->first();

        if ($memberA && $bookA) {
            $copyA = BookCopy::query()->where('book_id', $bookA->id)->first();

            if ($copyA) {
                $activeBorrowing = Borrowing::query()->updateOrCreate(
                    [
                        'member_id' => $memberA->id,
                        'book_id' => $bookA->id,
                        'status' => 'aktif',
                    ],
                    [
                        'book_copy_id' => $copyA->id,
                        'staff_user_id' => $staffAdmin->id,
                        'borrowed_at' => Carbon::now()->subDays(2)->toDateString(),
                        'due_at' => Carbon::now()->addDays(5)->toDateString(),
                        'returned_at' => null,
                    ],
                );

                $copyA->update(['status' => 'dipinjam']);
                $bookA->update(['is_available' => false]);
            }
        }

        if ($memberB && $bookB) {
            $copyB = BookCopy::query()->where('book_id', $bookB->id)->first();

            if ($copyB) {
                $returnedBorrowing = Borrowing::query()->updateOrCreate(
                    [
                        'member_id' => $memberB->id,
                        'book_id' => $bookB->id,
                        'status' => 'kembali',
                    ],
                    [
                        'book_copy_id' => $copyB->id,
                        'staff_user_id' => $staffAdmin->id,
                        'borrowed_at' => Carbon::now()->subDays(12)->toDateString(),
                        'due_at' => Carbon::now()->subDays(5)->toDateString(),
                        'returned_at' => Carbon::now()->subDays(2)->toDateString(),
                    ],
                );

                $returnRecord = ReturnRecord::query()->updateOrCreate(
                    ['borrowing_id' => $returnedBorrowing->id],
                    [
                        'member_id' => $memberB->id,
                        'book_id' => $bookB->id,
                        'staff_user_id' => $staffAdmin->id,
                        'due_date' => Carbon::now()->subDays(5)->toDateString(),
                        'returned_at' => Carbon::now()->subDays(2)->toDateString(),
                        'book_condition' => 'baik',
                        'late_days' => 3,
                    ],
                );

                Fine::query()->updateOrCreate(
                    ['return_record_id' => $returnRecord->id],
                    [
                        'member_id' => $memberB->id,
                        'book_id' => $bookB->id,
                        'borrowing_id' => $returnedBorrowing->id,
                        'fine_type' => 'keterlambatan',
                        'late_days' => 3,
                        'amount' => 6000,
                        'paid_amount' => 2000,
                        'remaining_amount' => 4000,
                        'payment_status' => 'sebagian',
                    ],
                );

                $copyB->update(['status' => 'tersedia']);
                $bookB->update(['is_available' => true]);
            }
        }
    }
}
