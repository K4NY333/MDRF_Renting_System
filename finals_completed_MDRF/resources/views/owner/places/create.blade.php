@vite(['resources/css/places/create.css'])

<head>
    <title>Owner | Create Place</title>
</head>

<div >
    <h2 class="mb-4">Create a New Place</h2>

    @if ($errors->any())
        <div >
            <strong>Errors:</strong>
            <ul >
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('places.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div >
            <label for="name">Place Name</label>
            <input type="text" name="name"  required>
        </div>

        <div >
            <label for="description">Description (optional)</label>
            <textarea name="description"  rows="3"></textarea>
        </div>

        <div >
            <label for="location">Location</label>
            <input type="text" name="location"  required>
        </div>

        <div >
            <label for="type">Type</label>
            <select name="type"  required>
                <option value="apartment">Apartment</option>
                <option value="bungalow">Bungalow</option>
            </select>
        </div>

        <div>
            <label for="image_file">Place Image</label>
            <input type="file" name="image_file" >
        </div>

        <button type="submitt" >Create Place</button>
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

button[type="submitt"] {
    background-color: #8b7355;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submitt"]:hover {
    background-color: #704d2b;
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
</style>
