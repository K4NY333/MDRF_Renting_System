<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Owner Show Property Details</title>
<style>
/* === Your original Property Details Panel styles === */
.property-details-overlay {
    position: fixed;
    top: 0;
    right: 0;
    width: 0;
    height: 100%;
    background-color: white;
    box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
    z-index: 99;
    overflow-y: auto;
    transition: width 0.3s ease;
}

.property-details-overlay.active {
    width: 40%;
}

.property-details-content {
    padding: 30px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.property-details-overlay.active .property-details-content {
    opacity: 1;
}

.property-details-close {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 24px;
    cursor: pointer;
    color: #888;
}

/* Gallery and thumbnails */
.property-gallery {
    position: relative;
    margin-bottom: 20px;
}

.property-gallery-main {
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-radius: 10px;
}

.property-thumbs {
    display: flex;
    gap: 10px;
    margin-top: 10px;
    overflow-x: auto;
    padding-bottom: 10px;
}

.property-thumb {
    width: 70px;
    height: 50px;
    object-fit: cover;
    border-radius: 5px;
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.3s ease;
}

.property-thumb:hover,
.property-thumb.active {
    opacity: 1;
}

.property-title {
    font-size: 28px;
    font-weight: 600;
    color: #5d4a38;
    margin-bottom: 10px;
}

.property-location {
    display: flex;
    align-items: center;
    color: #666;
    margin-bottom: 15px;
}

.property-location i {
    margin-right: 8px;
    color: #b89b7a;
}

.property-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
}

.property-tag {
    background-color: #f0f0f0;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    color: #666;
}

.property-price-large {
    font-size: 24px;
    font-weight: 600;
    color: #5d4a38;
    margin-bottom: 20px;
}

.property-details-heading {
    font-size: 20px;
    font-weight: 600;
    margin: 20px 0 10px;
    color: #5d4a38;
}

.property-details-list {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin-bottom: 20px;
}

.property-detail-item {
    display: flex;
    align-items: center;
}

.property-detail-item i {
    margin-right: 10px;
    color: #b89b7a;
    width: 20px;
    text-align: center;
}

.property-description {
    color: #666;
    line-height: 1.6;
    margin-bottom: 20px;
}

.property-amenities {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 20px;
}

.property-amenity {
    display: flex;
    align-items: center;
}

.property-amenity i {
    margin-right: 10px;
    color: #b89b7a;
    width: 20px;
    text-align: center;
}

.property-action-btns {
    display: flex;
    gap: 10px;
    margin-top: 30px;
}

.property-action-btn {
    flex: 1;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    font-weight: 500;
    cursor: pointer;
}

.property-view-btn {
    background-color: #f1f1f1;
    color: #333;
}

.property-contact-btn {
    background-color: #5d4a38;
    color: white;
}

/* --- Rooms horizontal scroll section --- */
.rooms-carousel-container {
    margin-top: 20px;
    position: relative;
}

.rooms-carousel {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding-bottom: 12px;
    scrollbar-width: none; /* Firefox */
}

.rooms-carousel::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Edge */
}

.room-card {
    flex: 0 0 auto;
    width: 140px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #fff;
    box-shadow: 0 2px 6px rgb(0 0 0 / 0.05);
    cursor: pointer;
    transition: box-shadow 0.3s ease;
}

.room-card:hover {
    box-shadow: 0 4px 12px rgb(0 0 0 / 0.12);
}

.room-card img {
    width: 100%;
    height: 90px;
    border-radius: 8px 8px 0 0;
    object-fit: cover;
}

.room-info {
    padding: 8px 10px;
    font-size: 14px;
    color: #444;
}

/* Scroll buttons */
.rooms-scroll-btn {
    position: absolute;
    top: 40%;
    background: #5d4a38;
    color: white;
    border: none;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    user-select: none;
    z-index: 10;
}

.rooms-scroll-btn:hover {
    opacity: 1;
}

.rooms-scroll-left {
    left: -14px;
}

.rooms-scroll-right {
    right: -14px;
}
</style>
</head>
<body>

<!-- Property Details Panel -->
<div class="property-details-overlay" id="propertyPanel">
  <div class="property-details-content">
    <div class="property-details-close" id="closeBtn">&times;</div>

    <div class="property-gallery">
      <img src="https://via.placeholder.com/600x250" alt="Main Property" class="property-gallery-main" />
      <div class="property-thumbs">
        <img src="https://via.placeholder.com/70x50" alt="Thumb 1" class="property-thumb active" />
        <img src="https://via.placeholder.com/70x50" alt="Thumb 2" class="property-thumb" />
        <img src="https://via.placeholder.com/70x50" alt="Thumb 3" class="property-thumb" />
      </div>
    </div>

    <h1 class="property-title">Beautiful Family Home</h1>

    <div class="property-location">
      <i class="fa fa-map-marker-alt"></i>
      <span>1234 Elm Street, Springfield</span>
    </div>

    <div class="property-tags">
      <span class="property-tag">3 Bedrooms</span>
      <span class="property-tag">2 Bathrooms</span>
      <span class="property-tag">Garage</span>
    </div>

    <div class="property-price-large">$350,000</div>

    <div class="property-details-heading">Description</div>
    <p class="property-description">
      A beautiful 3-bedroom family home located in a quiet neighborhood with modern amenities and a spacious backyard.
    </p>

    <!-- Rooms Horizontal Scroll Section -->
    <div class="property-details-heading">Rooms</div>
    <div class="rooms-carousel-container">
      <button class="rooms-scroll-btn rooms-scroll-left" id="scrollLeft">&#8249;</button>
      <div class="rooms-carousel" id="roomsCarousel">
        <div class="room-card">
          <img src="https://via.placeholder.com/140x90?text=Living+Room" alt="Living Room" />
          <div class="room-info">Living Room</div>
        </div>
        <div class="room-card">
          <img src="https://via.placeholder.com/140x90?text=Master+Bedroom" alt="Master Bedroom" />
          <div class="room-info">Master Bedroom</div>
        </div>
        <div class="room-card">
          <img src="https://via.placeholder.com/140x90?text=Kitchen" alt="Kitchen" />
          <div class="room-info">Kitchen</div>
        </div>
        <div class="room-card">
          <img src="https://via.placeholder.com/140x90?text=Bathroom" alt="Bathroom" />
          <div class="room-info">Bathroom</div>
        </div>
        <div class="room-card">
          <img src="https://via.placeholder.com/140x90?text=Dining+Room" alt="Dining Room" />
          <div class="room-info">Dining Room</div>
        </div>
      </div>
      <button class="rooms-scroll-btn rooms-scroll-right" id="scrollRight">&#8250;</button>
    </div>

    <div class="property-action-btns">
      <button class="property-action-btn property-view-btn">View Details</button>
      <button class="property-action-btn property-contact-btn">Contact Owner</button>
    </div>
  </div>
</div>

<!-- Button to open the panel for demo -->
<button onclick="openPanel()" style="position:fixed;top:20px;left:20px;z-index:100;">Show Property Details</button>

<script>
  const panel = document.getElementById('propertyPanel');
  const closeBtn = document.getElementById('closeBtn');
  const scrollLeftBtn = document.getElementById('scrollLeft');
  const scrollRightBtn = document.getElementById('scrollRight');
  const roomsCarousel = document.getElementById('roomsCarousel');

  function openPanel() {
    panel.classList.add('active');
  }

  closeBtn.addEventListener('click', () => {
    panel.classList.remove('active');
  });

  scrollLeftBtn.addEventListener('click', () => {
    roomsCarousel.scrollBy({ left: -160, behavior: 'smooth' });
  });

  scrollRightBtn.addEventListener('click', () => {
    roomsCarousel.scrollBy({ left: 160, behavior: 'smooth' });
  });
</script>

</body>
</html>
