@php
    $room = \App\Models\Room::find(request('room_id'));
    $monthlyRent = null;

    if ($room) {
        if ($room->type === 'bedspacer' && $room->capacity > 0) {
            $monthlyRent = $room->price / $room->capacity;
        } else {
            $monthlyRent = $room->price;
        }
    }
@endphp

<div style="max-width: 400px; margin: 40px auto; padding: 30px; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0 4px 8px rgba(0,0,0,0.1); font-family: Arial, sans-serif;">
    <form method="POST" action="{{ route('applicant.apply') }}"  enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="room_id" value="{{ $room ? $room->id : '' }}">
        <input type="hidden" name="room_id" value="{{ request('room_id') }}">

        <input type="text" name="name" placeholder="Name" required
            style="width: 100%; padding: 10px 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">

        <input type="email" name="email" placeholder="Email" required
            style="width: 100%; padding: 10px 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">

        <input type="password" name="password" placeholder="Password" required
            style="width: 100%; padding: 10px 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">

        <input type="text" name="contact_number" placeholder="Contact Number" 
                 maxlength="11" pattern="\d{11}"
                 title="Please enter exactly 11 digits" required
                style="width: 100%; padding: 10px 15px; margin: 10px 0; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">

        <div class="owner-group">
        <label>Upload PDF Document:</label>
        <input type="file" name="pdf_file" accept="application/pdf" required>
    </div>

    <div class="owner-group">
        <label>Upload Your Image:</label>
        <input type="file" name="image_file" accept="image/*" required>
    </div>

        <label for="start_date" style="font-size: 14px; color: #333; display: block; margin-top: 10px;">Preferred Move-in Date</label>
        <input type="date" name="start_date" required
            style="width: 100%; padding: 10px 15px; margin: 5px 0 10px 0; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">

        <label style="font-size: 14px; color: #333; margin-top: 10px;">Estimated Monthly Rent</label>
        <input type="text" value="₱{{ number_format($monthlyRent, 2) }}" readonly
            style="width: 100%; padding: 10px 15px; margin: 5px 0 10px 0; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; background-color: #eee;">

        <button type="submit"
            style="width: 100%; padding: 12px; background-color: #4CAF50; color: white; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; margin-top: 10px;">
            Apply
        </button>
    </form>

    <p style="margin-top: 20px; font-size: 14px; color: #333; text-align: center;">
        If you already submitted your form, kindly check your email for an activation code. 
        <br><br>Please proceed to the user icon to activate your account.
    </p>

    <!-- <a href="{{ route('applicant.activate') }}" 
       style="display: inline-block; width: 100%; text-align: center; padding: 12px; background-color: #2196F3; color: white; text-decoration: none; border-radius: 6px; font-size: 16px; margin-top: 10px;">
        Activate your account
    </a> -->
</div>
