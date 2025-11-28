<h2>New Fabric Swatch Request</h2>

<p><strong>Product Code:</strong> {{ $swatch->product->product_code ?? 'N/A' }}</p>
<p><strong>Product Name:</strong> {{ $swatch->product->name ?? 'N/A' }}</p>
<hr>
<p><strong>Name:</strong> {{ $swatch->name }}</p>
<p><strong>Email:</strong> {{ $swatch->email }}</p>
<p><strong>Phone:</strong> {{ $swatch->phone_country }} {{ $swatch->phone_number }}</p>
<p><strong>Address:</strong> {{ $swatch->address }}</p>
<p><strong>Message:</strong> {{ $swatch->message }}</p>