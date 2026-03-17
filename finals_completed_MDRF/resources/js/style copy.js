// Top Carousel Functionality
const carousel = document.querySelector(".carousel");
const dots = document.querySelectorAll(".dot");
let currentSlide = 0;

function showSlide(index) {
    carousel.style.transform = `translateX(-${index * 100}%)`;

    dots.forEach((dot) => dot.classList.remove("active"));
    dots[index].classList.add("active");

    currentSlide = index;
}

dots.forEach((dot) => {
    dot.addEventListener("click", function () {
        showSlide(parseInt(this.getAttribute("data-index")));
    });
});

// slide show
document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelectorAll(".carousel-slide");
    const dotsContainer = document.querySelector(".carousel-dots");
    const carousel = document.querySelector(".carousel");
    let currentIndex = 0;

    slides.forEach((_, index) => {
        const dot = document.createElement("div");
        dot.classList.add("dot");
        if (index === 0) dot.classList.add("active");
        dot.addEventListener("click", () => {
            moveToSlide(index);
        });
        dotsContainer.appendChild(dot);
    });

    function moveToSlide(index) {
        carousel.style.transform = `translateX(-${index * 100}%)`;
        document
            .querySelectorAll(".dot")
            .forEach((dot) => dot.classList.remove("active"));
        document.querySelectorAll(".dot")[index].classList.add("active");
        currentIndex = index;
    }

    function autoSlide() {
        currentIndex = (currentIndex + 1) % slides.length;
        moveToSlide(currentIndex);
    }

    setInterval(autoSlide, 4000);
});

// Auto-rotate carousel
setInterval(() => {
    currentSlide = (currentSlide + 1) % dots.length;
    showSlide(currentSlide);
}, 5000);

// Properties Slider Functionality
const propertiesSlider = document.querySelector(".properties-slider");
const prevBtn = document.querySelector(".prev-btn");
const nextBtn = document.querySelector(".next-btn");
let currentProperties = 0;
const totalSets = 2; // We have 2 sets of 4 properties

prevBtn.addEventListener("click", () => {
    if (currentProperties > 0) {
        currentProperties--;
        updatePropertiesSlider();
    }
});

nextBtn.addEventListener("click", () => {
    if (currentProperties < totalSets - 1) {
        currentProperties++;
        updatePropertiesSlider();
    }
});

function updatePropertiesSlider() {
    const translateValue = currentProperties * 100;
    propertiesSlider.style.transform = `translateX(-${translateValue}%)`;
}

// Property Details Panel Functionality
const propertyCards = document.querySelectorAll(".property-card");
const propertyDetailsPanel = document.getElementById("propertyDetailsPanel");
const closePropertyDetails = document.getElementById("closePropertyDetails");
const dimOverlay = document.getElementById("dimOverlay");

propertyCards.forEach((card) => {
    card.addEventListener("click", () => {
        propertyDetailsPanel.classList.add("active");
        dimOverlay.style.display = "block";
    });
});

closePropertyDetails.addEventListener("click", () => {
    propertyDetailsPanel.classList.remove("active");
    dimOverlay.style.display = "none";
});

// Property Gallery Thumbnails
const propertyThumbs = document.querySelectorAll(".property-thumb");
const propertyMainImage = document.getElementById("propertyMainImage");

propertyThumbs.forEach((thumb) => {
    thumb.addEventListener("click", () => {
        propertyThumbs.forEach((t) => t.classList.remove("active"));
        thumb.classList.add("active");
        propertyMainImage.src = thumb.getAttribute("data-src");
    });
});

// Filter Popup Functionality
const filterBtn = document.getElementById("filterBtn");
const filterPopup = document.getElementById("filterPopup");
const closeFilterPopup = document.getElementById("closeFilterPopup");

filterBtn.addEventListener("click", () => {
    filterPopup.style.display = "flex";
});

closeFilterPopup.addEventListener("click", () => {
    filterPopup.style.display = "none";
});

// Auth Popup Functionality
const userProfileBtn = document.getElementById("userProfileBtn");
const authPopup = document.getElementById("authPopup");
const closeAuthPopup = document.getElementById("closeAuthPopup");
const authTabs = document.querySelectorAll(".auth-tab");
const authForms = document.querySelectorAll(".auth-form");

userProfileBtn.addEventListener("click", () => {
    authPopup.style.display = "flex";
});

closeAuthPopup.addEventListener("click", () => {
    authPopup.style.display = "none";
});

authTabs.forEach((tab) => {
    tab.addEventListener("click", () => {
        const tabId = tab.getAttribute("data-tab");

        authTabs.forEach((t) => t.classList.remove("active"));
        authForms.forEach((f) => f.classList.remove("active"));

        tab.classList.add("active");
        document.getElementById(`${tabId}Form`).classList.add("active");
    });
});

// Close popups when clicking outside
window.addEventListener("click", (e) => {
    if (e.target === filterPopup) {
        filterPopup.style.display = "none";
    }

    if (e.target === authPopup) {
        authPopup.style.display = "none";
    }

    if (e.target === dimOverlay) {
        propertyDetailsPanel.classList.remove("active");
        dimOverlay.style.display = "none";
    }
});

// header solid when scroll
window.addEventListener("scroll", function () {
    const header = document.querySelector("header");
    if (window.scrollY > 50) {
        header.classList.add("scrolled");
    } else {
        header.classList.remove("scrolled");
    }
});

// searchformshrink
window.addEventListener("scroll", function () {
    const form = document.querySelector(".search-form");
    const scrollThreshold = 150;

    if (window.scrollY > scrollThreshold) {
        form.classList.add("shrink");
    } else {
        form.classList.remove("shrink");
    }
});

// heartButton
document.querySelectorAll(".favorite-btn").forEach((button) => {
    button.addEventListener("click", function () {
        const icon = this.querySelector("i");
        icon.classList.toggle("fa-regular");
        icon.classList.toggle("fa-solid");
        icon.classList.toggle("liked");
    });
});


