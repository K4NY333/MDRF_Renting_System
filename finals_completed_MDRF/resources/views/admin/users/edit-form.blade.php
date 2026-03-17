<form method="POST" action="{{ route('admin.users.update', $user->id) }}">
    @csrf
    <div class="filter-group">
        <label>Name</label>
        <input name="name" class="form-control" value="{{ $user->name }}">
    </div>
    <div class="filter-group">
        <label>Email</label>
        <input name="email" class="form-control" value="{{ $user->email }}">
    </div>
    <div class="filter-group">
        <label>Role</label>
        <select name="role" class="form-control">
            <option value="tenant" {{ $user->role === 'tenant' ? 'selected' : '' }}>Tenant</option>
            <option value="owner" {{ $user->role === 'owner' ? 'selected' : '' }}>Owner</option>
            <option value="staff" {{ $user->role === 'staff' ? 'selected' : '' }}>Staff</option>
        </select>
    </div>
    <button type="submit" class="btn edit-button">Update</button>
</form>
