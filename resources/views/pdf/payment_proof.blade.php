<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Pendaftaran - {{ $student->full_name }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 14px; line-height: 1.5; color: #000; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px double #000; padding-bottom: 10px; position: relative; }
        .logo { width: 80px; height: auto; position: absolute; left: 0; top: 0; }
        .header h1 { font-size: 18px; font-weight: bold; margin: 0; }
        .header h2 { font-size: 20px; font-weight: bold; margin: 5px 0; }
        .header p { font-size: 12px; margin: 0; }
        .title { text-align: center; font-weight: bold; text-decoration: underline; font-size: 16px; margin: 20px 0 5px; }
        .subtitle { text-align: center; font-size: 14px; margin-bottom: 30px; font-style: italic; }
        .content { margin: 0 20px; }
        .section-title { font-weight: bold; text-align: center; margin: 20px 0 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        td { padding: 4px 0; vertical-align: top; }
        .label { width: 150px; }
        .separator { width: 20px; text-align: center; }
        .footer { margin-top: 50px; text-align: right; }
        .signature { margin-top: 60px; font-weight: bold; }
        .amount { text-align: right; width: 150px; }
        
        .total-row td { font-weight: bold; border-top: 1px solid #000; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <!-- Assuming logo is stored in public/logo.png or similar. Using text if not available or handling absolute path -->
        @if(extension_loaded('gd'))
            <img src="{{ public_path('images/logo-unit.png') }}" class="logo">
        @endif
        <p>bimbingan MINAT Baca dan Belajar Anak</p>
        <h2>biMBA - AIUEO Unit Klender</h2>
        <p>Untuk Anak Usia 3-6 Tahun</p>
        <p style="margin-top: 5px;">Jl. Delima Raya No. 99, RT 006/RW 005, Kel. Malaka Sari, Kec. Duren Sawit, Jakarta Timur, Jakarta</p>
        <p>Telp: 0815-8630-4372 | Email: bimbaaiueounitklender@gmail.com</p>
    </div>

    <div class="title">BUKTI PENDAFTARAN & PEMBAYARAN</div>
    <div class="subtitle">Nomor: {{ $payment->registration_number }}</div>

    <div class="content">
        <p>Kepada</p>
        <p>Orang Tua/Wali dari Ananda <strong>{{ $student->full_name }}</strong></p>
        
        <p style="margin-top: 15px; text-align: justify;">
            Selamat bergabung dengan biMBA AIUEO Unit Klender. Kami telah menerima pendaftaran Anda dengan keterangan sebagai berikut:
        </p>

        <div class="section-title">DATA SISWA</div>
        <table>
            <tr>
                <td class="label">Nama</td>
                <td class="separator">:</td>
                <td>{{ $student->full_name }}</td>
            </tr>
            <tr>
                <td class="label">Tempat, tanggal lahir</td>
                <td class="separator">:</td>
                <td>{{ $student->birth_place }}, {{ $student->birth_date->locale('id')->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr>
                <td class="label">NIM</td>
                <td class="separator">:</td>
                <td>{{ $student->nim ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Layanan kelas</td>
                <td class="separator">:</td>
                <td>
                    @foreach($student->classSelections->where('status', 'selected') as $selection)
                        {{ $selection->schoolClass->program ?? $selection->schoolClass->name }}/{{ $selection->schoolClass->day }}<br>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td class="label">Jam belajar</td>
                <td class="separator">:</td>
                <td>
                    @foreach($student->classSelections->where('status', 'selected') as $selection)
                        {{ $selection->schoolClass->time }}<br>
                    @endforeach
                </td>
            </tr>
        </table>

        <div class="section-title">RINCIAN PEMBAYARAN</div>
        <table>
            <tr>
                <td class="label">Biaya Pendaftaran</td>
                <td class="separator">:</td>
                <td >Rp {{ number_format($payment->registration_fee, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Biaya SPP</td>
                <td class="separator">:</td>
                <td >Rp {{ number_format($payment->spp_fee, 0, ',', '.') }}/{{ now()->locale('id')->isoFormat('MMMM') }}</td>
            </tr>
            <tr class="total-row">
                <td class="label">Total</td>
                <td class="separator">:</td>
                <td >Rp {{ number_format($payment->registration_fee + $payment->spp_fee, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Status Pembayaran</td>
                <td class="separator">:</td>
                <td style="font-weight: bold; text-transform: uppercase;">{{ $payment->status === 'verified' ? 'LUNAS' : $payment->status }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Jakarta, {{ now()->locale('id')->isoFormat('D MMMM Y') }}</p>
        <p>Kepala Program</p>
        
        <!-- Signature Space (Template Fixed) -->
        <br>
        @if(extension_loaded('gd'))
            <img src="{{ public_path('images/signature.png') }}" style="height: 80px; width: auto; display: inline-block;">
        @else
            <br><br><br>
        @endif
        <br>
        
        <p class="signature" style="text-decoration: underline; margin-top: 0;">Rosdiana</p>
    </div>
</body>
</html>
