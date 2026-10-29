<h2>Thank You for Contacting Us</h2>

<p>Hi {{ $name }},</p>

<p>Thank you for contacting us. We’ve received your contact and will get back to you soon.</p>

<p><strong>Your Submitted Details:</strong></p>
<ul>
    <li><strong>Name:</strong> {{ $name }}</li>
    <li><strong>Email:</strong> {{ $email }}</li>
    <li><strong>Phone:</strong> {{ $phone }}</li>
    @if($company_name!= null)
    <li><strong>Company Name:</strong> {{ $company_name }}</li>
    @endif
    <li><strong>Subject:</strong> {{ $subject }}</li>
    <li><strong>Message:</strong> {{ $messageText }}</li>
</ul>

<p>Best regards,<br>Team</p>
