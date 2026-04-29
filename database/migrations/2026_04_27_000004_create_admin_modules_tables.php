<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'petugas'])->default('petugas');
            $table->string('photo')->nullable();
            $table->string('phone', 30)->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('publishers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->unique();
            $table->text('address')->nullable();
            $table->string('contact', 50)->nullable();
            $table->timestamps();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreignId('publisher_id')->nullable()->after('category_id')->constrained('publishers')->nullOnDelete();
        });

        Schema::create('book_copies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->string('copy_code', 50)->unique();
            $table->unsignedInteger('quantity')->default(1);
            $table->string('rack_location', 50)->nullable();
            $table->string('condition', 50)->default('baik');
            $table->string('status', 50)->default('tersedia');
            $table->timestamps();
        });

        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('member_number', 50)->unique();
            $table->string('name', 150);
            $table->enum('member_type', ['siswa', 'guru']);
            $table->string('class_or_position', 50)->nullable();
            $table->string('contact', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_copy_id')->nullable()->constrained('book_copies')->nullOnDelete();
            $table->foreignId('staff_user_id')->nullable()->constrained('staff_users')->nullOnDelete();
            $table->date('borrowed_at');
            $table->date('due_at');
            $table->date('returned_at')->nullable();
            $table->enum('status', ['aktif', 'kembali'])->default('aktif');
            $table->timestamps();
        });

        Schema::create('return_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrowing_id')->unique()->constrained('borrowings')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->foreignId('staff_user_id')->nullable()->constrained('staff_users')->nullOnDelete();
            $table->date('due_date');
            $table->date('returned_at');
            $table->enum('book_condition', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->unsignedInteger('late_days')->default(0);
            $table->timestamps();
        });

        Schema::create('fines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->foreignId('borrowing_id')->nullable()->constrained('borrowings')->nullOnDelete();
            $table->foreignId('return_record_id')->nullable()->constrained('return_records')->nullOnDelete();
            $table->string('fine_type')->default('keterlambatan');
            $table->unsignedInteger('late_days')->default(0);
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('remaining_amount', 10, 2)->default(0);
            $table->enum('payment_status', ['dibayar', 'belum_dibayar', 'sebagian'])->default('belum_dibayar');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('system_name', 150)->default('Sistem Informasi Perpustakaan');
            $table->string('system_logo', 255)->nullable();
            $table->string('phone', 50)->nullable();
            $table->text('address')->nullable();
            $table->decimal('fine_per_day', 10, 2)->default(2000);
            $table->unsignedInteger('loan_duration_days')->default(7);
            $table->foreignId('updated_by_staff_id')->nullable()->constrained('staff_users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_settings');
        Schema::dropIfExists('fines');
        Schema::dropIfExists('return_records');
        Schema::dropIfExists('borrowings');
        Schema::dropIfExists('members');
        Schema::dropIfExists('book_copies');

        Schema::table('books', function (Blueprint $table) {
            $table->dropConstrainedForeignId('publisher_id');
        });

        Schema::dropIfExists('publishers');
        Schema::dropIfExists('staff_users');
    }
};
