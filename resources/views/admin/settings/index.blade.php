@extends('admin.layouts.app')

@section('content')
<h2 class="mb-3">Modul Pengaturan</h2>
<div class="card app-card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Sistem</label>
                    <input class="form-control" name="system_name" value="{{ old('system_name', $setting->system_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Logo (path/url)</label>
                    <input class="form-control" name="system_logo" value="{{ old('system_logo', $setting->system_logo) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Telepon</label>
                    <input class="form-control" name="phone" value="{{ old('phone', $setting->phone) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Denda per Hari</label>
                    <input type="number" min="0" step="0.01" class="form-control" name="fine_per_day" value="{{ old('fine_per_day', $setting->fine_per_day) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Durasi Pinjam (hari)</label>
                    <input type="number" min="1" class="form-control" name="loan_duration_days" value="{{ old('loan_duration_days', $setting->loan_duration_days) }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" rows="3" name="address">{{ old('address', $setting->address) }}</textarea>
                </div>
            </div>

            <button class="btn btn-primary mt-3" type="submit">Simpan Pengaturan</button>
        </form>
    </div>
</div>
@endsection
