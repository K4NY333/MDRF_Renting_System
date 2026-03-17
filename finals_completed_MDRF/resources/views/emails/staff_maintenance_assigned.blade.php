<p>Dear {{ $request->staff->name }},</p>

<p>You have been assigned a new maintenance task. Below are the details:</p>

<ul>
    <li><strong>Service Type:</strong> {{ ucwords(str_replace('_', ' ', $request->service_type)) }}</li>
    <li><strong>Location:</strong> Room {{ $request->room->name }} at {{ $request->room->place->name }}</li>
    <li><strong>Tenant:</strong> {{ $request->tenant->name ?? 'N/A' }}</li>
    <li><strong>Description:</strong> {{ $request->description }}</li>
    <li><strong>Status:</strong> Approved</li>
</ul>

<p>Please attend to this task promptly. Thank you for your service.</p>

<p>Regards,<br>
{{ $request->room->place->owner->name }}<br>
Property Owner</p>
