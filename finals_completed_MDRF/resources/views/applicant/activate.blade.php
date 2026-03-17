
<form method="POST" action="{{ route('applicant.active') }}">
    @csrf
    <input type="text" name="activation_code" placeholder="Enter your activation code" required>
    <button type="submit">Activate</button>
</form>
