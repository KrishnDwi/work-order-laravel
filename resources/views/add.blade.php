<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Work Order</title>
    <style>
        :root {
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f8fafc;
            color: #111827;
        }
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            min-height: 100vh;
            background: #f1f5f9;
        }
        a {
            color: inherit;
            text-decoration: none;
        }
        nav {
            background: #111827;
            color: #f9fafb;
            padding: 1rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        nav .container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav .brand {
            font-weight: 700;
            font-size: 1.25rem;
        }
        nav .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        nav .nav-links a {
            color: #d1d5db;
            transition: color 0.2s ease;
        }
        nav .nav-links a:hover,
        nav .nav-links a.active {
            color: #f9fafb;
        }
        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 0.5rem;
            background: none;
            border: none;
        }
        .hamburger span {
            width: 25px;
            height: 3px;
            background: #d1d5db;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(10px, 10px);
        }
        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }
        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }
        @media (max-width: 768px) {
            nav .nav-links {
                position: absolute;
                top: 60px;
                left: 0;
                right: 0;
                background: #1f2937;
                flex-direction: column;
                gap: 0;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
            }
            nav .nav-links.active {
                max-height: 300px;
            }
            nav .nav-links a {
                display: block;
                padding: 1rem 1.5rem;
                border-bottom: 1px solid rgba(255,255,255,0.1);
            }
            .hamburger {
                display: flex;
            }
            .page {
                padding: 2rem 1rem;
            }
        }
        .page {
            max-width: 920px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }
        .card {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid #e2e8f0;
        }
        h1 {
            margin: 0 0 0.5rem;
            font-size: clamp(1.75rem, 2.5vw, 2.5rem);
        }
        p.lead {
            margin: 0 0 1.75rem;
            color: #475569;
            line-height: 1.75;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }
        .grid-full {
            grid-column: 1 / -1;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #0f172a;
        }
        input,
        textarea,
        select {
            width: 100%;
            border-radius: 0.75rem;
            border: 1px solid #cbd5e1;
            padding: 0.95rem 1rem;
            background: #f8fafc;
            color: #0f172a;
            font-size: 0.95rem;
        }
        textarea {
            min-height: 160px;
            resize: vertical;
        }
        .actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 1.5rem;
        }
        button {
            border: none;
            border-radius: 9999px;
            background: #2563eb;
            color: white;
            padding: 0.95rem 1.5rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s ease, background 0.2s ease;
        }
        button:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }
        .alert {
            margin-bottom: 1.5rem;
            padding: 1rem 1.25rem;
            border-radius: 0.85rem;
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .error-list {
            margin-bottom: 1.5rem;
            padding: 1rem 1.25rem;
            border-radius: 0.85rem;
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .info-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            color: #1e40af;
        }
        @media (max-width: 720px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
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
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>
    <div class="page">
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
                            <option value="FB Kitchen" {{ old('department') == 'FB Kitchen' ? 'selected' : '' }}>FB Kitchen</option>
                            <option value="Housekeeping" {{ old('department') == 'Housekeeping' ? 'selected' : '' }}>Housekeeping</option>
                            <option value="Front Office" {{ old('department') == 'Front Office' ? 'selected' : '' }}>Front Office</option>
                            <option value="DT" {{ old('department') == 'DT' ? 'selected' : '' }}>DT</option>
                            <option value="FB Service" {{ old('department') == 'FB Service' ? 'selected' : '' }}>FB Service</option>
                            <option value="P&C" {{ old('department') == 'P&C' ? 'selected' : '' }}>P&C</option>
                            <option value="Security" {{ old('department') == 'Security' ? 'selected' : '' }}>Security</option>
                            <option value="Sales" {{ old('department') == 'Sales' ? 'selected' : '' }}>Sales</option>
                            <option value="Acct" {{ old('department') == 'Acct' ? 'selected' : '' }}>Acct</option>
                            <option value="A&G" {{ old('department') == 'A&G' ? 'selected' : '' }}>A&G</option>
                        </select>
                    </div>
                    <div>
                        <label for="issue_type">Jenis Masalah</label>
                        <select id="issue_type" name="issue_type" required>
                            <option value="">Pilih jenis masalah</option>
                            <option value="ELECTRICAL" {{ old('issue_type') == 'ELECTRICAL' ? 'selected' : '' }}>ELECTRICAL</option>
                            <option value="MECHANICAL" {{ old('issue_type') == 'MECHANICAL' ? 'selected' : '' }}>MECHANICAL</option>
                            <option value="PLUMBING" {{ old('issue_type') == 'PLUMBING' ? 'selected' : '' }}>PLUMBING</option>
                            <option value="HVAC" {{ old('issue_type') == 'HVAC' ? 'selected' : '' }}>HVAC</option>
                            <option value="BUILDING" {{ old('issue_type') == 'BUILDING' ? 'selected' : '' }}>BUILDING</option>
                            <option value="FURNITURE" {{ old('issue_type') == 'FURNITURE' ? 'selected' : '' }}>FURNITURE</option>
                            <option value="AV" {{ old('issue_type') == 'AV' ? 'selected' : '' }}>AV</option>
                            <option value="SAFETY" {{ old('issue_type') == 'SAFETY' ? 'selected' : '' }}>SAFETY</option>
                            <option value="OTHER" {{ old('issue_type') == 'OTHER' ? 'selected' : '' }}>OTHER</option>
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
                    <div style="margin-bottom: 1rem;">
                        <label for="image" style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Lampirkan Foto (Opsional)</label>
                        <input type="file" name="image" id="image" accept="image/*" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 0.5rem;">
                        <small style="color: #666;">Batas maksimal 5MB. Format: JPG, JPEG, PNG.</small>
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

            hamburger?.addEventListener('click', function() {
                hamburger.classList.toggle('active');
                navLinks.classList.toggle('active');
            });

            const navAnchors = document.querySelectorAll('.nav-links a');
            navAnchors.forEach(anchor => {
                anchor.addEventListener('click', function() {
                    hamburger.classList.remove('active');
                    navLinks.classList.remove('active');
                });
            });
        });
    </script>
</body>
</html>