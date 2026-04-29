@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Modul Profil Admin/Petugas</h2>
<div class="card app-card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.profile.update') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama</label>
                    <input class="form-control" name="name" value="{{ old('name', $staff->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email Gmail</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $staff->email) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kontak</label>
                    <input class="form-control" name="phone" value="{{ old('phone', $staff->phone) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" name="address" rows="2">{{ old('address', $staff->address) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password Baru</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" name="password_confirmation">
                </div>
            </div>

            <button class="btn btn-primary mt-3" type="submit">Simpan Profil</button>
        </form>
    </div>
</div>
@endsection
