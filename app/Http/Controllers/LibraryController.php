<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Book;
use App\Models\Category;
use App\Models\DigitalResource;
use App\Models\EventSchedule;
use App\Models\Faq;
use App\Models\ForumComment;
use App\Models\ForumPost;
use App\Models\GalleryItem;
use App\Models\Loan;
use App\Models\Review;
use App\Models\UserProfile;
use App\Models\Wishlist;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class LibraryController extends Controller
{
    public function index(Request $request): View
    {
        return $this->katalog($request);
    }

    public function katalog(Request $request): View
    {
        return view('library.pages.katalog', $this->libraryPageData($request));
    }

    public function artikel(Request $request): View
    {
        return view('library.pages.artikel', $this->libraryPageData($request));
    }

    public function pengumuman(Request $request): View
    {
        return view('library.pages.pengumuman', $this->libraryPageData($request));
    }

    public function login(Request $request): View
    {
        return view('library.pages.login');
    }

    public function loginStudent(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $user = User::query()
            ->where('username', $data['username'])
            ->orWhere('email', $data['username'])
            ->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return back()->withInput()->with('error', 'Username atau password salah.');
        }

        $request->session()->regenerate();
        $request->session()->put([
            'student_user_id' => $user->id,
            'student_user_name' => $user->name,
        ]);

        return redirect()
            ->route('library.katalog', ['user_id' => $user->id])
            ->with('success', 'Login berhasil.');
    }

    public function logoutStudent(Request $request): RedirectResponse
    {
        $request->session()->forget(['student_user_id', 'student_user_name']);
        $request->session()->regenerateToken();

        return redirect()
            ->route('library.login')
            ->with('success', 'Anda telah keluar dari akun siswa.');
    }

    public function register(Request $request): View
    {
        return view('library.pages.register');
    }

    public function registerStudent(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $email = sprintf('%s@siswa.local', $data['username']);

        if (User::query()->where('email', $email)->exists()) {
            $email = sprintf('%s-%s@siswa.local', $data['username'], uniqid());
        }

        $user = User::query()->create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $email,
            'password' => $data['password'],
        ]);

        $request->session()->regenerate();
        $request->session()->put([
            'student_user_id' => $user->id,
            'student_user_name' => $user->name,
        ]);

        return redirect()
            ->route('library.katalog', ['user_id' => $user->id])
            ->with('success', 'Akun berhasil dibuat.');
    }

    public function forum(Request $request): View
    {
        return view('library.pages.forum', $this->libraryPageData($request));
    }

    public function galeri(Request $request): View
    {
        return view('library.pages.galeri', $this->libraryPageData($request));
    }

    public function faq(Request $request): View
    {
        return view('library.pages.faq', $this->libraryPageData($request));
    }

    private function libraryPageData(Request $request): array
    {
        Loan::query()
            ->whereNull('returned_at')
            ->whereDate('due_at', '<', now()->toDateString())
            ->update(['status' => 'overdue']);

        $categories = Category::query()->orderBy('name')->get();

        $books = Book::query()
            ->with('category')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim((string) $request->string('search'));

                $query->where(function ($inner) use ($search) {
                    $inner
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('publisher', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%")
                        ->orWhere('genre', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', (int) $request->input('category_id')))
            ->when($request->filled('genre'), fn ($query) => $query->where('genre', 'like', '%' . $request->input('genre') . '%'))
            ->when($request->filled('language'), fn ($query) => $query->where('language', 'like', '%' . $request->input('language') . '%'))
            ->when($request->filled('availability'), function ($query) use ($request) {
                $availability = $request->input('availability');

                if ($availability === 'available') {
                    $query->where('is_available', true);
                }

                if ($availability === 'borrowed') {
                    $query->where('is_available', false);
                }
            })
            ->orderBy('title')
            ->get();

        $resources = DigitalResource::query()->orderByDesc('year')->orderBy('title')->get();
        $announcements = Announcement::query()->orderByDesc('published_at')->orderByDesc('created_at')->take(6)->get();
        $events = EventSchedule::query()->orderBy('event_date')->orderBy('start_time')->take(10)->get();
        $users = User::query()->with('profile')->orderBy('name')->get();

        $selectedUserId = (int) $request->session()->get('student_user_id', 0);
        $selectedUser = $users->firstWhere('id', $selectedUserId);

        $loanHistory = collect();
        $wishlist = collect();
        $userReviews = collect();
        $dueSoonLoans = collect();
        $overdueLoans = collect();

        if ($selectedUser) {
            $loanHistory = Loan::query()
                ->with('book')
                ->where('user_id', $selectedUser->id)
                ->orderByDesc('borrowed_at')
                ->get();

            $wishlist = Wishlist::query()
                ->with('book')
                ->where('user_id', $selectedUser->id)
                ->latest()
                ->get();

            $userReviews = Review::query()
                ->with('book')
                ->where('user_id', $selectedUser->id)
                ->latest()
                ->get();

            $dueSoonLoans = Loan::query()
                ->with('book')
                ->where('user_id', $selectedUser->id)
                ->whereNull('returned_at')
                ->whereDate('due_at', '>=', now()->toDateString())
                ->whereDate('due_at', '<=', now()->addDays(3)->toDateString())
                ->orderBy('due_at')
                ->get();

            $overdueLoans = Loan::query()
                ->with('book')
                ->where('user_id', $selectedUser->id)
                ->whereNull('returned_at')
                ->whereDate('due_at', '<', now()->toDateString())
                ->orderBy('due_at')
                ->get();
        }

        $forumPosts = ForumPost::query()
            ->with(['user', 'comments.user'])
            ->latest()
            ->take(12)
            ->get();

        $galleryItems = GalleryItem::query()->orderBy('id')->get();
        $faqs = Faq::query()->orderBy('sort_order')->orderBy('id')->get();

        $stats = [
            'book_total' => Book::query()->count(),
            'book_available' => Book::query()->where('is_available', true)->count(),
            'active_loans' => Loan::query()
                ->whereNull('returned_at')
                ->whereIn('status', ['borrowed', 'overdue'])
                ->whereHas('book', fn ($query) => $query->where('is_available', false))
                ->distinct('book_id')
                ->count('book_id'),
            'digital_total' => DigitalResource::query()->count(),
        ];

        return [
            'books' => $books,
            'categories' => $categories,
            'resources' => $resources,
            'announcements' => $announcements,
            'events' => $events,
            'users' => $users,
            'selectedUser' => $selectedUser,
            'loanHistory' => $loanHistory,
            'wishlist' => $wishlist,
            'userReviews' => $userReviews,
            'dueSoonLoans' => $dueSoonLoans,
            'overdueLoans' => $overdueLoans,
            'forumPosts' => $forumPosts,
            'galleryItems' => $galleryItems,
            'faqs' => $faqs,
            'stats' => $stats,
            'studentUser' => $selectedUser,
            'filters' => $request->only(['search', 'category_id', 'genre', 'language', 'availability']),
        ];
    }

    public function borrow(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'book_id' => ['required', 'exists:books,id'],
            'due_at' => ['required', 'date', 'after_or_equal:today'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $studentUserId = (int) $request->session()->get('student_user_id', 0);

        if ($studentUserId <= 0 || $studentUserId !== (int) $data['user_id']) {
            return back()->with('error', 'Silakan login sebagai siswa terlebih dahulu untuk meminjam buku.');
        }

        $book = Book::query()->findOrFail($data['book_id']);

        if (! $book->is_available) {
            return redirect()
                ->route('library.katalog', ['user_id' => $data['user_id']])
                ->with('error', 'Buku sedang dipinjam oleh anggota lain.');
        }

        Loan::query()->create([
            'user_id' => $data['user_id'],
            'book_id' => $data['book_id'],
            'borrowed_at' => now()->toDateString(),
            'due_at' => $data['due_at'],
            'status' => 'borrowed',
            'notes' => $data['notes'] ?? null,
        ]);

        $book->update(['is_available' => false]);

        return redirect()
            ->route('library.katalog', ['user_id' => $data['user_id']])
            ->with('success', 'Peminjaman berhasil disimpan.');
    }

    public function returnLoan(Loan $loan): RedirectResponse
    {
        if ($loan->returned_at) {
            return redirect()
                ->route('library.katalog', ['user_id' => $loan->user_id])
                ->with('info', 'Pinjaman ini sudah dikembalikan sebelumnya.');
        }

        $loan->update([
            'returned_at' => now()->toDateString(),
            'status' => 'returned',
        ]);

        $book = $loan->book;

        if ($book && ! Loan::query()->where('book_id', $book->id)->whereNull('returned_at')->exists()) {
            $book->update(['is_available' => true]);
        }

        return redirect()
            ->route('library.katalog', ['user_id' => $loan->user_id])
            ->with('success', 'Pengembalian buku berhasil diproses.');
    }

    public function addWishlist(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'book_id' => ['required', 'exists:books,id'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $wishlist = Wishlist::query()->firstOrCreate(
            [
                'user_id' => $data['user_id'],
                'book_id' => $data['book_id'],
            ],
            [
                'notes' => $data['notes'] ?? null,
            ],
        );

        if (! $wishlist->wasRecentlyCreated && ! empty($data['notes'])) {
            $wishlist->update(['notes' => $data['notes']]);
        }

        $message = $wishlist->wasRecentlyCreated
            ? 'Buku berhasil ditambahkan ke wishlist.'
            : 'Wishlist sudah ada, catatan berhasil diperbarui.';

        return redirect()
            ->route('library.katalog', ['user_id' => $data['user_id']])
            ->with('success', $message);
    }

    public function addReview(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'book_id' => ['required', 'exists:books,id'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'review' => ['nullable', 'string', 'max:2000'],
        ]);

        Review::query()->updateOrCreate(
            [
                'user_id' => $data['user_id'],
                'book_id' => $data['book_id'],
            ],
            [
                'rating' => $data['rating'],
                'review' => $data['review'] ?? null,
            ],
        );

        return redirect()
            ->route('library.katalog', ['user_id' => $data['user_id']])
            ->with('success', 'Review dan rating berhasil disimpan.');
    }

    public function storeForumPost(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:150'],
            'topic' => ['nullable', 'string', 'max:100'],
            'content' => ['required', 'string', 'max:4000'],
            'is_recommendation' => ['nullable', 'boolean'],
        ]);

        ForumPost::query()->create([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'topic' => $data['topic'] ?? null,
            'content' => $data['content'],
            'is_recommendation' => (bool) ($data['is_recommendation'] ?? false),
        ]);

        return redirect()
            ->route('library.forum', ['user_id' => $data['user_id']])
            ->with('success', 'Diskusi baru berhasil dipublikasikan.');
    }

    public function storeForumComment(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'forum_post_id' => ['required', 'exists:forum_posts,id'],
            'content' => ['required', 'string', 'max:2000'],
        ]);

        ForumComment::query()->create($data);

        return redirect()
            ->route('library.forum', ['user_id' => $data['user_id']])
            ->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function updateProfile(Request $request, User $user): RedirectResponse
    {
        $profileId = optional($user->profile)->id;

        $data = $request->validate([
            'member_id' => ['nullable', 'string', 'max:50', Rule::unique('user_profiles', 'member_id')->ignore($profileId)],
            'class_name' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:1000'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        UserProfile::query()->updateOrCreate(
            ['user_id' => $user->id],
            $data,
        );

        return redirect()
            ->route('library.katalog', ['user_id' => $user->id])
            ->with('success', 'Profil anggota berhasil diperbarui.');
    }
}
