<head>
    <title>Owner | Edit Place</title>
</head>

<div>
    <h2 class="mb-4">Edit Place</h2>

    @if ($errors->any())
        <div>
            <strong>Errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('places.update', $place->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Place Name</label>
            <input type="text" name="name" required value="{{ old('name', $place->name) }}">
        </div>

        <div>
            <label for="description">Description (optional)</label>
            <textarea name="description" rows="3">{{ old('description', $place->description) }}</textarea>
        </div>

        <div>
            <label for="location">Location</label>
            <input type="text" name="location" required value="{{ old('location', $place->location) }}">
        </div>

        <div>
            <label for="type">Type</label>
            <select name="type" required>
                <option value="apartment" {{ old('type', $place->type) == 'apartment' ? 'selected' : '' }}>Apartment</option>
                <option value="bungalow" {{ old('type', $place->type) == 'bungalow' ? 'selected' : '' }}>Bungalow</option>
            </select>
        </div>

        <div>
            <label for="image_file">Change Image (optional)</label>
            <input type="file" name="image_file">
        </div>
    
        @if ($place->image_path)
            <div>
                <label>Current Image:</label><br>
                <img src="{{ asset($place->image_path) }}" alt="Current Image" style="max-width: 200px;">
            </div>
        @endif

        <button type="submit">Update Place</button>
        <a href="{{ route('owner', $place->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");

h2 {
    color: #704d2b;
    margin-bottom: 1.5rem;
    font-weight: 600;
}

label {
    display: block;
    margin-bottom: 0.5rem;
    color: #444;
    font-weight: 500;
}

input[type="text"],
textarea,
select,
input[type="file"] {
    width: 100%;
    padding: 0.75rem;
    margin-bottom: 1.5rem;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    font-size: 1rem;
    transition: border-color 0.2s ease;
}

input:focus,
textarea:focus,
select:focus {
    outline: none;
    border-color: #8b7355;
}

div > ul {
    background: #ffe0e0;
    color: #a00;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

div > ul li {
    list-style: inside;
}

.btn.btn-secondary, button[type="submit"] {
    background: linear-gradient(90deg, #eab566 0%, #8b7355 100%);
    color: #fff;
    border: none;
    border-radius: 18px;
    padding: 0.7rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0.2rem 0.2rem;
    cursor: pointer;
    box-shadow: 0 2px 8px #eab56644;
    transition: background 0.2s, transform 0.2s;
    text-decoration: none;
    display: inline-block;
}

.btn-secondary, button[type="submit"] {
    background: linear-gradient(90deg, #8b7355 0%, #eab566 100%);
}

.btn-secondary:hover, button[type="submit"]:hover {
    background: linear-gradient(135deg, #a2854b, #eab566);
}
</style>
