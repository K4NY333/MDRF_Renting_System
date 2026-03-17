document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".edit-user-btn");
    const editUserPopup = document.getElementById("editUserPopup");
    const closeEditUserPopup = document.getElementById("closeEditUserPopup");
    const editUserFormContainer = document.getElementById(
        "editUserFormContainer"
    );

    editButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const userId = button.getAttribute("data-user-id");

            // Load form via server-rendered route
            fetch(`/admin/users/${userId}/edit-form`)
                .then((response) => response.text())
                .then((html) => {
                    editUserFormContainer.innerHTML = html;
                    editUserPopup.style.display = "flex";
                });
        });
    });

    closeEditUserPopup.addEventListener("click", () => {
        editUserPopup.style.display = "none";
        editUserFormContainer.innerHTML = ""; // clear form after closing
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const viewPdfButtons = document.querySelectorAll(".view-pdf-btn");
    const pdfPopup = document.getElementById("pdfPopup");
    const closePdfPopup = document.getElementById("closePdfPopup");
    const pdfViewer = document.getElementById("pdfViewer");

    viewPdfButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const pdfUrl = button.getAttribute("data-pdf-url");
            if (!pdfUrl) {
                alert("No PDF URL found.");
                return;
            }

            console.log("PDF URL:", pdfUrl);
            pdfViewer.src = pdfUrl;
            pdfPopup.style.display = "flex";
        });
    });

    closePdfPopup.addEventListener("click", () => {
        pdfPopup.style.display = "none";
        pdfViewer.src = "";
    });
});

document.querySelectorAll(".view-owner-btn").forEach((button) => {
    button.addEventListener("click", function () {
        const ownerId = this.getAttribute("data-owner-id");
        const panel = document.getElementById(`propertyPanel-${ownerId}`);
        if (panel) {
            panel.classList.add("active");
        }
    });

    // Handle panel view buttons
    document.querySelectorAll(".view-owner-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const ownerId = this.getAttribute("data-owner-id");
            const panel = document.getElementById(`propertyPanel-${ownerId}`);
            if (panel) {
                panel.classList.add("active");
            }
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    // Attach carousel scroll functionality to all left/right buttons
    document.querySelectorAll(".carousel-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const direction = this.classList.contains("left") ? -1 : 1;
            scrollCarousel(this, direction);
        });
    });

    // Attach panel close buttons
    document.querySelectorAll(".property-details-close").forEach((closeBtn) => {
        closeBtn.addEventListener("click", function () {
            const panel = this.closest(".property-details-overlay");
            if (panel) panel.classList.remove("active");
        });
    });

    // Attach view-owner buttons to open their panels
    document.querySelectorAll(".view-owner-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const ownerId = this.getAttribute("data-owner-id");
            const panel = document.getElementById(`propertyPanel-${ownerId}`);
            if (panel) panel.classList.add("active");
        });
    });
});

function scrollCarousel(button, direction) {
    const wrapper = button.closest(".carousel-wrapper");
    const carousel = wrapper.querySelector(".rooms-carousel");
    const scrollAmount = 300;
    if (carousel) {
        carousel.scrollBy({
            left: direction * scrollAmount,
            behavior: "smooth",
        });
    }
}

window.addEventListener("DOMContentLoaded", function () {
    window.showRoomDetails = function (
        id,
        imagePaths,
        type,
        capacity,
        price,
        description
    ) {
        const modal = document.getElementById("roomModal");
        const body = document.getElementById("roomModalBody");

        let imageHTML = "";
       if (Array.isArray(imagePaths) && imagePaths.length) {
    console.log("Image Paths:", imagePaths); // ✅ DEBUG: Check what's passed in

    imageHTML = imagePaths
        .map((path) => {
            const cleanPath = path.startsWith("http") || path.startsWith("/") 
                ? path 
                : `/${path}`;

            console.log("Image src:", cleanPath); // ✅ DEBUG each path
            return `<img src="${cleanPath}" style="width:100%; margin-bottom:10px;" alt="Room Image">`;
        })
        .join("");
} else {
    console.warn("No images provided, using fallback.");
    imageHTML =
        '<img src="/default-room.jpg" style="width:100%;" alt="No Image">';
}
        body.innerHTML = `
      <h2>Room ID: ${id}</h2>
      ${imageHTML}
      <p><strong>Type:</strong> ${type}</p>
      <p><strong>Capacity:</strong> ${capacity}</p>
      <p><strong>Price:</strong> ₱${price}</p>
      <p><strong>Description:</strong> ${description}</p>
    `;
        modal.style.display = "block";
    };

    window.closeRoomModal = function () {
        document.getElementById("roomModal").style.display = "none";
    };

    window.onclick = function (event) {
        const modal = document.getElementById("roomModal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
});

// for room leffright button
