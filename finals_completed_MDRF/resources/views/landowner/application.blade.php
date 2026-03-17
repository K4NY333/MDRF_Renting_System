<form method="POST" class="owner-form" action="{{ route('landowner.apply') }}" enctype="multipart/form-data">
    @csrf

    <div class="owner-group">
        <input type="text" name="name" placeholder="Name" required>
    </div>     

    <div class="owner-group">
        <input type="email" name="email" placeholder="Email" required>
    </div>   

    <div class="owner-group">
        <input type="password" name="password" placeholder="Password" required>
    </div>   

    <div class="owner-group">
        <input type="text" name="contact_number" placeholder="Contact Number"
                 maxlength="11" pattern="\d{11}"
                 title="Please enter exactly 11 digits"
               required>
    </div>   

    <div class="owner-group">
        <label>Upload PDF Document:</label>
        <input type="file" name="pdf_file" accept="application/pdf" required>
    </div>

    <div class="owner-group">
        <label>Upload Your Image:</label>
        <input type="file" name="image_file" accept="image/*" required>
    </div>

    <button class="owner-button" type="submit">
        Apply
    </button>
</form>

<style>

.owner-group {
  margin-bottom: 20px;
  display: flex;
  flex-direction: column;
}

.owner-group input[type="text"],
.owner-group input[type="email"],
.owner-group input[type="password"],
.owner-group input[type="file"] {
  padding: 12px 15px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 1rem;
  transition: border-color 0.3s ease;
}

.owner-group input:focus {
  border-color: #a2854b;
  outline: none;
}

.owner-group label {
  font-weight: 600;
  margin-bottom: 8px;
  color: #333;
}

.owner-button {
  width: 100%;
  padding: 14px;
  background-color: #eab566;
  border: none;
  border-radius: 8px;
  color: white;
  font-size: 1.1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.owner-button:hover {
  background-color: #a2854b;
}
</style>
