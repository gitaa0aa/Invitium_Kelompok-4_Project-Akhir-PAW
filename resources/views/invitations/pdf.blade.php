<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan - {{ $invitation->letter_number }}</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background: #FFFFFF;
            margin: 0;
            padding: 0;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }
        
        .header img {
            max-height: 80px;
            margin-bottom: 10px;
        }
        
        .letter-info {
            margin-bottom: 20px;
        }
        
        .letter-info table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .letter-info td {
            padding: 2px 0;
            vertical-align: top;
            font-size: 12px;
        }
        
        .letter-info td:first-child {
            width: 80px;
            font-weight: normal;
        }
        
        .letter-info td:nth-child(2) {
            width: 20px;
            text-align: center;
        }
        
        .recipient-info {
            margin: 20px 0;
            font-size: 12px;
        }
        
        .content {
            text-align: justify;
            margin-bottom: 15px;
            line-height: 1.4;
            font-size: 12px;
        }
        
        .event-details {
            margin: 15px 0 15px 30px;
            font-size: 12px;
        }
        
        .signatures {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
            gap: 40px;
            flex-wrap: wrap;
        }
        
        .signature-item {
            text-align: center;
            min-width: 150px;
            max-width: 180px;
        }
        
        .signature-item img {
            max-width: 120px;
            max-height: 50px;
            margin-bottom: 5px;
        }
        
        .signature-line {
            border-bottom: 1px solid #000;
            width: 150px;
            margin: 40px auto 8px;
        }
        
        .closing {
            margin-top: 20px;
            text-align: justify;
            font-size: 12px;
        }
        
        .attachment-note {
            margin-top: 20px;
            font-style: normal;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .attachment-page {
            text-align: center;
            margin-top: 100px;
        }
        
        .attachment-content {
            margin: 50px 0;
        }
        
        @media print {
            body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    @if($invitation->header_file)
        <div class="header">
            @php
                $headerPath = public_path('storage/' . $invitation->header_file);
                $headerExists = file_exists($headerPath);
            @endphp
            <div style="font-weight: bold; font-size: 16px; margin-bottom: 10px;">KOP SURAT</div>
        </div>
    @endif
    
    <div class="letter-info">
        <table>
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td>{{ $invitation->letter_number }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>{{ $invitation->attachment_files && count($invitation->attachment_files) > 0 ? count($invitation->attachment_files) . ' berkas' : '-' }}</td>
            </tr>
            @if($invitation->hal)
            <tr>
                <td>Perihal</td>
                <td>:</td>
                <td>{{ $invitation->hal }}</td>
            </tr>
            @endif
        </table>
    </div>
    
    @if(isset($recipient))
        <div class="recipient-info">
            <p>Kepada Yth.<br>
            <strong>{{ $recipient->name }}</strong><br>
            {{ $recipient->position }}<br>
            {{ $recipient->affiliation }}<br>
            di Tempat</p>
        </div>
    @endif
    
    <div class="content">
        <p>Dengan hormat,</p>
        <p>{{ $invitation->content }}</p>
        
        <div class="event-details">
            <p><strong>Hari dan Tanggal:</strong> {{ $invitation->event_date->locale('id')->translatedFormat('l, d F Y') }}</p>
            <p><strong>Pukul:</strong> {{ $invitation->event_time->format('H.i') }}{{ $invitation->event_end_time ? ' s/d ' . $invitation->event_end_time->format('H.i') : ' s/d selesai' }} WIB</p>
            <p><strong>Tempat:</strong> {{ $invitation->location }}</p>
        </div>
    </div>
    
    <div class="closing">
        <p>Demikian atas kehadiran Bapak/Ibu/Saudara/i tepat pada waktunya kami ucapkan terima kasih.</p>
    </div>
    
    <div class="signatures">
        @if(count($invitation->signatures ?? []) > 0)
            @foreach(array_reverse($invitation->signatures) as $index => $signature)
                @php
                    $realIndex = count($invitation->signatures) - 1 - $index;
                    $details = $invitation->signature_details[$realIndex] ?? null;
                @endphp
                <div class="signature-item">
                    <p style="margin-bottom: 8px; font-weight: bold; font-size: 11px;">{{ $details['position'] ?? 'Penandatangan' }}</p>
                    @if($signature)
                        @php
                            $signaturePath = public_path('storage/' . $signature);
                            $signatureExists = file_exists($signaturePath);
                        @endphp
                        <div style="height: 50px;"></div>
                    @else
                        <div style="height: 50px;"></div>
                    @endif
                    <div class="signature-line"></div>
                    <p style="margin: 3px 0; font-size: 11px;"><strong>{{ $details['name'] ?? 'Nama Penandatangan' }}</strong></p>
                    @if(isset($details['nip']) && $details['nip'])
                        <p style="margin: 0; font-size: 10px;">{{ $details['nip'] }}</p>
                    @endif
                </div>
            @endforeach
        @else
            <div class="signature-item">
                <p style="margin-bottom: 8px; font-weight: bold; font-size: 11px;">Penandatangan</p>
                <div style="height: 50px;"></div>
                <div class="signature-line"></div>
                <p style="margin: 3px 0; font-size: 11px;"><strong>Nama Penandatangan</strong></p>
                <p style="margin: 0; font-size: 10px;">NIP/NIM</p>
            </div>
        @endif
    </div>
    
    @if($invitation->attachment_files && count($invitation->attachment_files) > 0)
        @foreach($invitation->attachment_files as $index => $attachment)
            <div class="page-break">
                <div class="attachment-page">
                    <h3>LAMPIRAN {{ $index + 1 }}</h3>
                    <div class="attachment-content">
                        @php
                            $attachmentPath = public_path('storage/' . $attachment);
                            $attachmentExists = file_exists($attachmentPath);
                            $extension = pathinfo($attachment, PATHINFO_EXTENSION);
                        @endphp
                        <p>Lampiran: {{ basename($attachment) }}</p>
                        <p><em>File {{ strtoupper($extension) }}</em></p>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</body>
</html>