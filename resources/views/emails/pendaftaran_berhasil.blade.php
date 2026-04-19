<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pengisian Form - MBMT 2026</title>
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

    @php
        $headerSrc = isset($message) && method_exists($message, 'embed') 
            ? $message->embed(public_path('assets/Header-email.png')) 
            : asset('assets/Header-email.png');
            
        $footerSrc = isset($message) && method_exists($message, 'embed') 
            ? $message->embed(public_path('assets/Footer-email.png')) 
            : asset('assets/Footer-email.png');
    @endphp

    <table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" style="background-color: #f4f6f9; padding: 20px 10px;">
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
                            
                            <h1 style="margin: 0 0 30px 0; text-align: center; color: #243e88; font-size: 26px; font-weight: 800; letter-spacing: 1px; font-family: 'Arial Black', Impact, sans-serif; text-transform: uppercase;">
                                Bukti Pengisian Form
                            </h1>

                            <p style="margin: 0 0 20px 0; font-size: 18px; font-weight: 700; color: #000000;">
                                Halo, {{ $data['nama'] ?? '{nama}' }}
                            </p>
                            
                            <p style="margin: 0 0 25px 0; font-weight: 400;">
                                Anda telah melakukan pendaftaran pada acara "Minat Bakat Media Training" yang diselenggarakan pada:
                            </p>
                            
                            <p style="margin: 0 0 25px 0; font-weight: 700; color: #000000;">
                                Waktu: 16 Mei 2026, 08.00 WIB<br>
                                Tempat: Teater A ITS
                            </p>
                            
                            <p style="margin: 0 0 20px 0; font-weight: 400;">
                                Jika ada perubahan informasi terkait acara, kami akan secepatnya mengirimkan informasi kepada Anda. Oleh karena itu, Anda diharapkan untuk masuk ke grup komunal:
                            </p>

                            <!-- LINK GRUP -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom: 25px;">
                                <tr>
                                    <td align="left" style="background-color: #f8f9fa; border-left: 4px solid #f2a93b; padding: 15px 20px;">
                                        @if(isset($data['link_grup']) && $data['link_grup'])
                                            <a href="{{ $data['link_grup'] }}" style="color: #243e88; text-decoration: underline; font-weight: 700; font-size: 15px;">Gabung Grup Komunal</a>
                                        @else
                                            <a href="#" style="color: #243e88; text-decoration: underline; font-weight: 700; font-size: 15px;">{link grup komunal}</a>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 20px 0; font-weight: 400;">
                                Jika Anda terkendala terkait pendaftaran atau acara, silahkan hubungi:
                            </p>

                            <!-- CP PRIMER (SESUAI UKM) -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom: 30px;">
                                <tr>
                                    <td align="left" style="background-color: #f8f9fa; border-left: 4px solid #1a7a1a; padding: 15px 20px;">
                                        <p style="margin: 0 0 8px 0; font-size: 14px; color: #1a1a1a; font-weight: 700;">
                                            CP Primer (sesuai UKM): {{ $data['cp_primer_nama'] ?? '-' }}
                                        </p>
                                        @if(isset($data['cp_primer_wa']) && $data['cp_primer_wa'])
                                            <a href="{{ $data['cp_primer_wa'] }}" style="color: #1a7a1a; text-decoration: none; font-weight: 700; font-size: 15px;">Hubungi CP Primer via WhatsApp</a>
                                        @else
                                            <a href="#" style="color: #1a7a1a; text-decoration: none; font-weight: 700; font-size: 15px;">{CP primer sesuai UKM}</a>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <!-- CP SEKUNDER -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom: 30px;">
                                <tr>
                                    <td align="left" style="background-color: #f8f9fa; border-left: 4px solid #243e88; padding: 15px 20px;">
                                        <p style="margin: 0 0 8px 0; font-size: 14px; color: #1a1a1a; font-weight: 700;">
                                            CP Sekunder: {{ $data['cp_sekunder_nama'] ?? '-' }}
                                        </p>
                                        @if(isset($data['cp_sekunder_wa']) && $data['cp_sekunder_wa'])
                                            <a href="{{ $data['cp_sekunder_wa'] }}" style="color: #243e88; text-decoration: none; font-weight: 700; font-size: 15px;">Hubungi CP Sekunder via WhatsApp</a>
                                        @else
                                            <a href="#" style="color: #243e88; text-decoration: none; font-weight: 700; font-size: 15px;">{CP sekunder}</a>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- SIGNATURE -->
                            <p style="margin: 0; font-weight: 400;">Departemen Media Kreatif,</p>
                            <p style="margin: 0; font-weight: 400;">Lembaga Minat Bakat,</p>
                            <p style="margin: 0; font-weight: 400;">Institut Teknologi Sepuluh Nopember</p>

                        </td>
                    </tr>

                    <!-- FOOTER IMAGE -->
                    <tr>
                        <td align="center" style="line-height: 0; background-color: #243e88;">
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
