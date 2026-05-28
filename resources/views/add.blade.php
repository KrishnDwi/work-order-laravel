<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Work Order</title>
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
</head>
<body>
    <nav>
        <div class="container">
            <div class="brand">Harris Hotel Seminyak</div>
            <ul class="nav-links">
                <li><a href="/">Dashboard</a></li>
                <li><a href="/add" class="active">Buat Work Order</a></li>
            </ul>
            <button class="hamburger">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    <div class="page-narrow">
        <div class="card">
            <h1>Form Tambah Work Order</h1>
            <p class="lead">Isi data work order baru di bawah ini untuk membuat permintaan layanan baru.</p>

            <div class="info-box">
                <strong>ℹ Nomor work order akan dihasilkan otomatis</strong> dengan format YYYYMM### (contoh: 202605001 untuk order pertama di Mei 2026) dan akan direset setiap awal bulan.
            </div>

            @if ($errors->any())
                <div class="error-list">
                    <strong>Silakan perbaiki kesalahan berikut:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/add" method="POST" enctype="multipart/form-data" target="_blank" onsubmit="setTimeout(function(){ window.location.href = '/'; }, 300);">
                @csrf
                <div class="grid">
                    <div>
                        <label for="department">Departemen</label>
                        <select id="department" name="department" required>
                            <option value="">Pilih departemen</option>
                            @foreach(["FB Kitchen","Housekeeping","Front Office","DT","FB Service","P&C","Security","Sales","Acct","A&G"] as $dept)
                                <option value="{{ $dept }}" {{ old('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="issue_type">Jenis Masalah</label>
                        <select id="issue_type" name="issue_type" required>
                            <option value="">Pilih jenis masalah</option>
                            @foreach(["ELECTRICAL","MECHANICAL","PLUMBING","HVAC","BUILDING","FURNITURE","AV","SAFETY","OTHER"] as $type)
                                <option value="{{ $type }}" {{ old('issue_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="location">Lokasi</label>
                        <input id="location" name="location" type="text" placeholder="Contoh: Ruang 101, Lantai 3" value="{{ old('location') }}">
                    </div>
                    <div class="grid-full">
                        <label for="description">Deskripsi Work Order</label>
                        <textarea id="description" name="description" placeholder="Jelaskan kebutuhan atau masalah pekerjaan...">{{ old('description') }}</textarea>
                    </div>
                    <div class="grid-full">
                        <label for="image">Lampirkan Foto (Opsional)</label>
                        <input type="file" name="image" id="image" accept="image/*">
                        <small style="color: #6b7280; display: block; margin-top: 0.35rem;">Batas maksimal 5MB. Format: JPG, JPEG, PNG.</small>
                    </div>
                </div>
                <div class="actions">
                    <button type="submit">Simpan Work Order</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.querySelector('.hamburger');
            const navLinks = document.querySelector('.nav-links');

            hamburger?.addEventListener('click', () => {
                hamburger.classList.toggle('active');
                navLinks.classList.toggle('active');
            });

            document.querySelectorAll('.nav-links a').forEach(a => {
                a.addEventListener('click', () => {
                    hamburger.classList.remove('active');
                    navLinks.classList.remove('active');
                });
            });
        });
    </script>
</body>
</html>
