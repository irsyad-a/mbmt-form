<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Lembar Komitmen - MBMT 2026</title>
    <!-- Mencegah gaya auto-link pada iOS/Apple Mail -->
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <!-- Kompatibilitas Microsoft Outlook -->
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        body {
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            background-color: #f4f6f9;
        }
        table, td {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            border: 0;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
            display: block;
        }

        /* Responsive styles for mobile optimization */
        @media screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                margin: auto !important;
            }
            .content-padding {
                padding: 30px 20px !important;
            }
            h1 {
                font-size: 22px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    <!-- SETUP IMAGE FIX FOR PREVIEW VS ACTUAL EMAIL -->
    @php
        $headerSrc = isset($message) && method_exists($message, 'embed') 
            ? $message->embed(public_path('assets/Header-email.png')) 
            : asset('assets/Header-email.png');
            
        $footerSrc = isset($message) && method_exists($message, 'embed') 
            ? $message->embed(public_path('assets/Footer-email.png')) 
            : asset('assets/Footer-email.png');
    @endphp

    <!-- Background Table wrapper -->
    <table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="background-color: #f4f6f9; padding: 30px 10px;">
        <tr>
            <td align="center">

                <!--[if mso]>
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width: 600px;">
                <tr>
                <td align="center">
                <![endif]-->

                <!-- Main Canvas Content -->
                <table class="email-container" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #ffffff; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-collapse: collapse;">
                    
                    <!-- HEADER IMAGE -->
                    <tr>
                        <td align="center" style="line-height: 0; background-color: #243e88;">
                            <img src="{{ $headerSrc }}" alt="MBMT 2026 Header" width="600" style="display: block; width: 100%; max-width: 600px; height: auto;">
                        </td>
                    </tr>

                    <!-- BODY CONTENT -->
                    <tr>
                        <td class="content-padding" align="left" style="padding: 40px 30px; font-size: 15px; line-height: 1.6; color: #333333;">
                            
                            <!-- BUKTI LEMBAR KOMITMEN TITLE (Fallback text jika tdk tergabung dlm header png) -->
                            <h1 style="margin: 0 0 30px 0; text-align: center; color: #243e88; font-size: 26px; font-weight: 800; letter-spacing: 1px; font-family: 'Arial Black', Impact, sans-serif; text-transform: uppercase;">
                                Bukti Lembar Komitmen
                            </h1>

                            <p style="margin: 0 0 20px 0; font-size: 18px; font-weight: 700; color: #000000;">
                                Halo, {{ $data['nama'] ?? '{nama}' }}
                            </p>
                            
                            <p style="margin: 0 0 20px 0; font-weight: 400;">
                                Anda telah menandatangani Lembar Komitmen dari acara <strong>Minat Bakat Media Training</strong> Lembaga Minat Bakat Institut Teknologi Sepuluh Nopember.
                            </p>
                            
                            <p style="margin: 0 0 25px 0; font-weight: 400;">
                                Dengan menandatangani Lembar Komitmen ini, berarti Anda setuju untuk mematuhi peraturan dari acara Minat Bakat Media Training Lembaga Minat Bakat Institut Teknologi Sepuluh Nopember.
                            </p>
                            
                            <p style="margin: 0 0 10px 0; font-weight: 400;">
                                Berikut ini merupakan rincian Lembar Komitmen Anda:
                            </p>

                            <!-- LINK BOX -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom: 25px;">
                                <tr>
                                    <td align="left" style="background-color: #f8f9fa; border-left: 4px solid #f2a93b; padding: 15px 20px;">
                                        @if(isset($data['pdf_link']) && $data['pdf_link'])
                                            <a href="{{ $data['pdf_link'] }}" style="color: #243e88; text-decoration: underline; font-weight: 700; font-size: 15px;">Lihat / Unduh Dokumen Komitmen Anda</a>
                                        @else
                                            <a href="#" style="color: #243e88; text-decoration: underline; font-weight: 700; font-size: 15px;">{Link lembar komitmen}</a>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 30px 0; font-weight: 400;">
                                Kami selaku panitia berharap bisa bekerja sama dengan baik demi kelancaran acara ini. Terima kasih atas atensi anda terhadap surat ini.
                            </p>
                            
                            <!-- SIGNATURE -->
                            <p style="margin: 0; font-weight: 400;">Departemen Media Kreatif,</p>
                            <p style="margin: 0; font-weight: 400;">Lembaga Minat Bakat,</p>
                            <p style="margin: 0; font-weight: 400;">Institut Teknologi Sepuluh Nopember</p>

                        </td>
                    </tr>

                    <!-- FOOTER IMAGE -->
                    <tr>
                        <td align="center" style="line-height: 0; background-color: #243e88;">
                            <!-- Link ke footer image -->
                            <img src="{{ $footerSrc }}" alt="Footer Lembaga Minat Bakat ITS" width="600" style="display: block; width: 100%; max-width: 600px; height: auto;">
                        </td>
                    </tr>
                </table>

                <!--[if mso]>
                </td>
                </tr>
                </table>
                <![endif]-->

                <!-- FOOTER COPY -->
                <table class="email-container" cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width: 600px; margin: 0 auto;">
                    <tr>
                        <td align="center" style="padding: 20px 0; color: #888888; font-size: 11px; line-height: 1.4;">
                            Email ini dikirimkan secara otomatis oleh Sistem Pendaftaran MBMT 2026.<br>
                            Mohon untuk tidak membalas langsung ke alamat email ini.
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>
</html>
