<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
        <h2 style="color: #430a1e; margin-top: 0;">New Contact Message</h2>
    </div>
    
    <div style="background: #fff; padding: 20px; border: 1px solid #e5e7eb; border-radius: 8px;">
        <p><strong>Name:</strong> {{ $contact->name }}</p>
        <p><strong>Email:</strong> {{ $contact->email }}</p>
        <p><strong>Date:</strong> {{ $contact->created_at->format('F d, Y h:i A') }}</p>
        
        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <p><strong>Message:</strong></p>
            <p style="white-space: pre-wrap; background: #f8f9fa; padding: 15px; border-radius: 4px;">{{ $contact->message }}</p>
        </div>
    </div>
    
    <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; font-size: 12px; color: #666;">
        <p>This is an automated message from Haul Haus Bags contact form.</p>
    </div>
</body>
</html>


