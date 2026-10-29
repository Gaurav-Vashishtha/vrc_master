<h2>New Contact Received</h2>

<p><strong>Name:</strong> {{ $name }}</p>
<p><strong>Email:</strong> {{ $email }}</p>
<p><strong>Phone:</strong> {{ $phone }}</p>
@if($company_name!= null)
<p><strong>Company Name:</strong> {{ $company_name }}</p>
@endif
<p><strong>Subject:</strong> {{ $subject }}</p>
<p><strong>Message:</strong> {{ $messageText }}</p>