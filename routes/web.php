<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\BookCopyController;
use App\Http\Controllers\Admin\BorrowingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DigitalResourceController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FineController;
use App\Http\Controllers\Admin\ForumController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\LibraryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LibraryController::class, 'index'])->name('library.index');
Route::get('/katalog', [LibraryController::class, 'katalog'])->name('library.katalog');
Route::get('/artikel-jurnal', [LibraryController::class, 'artikel'])->name('library.artikel');
Route::get('/pengumuman', [LibraryController::class, 'pengumuman'])->name('library.pengumuman');
Route::get('/login', [LibraryController::class, 'login'])->name('library.login');
Route::post('/login', [LibraryController::class, 'loginStudent'])->name('library.login.attempt');
Route::post('/logout', [LibraryController::class, 'logoutStudent'])->name('library.logout');
Route::get('/register', [LibraryController::class, 'register'])->name('library.register');
Route::post('/register', [LibraryController::class, 'registerStudent'])->name('library.register.store');
Route::get('/forum', [LibraryController::class, 'forum'])->name('library.forum');
Route::get('/galeri', [LibraryController::class, 'galeri'])->name('library.galeri');
Route::get('/faq', [LibraryController::class, 'faq'])->name('library.faq');

Route::post('/loans', [LibraryController::class, 'borrow'])->name('loans.store');
Route::patch('/loans/{loan}/return', [LibraryController::class, 'returnLoan'])->name('loans.return');

Route::post('/wishlists', [LibraryController::class, 'addWishlist'])->name('wishlists.store');
Route::post('/reviews', [LibraryController::class, 'addReview'])->name('reviews.store');

Route::post('/forum-posts', [LibraryController::class, 'storeForumPost'])->name('forum-posts.store');
Route::post('/forum-comments', [LibraryController::class, 'storeForumComment'])->name('forum-comments.store');

Route::post('/profiles/{user}', [LibraryController::class, 'updateProfile'])->name('profiles.update');

Route::prefix('admin')->name('admin.')->group(function (): void {
	Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
	Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

	Route::middleware('staff.auth')->group(function (): void {
		Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

		Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
		Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

		Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
		Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
		Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
		Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

		Route::get('/publishers', [PublisherController::class, 'index'])->name('publishers.index');
		Route::post('/publishers', [PublisherController::class, 'store'])->name('publishers.store');
		Route::put('/publishers/{publisher}', [PublisherController::class, 'update'])->name('publishers.update');
		Route::delete('/publishers/{publisher}', [PublisherController::class, 'destroy'])->name('publishers.destroy');

		Route::get('/books', [AdminBookController::class, 'index'])->name('books.index');
		Route::post('/books', [AdminBookController::class, 'store'])->name('books.store');
		Route::put('/books/{book}', [AdminBookController::class, 'update'])->name('books.update');
		Route::delete('/books/{book}', [AdminBookController::class, 'destroy'])->name('books.destroy');

		Route::get('/copies', [BookCopyController::class, 'index'])->name('copies.index');
		Route::post('/copies', [BookCopyController::class, 'store'])->name('copies.store');
		Route::put('/copies/{copy}', [BookCopyController::class, 'update'])->name('copies.update');
		Route::delete('/copies/{copy}', [BookCopyController::class, 'destroy'])->name('copies.destroy');

		Route::get('/members', [MemberController::class, 'index'])->name('members.index');
		Route::post('/members', [MemberController::class, 'store'])->name('members.store');
		Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
		Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');

		Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
		Route::post('/borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
		Route::put('/borrowings/{borrowing}', [BorrowingController::class, 'update'])->name('borrowings.update');
		Route::delete('/borrowings/{borrowing}', [BorrowingController::class, 'destroy'])->name('borrowings.destroy');

		Route::get('/returns', [ReturnController::class, 'index'])->name('returns.index');
		Route::post('/returns', [ReturnController::class, 'store'])->name('returns.store');
		Route::put('/returns/{return}', [ReturnController::class, 'update'])->name('returns.update');
		Route::delete('/returns/{return}', [ReturnController::class, 'destroy'])->name('returns.destroy');

		Route::get('/fines', [FineController::class, 'index'])->name('fines.index');
		Route::post('/fines', [FineController::class, 'store'])->name('fines.store');
		Route::put('/fines/{fine}', [FineController::class, 'update'])->name('fines.update');
		Route::delete('/fines/{fine}', [FineController::class, 'destroy'])->name('fines.destroy');

		Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
		Route::get('/reports/print/{type}', [ReportController::class, 'print'])->name('reports.print');
		Route::get('/reports/download/{type}', [ReportController::class, 'download'])->name('reports.download');

		Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
		Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

		Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
		Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

		// Content Management Routes
		Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
		Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
		Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
		Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
		Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
		Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

		Route::get('/digital-resources', [DigitalResourceController::class, 'index'])->name('digital-resources.index');
		Route::get('/digital-resources/create', [DigitalResourceController::class, 'create'])->name('digital-resources.create');
		Route::post('/digital-resources', [DigitalResourceController::class, 'store'])->name('digital-resources.store');
		Route::get('/digital-resources/{digitalResource}/edit', [DigitalResourceController::class, 'edit'])->name('digital-resources.edit');
		Route::put('/digital-resources/{digitalResource}', [DigitalResourceController::class, 'update'])->name('digital-resources.update');
		Route::delete('/digital-resources/{digitalResource}', [DigitalResourceController::class, 'destroy'])->name('digital-resources.destroy');

		Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
		Route::get('/forum/{post}/edit', [ForumController::class, 'edit'])->name('forum.edit');
		Route::put('/forum/{post}', [ForumController::class, 'update'])->name('forum.update');
		Route::delete('/forum/{post}', [ForumController::class, 'destroy'])->name('forum.destroy');

		Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
		Route::get('/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
		Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
		Route::get('/gallery/{item}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
		Route::put('/gallery/{item}', [GalleryController::class, 'update'])->name('gallery.update');
		Route::delete('/gallery/{item}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

		Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
		Route::get('/faq/create', [FaqController::class, 'create'])->name('faq.create');
		Route::post('/faq', [FaqController::class, 'store'])->name('faq.store');
		Route::get('/faq/{faq}/edit', [FaqController::class, 'edit'])->name('faq.edit');
		Route::put('/faq/{faq}', [FaqController::class, 'update'])->name('faq.update');
		Route::delete('/faq/{faq}', [FaqController::class, 'destroy'])->name('faq.destroy');
	});
});
