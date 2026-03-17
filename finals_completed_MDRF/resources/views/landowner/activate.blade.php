
<form class="auth-group" method="POST" action="{{ route('landowner.activate') }}">
    @csrf
    <input type="text" name="activation_code" placeholder="Enter your activation code" required>
    <button class ="auth-button"type="submit">Activate</button>
</form>
