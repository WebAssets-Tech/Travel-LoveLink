{{-- resources/views/emails/global-booking.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Booking Enquiry</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee;">
        <h2 style="color: #1a2942;">New {{ ucfirst($booking['booking_type']) }} Enquiry</h2>

        <table style="width: 100%; border-collapse: collapse;">
            @if($booking['booking_type'] === 'cab')
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Pickup Location:</td>
                    <td style="padding: 8px 0;">{{ $booking['pickup_location'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Drop Location:</td>
                    <td style="padding: 8px 0;">{{ $booking['drop_location'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Pick-up Time:</td>
                    <td style="padding: 8px 0;">{{ $booking['pickup_time'] ?? '-' }}</td>
                </tr>
            @else
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Location:</td>
                    <td style="padding: 8px 0;">{{ $booking['hotel_location'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Rooms:</td>
                    <td style="padding: 8px 0;">{{ $booking['rooms'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Kids:</td>
                    <td style="padding: 8px 0;">{{ $booking['kids'] ?? 0 }}</td>
                </tr>
            @endif
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Check-in:</td>
                <td style="padding: 8px 0;">{{ $booking['checkin_date'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Check-out:</td>
                <td style="padding: 8px 0;">{{ $booking['checkout_date'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Adults:</td>
                <td style="padding: 8px 0;">{{ $booking['adults'] }}</td>
            </tr>
        </table>

        <p style="margin-top: 20px; font-size: 13px; color: #888;">
            This is an automated notification. Please log into the admin panel to view full details and update status.
        </p>
    </div>
</body>
</html>