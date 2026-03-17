<!DOCTYPE html>
<html>
<head>
    <title>Applications</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f2f2f2; padding: 40px;">

    <div style="max-width: 600px; margin: auto; background-color: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <h2 style="text-align: center;">Landowner Applications</h2>

        @foreach ($applications as $application)
            <div style="padding: 15px; border-bottom: 1px solid #ccc;">
                <strong>{{ $application->name }}</strong> — <em>{{ ucfirst($application->status) }}</em>

                @if ($application->status == 'pending')
                    <form method="POST" action="{{ url('/admin/applications/' . $application->id . '/approve') }}" style="margin-top: 10px;">
                        @csrf
                        <button type="submit" 
                                style="padding: 8px 16px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
                            Approve
                        </button>
                    </form>
                @endif
            </div>
        @endforeach

        @if (count($applications) === 0)
            <p style="text-align: center; color: #777;">No applications found.</p>
        @endif
    </div>

</body>
</html>
