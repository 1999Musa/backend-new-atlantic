<h2>New Product Customization Request</h2>

<p><strong>Name:</strong> {{ $custom->name }}</p>
<p><strong>Email:</strong> {{ $custom->email }}</p>
<p><strong>Phone:</strong> {{ $custom->phone_country }} {{ $custom->phone_number }}</p>
<p><strong>Quantity:</strong> {{ $custom->quantity }}</p>
<p><strong>Message:</strong></p>
<p>{{ $custom->message }}</p>

@if($custom->attachment)
<p><strong>Attachment:</strong> Attached file included</p>
@endif
