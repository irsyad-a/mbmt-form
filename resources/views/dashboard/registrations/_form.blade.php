@php
    $hasAllergy = old('has_allergy', $registration->has_allergy ?? false);
    $integrityAcceptedAt = old('integrity_accepted_at');

    if (! $integrityAcceptedAt && ! empty($registration->integrity_accepted_at)) {
        $integrityAcceptedAt = $registration->integrity_accepted_at->format('Y-m-d\TH:i');
    }
@endphp

<div class="grid">
    <div class="field">
        <label for="name">Nama</label>
        <input id="name" name="name" type="text" value="{{ old('name', $registration->name ?? '') }}" required>
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="field">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $registration->email ?? '') }}" required>
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="field">
        <label for="nrp">NRP (10 digit)</label>
        <input id="nrp" name="nrp" type="text" maxlength="10" value="{{ old('nrp', $registration->nrp ?? '') }}" required>
        @error('nrp')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="field">
        <label for="phone">No. Telepon</label>
        <input id="phone" name="phone" type="text" value="{{ old('phone', $registration->phone ?? '') }}" required>
        @error('phone')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="field">
        <label for="faculty">Fakultas</label>
        <input id="faculty" name="faculty" type="text" value="{{ old('faculty', $registration->faculty ?? '') }}" required>
        @error('faculty')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="field">
        <label for="department">Departemen</label>
        <input id="department" name="department" type="text" value="{{ old('department', $registration->department ?? '') }}" required>
        @error('department')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="field">
        <label for="major">Jurusan / Prodi</label>
        <input id="major" name="major" type="text" value="{{ old('major', $registration->major ?? '') }}" required>
        @error('major')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="field">
        <label for="ukm">UKM Asal</label>
        <input id="ukm" name="ukm" type="text" value="{{ old('ukm', $registration->ukm ?? '') }}" required>
        @error('ukm')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="field full">
        <input type="hidden" name="has_allergy" value="0">
        <label class="checkbox-row" for="has_allergy">
            <input id="has_allergy" name="has_allergy" type="checkbox" value="1" @checked((bool) $hasAllergy)>
            Memiliki alergi
        </label>
        @error('has_allergy')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="field full">
        <label for="allergy_description">Deskripsi alergi</label>
        <textarea id="allergy_description" name="allergy_description" rows="4">{{ old('allergy_description', $registration->allergy_description ?? '') }}</textarea>
        @error('allergy_description')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="field full">
        <label for="integrity_accepted_at">Waktu persetujuan pakta integritas</label>
        <input id="integrity_accepted_at" name="integrity_accepted_at" type="datetime-local" value="{{ $integrityAcceptedAt }}">
        <div class="muted">Jika kosong, sistem otomatis mengisi waktu saat simpan.</div>
        @error('integrity_accepted_at')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>
</div>

<div style="display:flex; justify-content:space-between; margin-top: 18px; gap: 8px; flex-wrap: wrap;">
    <a href="{{ route('dashboard.registrations.index') }}" class="btn btn-secondary">Kembali</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>
