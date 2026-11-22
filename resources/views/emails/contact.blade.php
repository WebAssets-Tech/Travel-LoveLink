<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $contactData['subject'] ?? 'New Form Submission' }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 20px 10px;
            color: #334155;
            -webkit-font-smoothing: antialiased;
        }
        .email-container {
            max-width: 620px;
            background: #ffffff;
            margin: 0 auto;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(11, 61, 145, 0.08);
            border: 1px solid #e2e8f0;
        }
        .header {
            background: #0B3D91;
            background: linear-gradient(135deg, #072355 0%, #0B3D91 100%);
            color: #ffffff;
            text-align: center;
            padding: 24px 20px 20px;
            border-bottom: 3px solid #ddab43;
        }
        .header-badge {
            display: inline-block;
            background: rgba(221, 171, 67, 0.25);
            color: #fbd38d;
            border: 1px solid rgba(221, 171, 67, 0.45);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 3px 10px;
            border-radius: 20px;
            margin-bottom: 8px;
        }
        .header h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.01em;
        }
        .content {
            padding: 24px 22px;
        }
        .section-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #0B3D91;
            margin: 0 0 10px 0;
            display: block;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }
        .data-table tr {
            border-bottom: 1px solid #edf2f7;
        }
        .data-table tr:last-child {
            border-bottom: none;
        }
        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .data-table td.label-cell {
            padding: 10px 14px;
            font-weight: 700;
            font-size: 12.5px;
            color: #475569;
            width: 38%;
            vertical-align: middle;
            border-right: 1px solid #f1f5f9;
        }
        .data-table td.val-cell {
            padding: 10px 14px;
            font-size: 13px;
            color: #0f172a;
            font-weight: 600;
            vertical-align: middle;
        }
        .message-box {
            background: #f8fafc;
            border-left: 4px solid #0B3D91;
            border-radius: 6px;
            padding: 14px 16px;
            color: #334155;
            font-size: 13.5px;
            line-height: 1.65;
            white-space: pre-line;
            margin-bottom: 22px;
            word-break: break-word;
        }
        .action-row {
            text-align: center;
            margin: 24px 0 10px;
        }
        .btn {
            display: inline-block;
            padding: 11px 18px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            margin: 4px;
        }
        .btn-whatsapp {
            background: #25D366;
            color: #ffffff !important;
        }
        .btn-call {
            background: #0B3D91;
            color: #ffffff !important;
        }
        .btn-email {
            background: #475569;
            color: #ffffff !important;
        }
        .footer {
            background: #f8fafc;
            text-align: center;
            padding: 16px 20px;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            line-height: 1.5;
        }
        .footer p {
            margin: 3px 0;
        }
    </style>
</head>
<body>

@php
    $rawMessage = trim($contactData['message'] ?? '');
    $isPackageBooking = false;
    $bookingItems = [];

    // Check if the message is from the package booking form
    if (str_contains(strtolower($contactData['subject'] ?? ''), 'package booking') || str_contains($rawMessage, 'Package:')) {
        $isPackageBooking = true;
    }

    // Parse lines into key-value pairs if structured
    $lines = explode("\n", $rawMessage);
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || str_starts_with($line, '---') || strtolower($line) === 'package booking request:') {
            continue;
        }
        if (str_contains($line, ':')) {
            $parts = explode(':', $line, 2);
            $key = trim($parts[0]);
            $val = trim($parts[1]);
            if (!empty($key) && !empty($val)) {
                $bookingItems[$key] = $val;
            }
        }
    }

    $guestPhone = !empty($contactData['number']) ? preg_replace('/[^0-9]/', '', $contactData['number']) : '';
    $guestEmail = !empty($contactData['email']) ? trim($contactData['email']) : '';
    $isFallbackEmail = str_contains(strtolower($guestEmail), 'lovelink') || str_contains(strtolower($guestEmail), 'booking@');
@endphp

    <div class="email-container">
        <!-- Header -->
        <div class="header">
            @if($isPackageBooking)
                <span class="header-badge">Tour Package Booking</span>
                <h2>New Booking Enquiry Received</h2>
            @else
                <span class="header-badge">Website Contact</span>
                <h2>New Contact Form Submission</h2>
            @endif
        </div>

        <div class="content">
            <!-- Basic Details Table -->
            <span class="section-title">Contact Information</span>
            <table class="data-table">
                <tr>
                    <td class="label-cell">Guest Name</td>
                    <td class="val-cell"><strong>{{ $contactData['name'] ?? 'Guest' }}</strong></td>
                </tr>
                <tr>
                    <td class="label-cell">Phone Number</td>
                    <td class="val-cell">
                        @if(!empty($contactData['number']))
                            <a href="tel:{{ $contactData['number'] }}" style="color: #0B3D91; text-decoration: none; font-weight: 700;">{{ $contactData['number'] }}</a>
                        @else
                            <span style="color: #94a3b8;">N/A</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Email Address</td>
                    <td class="val-cell">
                        @if(!empty($contactData['email']))
                            <a href="mailto:{{ $contactData['email'] }}" style="color: #0B3D91; text-decoration: none;">{{ $contactData['email'] }}</a>
                            @if($isFallbackEmail)
                                <span style="font-size: 11px; color: #94a3b8; display: block; font-weight: normal;">(Default System Email)</span>
                            @endif
                        @else
                            <span style="color: #94a3b8;">N/A</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Subject</td>
                    <td class="val-cell">{{ $contactData['subject'] ?? 'Package Booking' }}</td>
                </tr>
            </table>

            <!-- Booking Breakdown or Message -->
            @if($isPackageBooking && !empty($bookingItems))
                <span class="section-title">Package & Travel Details</span>
                <table class="data-table">
                    @foreach($bookingItems as $key => $val)
                        <tr>
                            <td class="label-cell">{{ $key }}</td>
                            <td class="val-cell"><strong>{{ $val }}</strong></td>
                        </tr>
                    @endforeach
                </table>
            @else
                <span class="section-title">Message Content</span>
                <div class="message-box">
                    {!! nl2br(e($contactData['message'] ?? '')) !!}
                </div>
            @endif

            <!-- Quick Action Buttons -->
            <div class="action-row">
                @if(!empty($guestPhone))
                    <a href="https://wa.me/{{ (strlen($guestPhone) == 10 ? '91' : '') . $guestPhone }}" class="btn btn-whatsapp" target="_blank">
                        💬 WhatsApp Guest
                    </a>
                    <a href="tel:{{ $contactData['number'] }}" class="btn btn-call">
                        📞 Call Guest
                    </a>
                @endif
                @if(!empty($guestEmail) && !$isFallbackEmail)
                    <a href="mailto:{{ $guestEmail }}" class="btn btn-email">
                        ✉️ Reply via Email
                    </a>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This is an automated notification from your website booking desk.</p>
            <p>&copy; {{ date('Y') }} {{ $setting->name ?? 'Love Link Tour & Travels' }}. All Rights Reserved.</p>
        </div>
    </div>

</body>
</html>
