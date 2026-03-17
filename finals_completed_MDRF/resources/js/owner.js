document.body.addEventListener("click", (event) => {
    if (event.target.classList.contains("view-pdf-btn")) {
        const pdfPopup = document.getElementById("pdfPopup");
        const closePdfPopup = document.getElementById("closePdfPopup");
        const pdfViewer = document.getElementById("pdfViewer");

        if (!pdfPopup || !closePdfPopup || !pdfViewer) return;

        const pdfUrl = event.target.getAttribute("data-pdf-url");
        if (!pdfUrl) {
            alert("No PDF URL found.");
            return;
        }
        pdfViewer.src = pdfUrl;
        pdfPopup.style.display = "flex";

        closePdfPopup.addEventListener(
            "click",
            () => {
                pdfPopup.style.display = "none";
                pdfViewer.src = "";
            },
            { once: true }
        ); // ensure this listener is called only once per popup open
    }
});

window.openDashboardPopup = function (routeUrl) {
    const panel = document.getElementById("dashboardPopupPanel");
    const content = document.getElementById("dashboardPopupContent");
    const currentRouteUrl = content.dataset.currentRoute || null;
    const isPopupOpen = panel.classList.contains("flex");

    if (isPopupOpen && currentRouteUrl === routeUrl) {
        panel.classList.remove("flex");
        panel.classList.add("hidden");
        content.innerHTML = "";
        content.dataset.currentRoute = "";
    } else {
        fetch(routeUrl)
            .then((response) => {
                if (!response.ok)
                    throw new Error("Network response was not ok");
                return response.text();
            })
            .then((html) => {
                content.innerHTML = html;
                panel.classList.remove("hidden");
                panel.classList.add("flex");
                content.dataset.currentRoute = routeUrl;
            })
            .catch((error) => {
                content.innerHTML = `<p class="text-red-500">Failed to load content: ${error.message}</p>`;
                panel.classList.remove("hidden");
                panel.classList.add("flex");
                content.dataset.currentRoute = routeUrl;
            });
    }
};
document.addEventListener("DOMContentLoaded", () => {
    window.scrollRooms = function (placeId, direction) {
        console.log("Triggered scrollRooms for", placeId, direction);
        const container = document.getElementById("roomScroll" + placeId);
        if (!container) {
            console.log("No container found with ID roomScroll" + placeId);
            return;
        }
        container.scrollBy({
            left: direction === "left" ? -520 : 520,
            behavior: "smooth",
        });
    };
});

document.addEventListener("DOMContentLoaded", () => {
    window.showRoomDetails = function (elem) {
        document.getElementById("roomType").textContent =
            elem.getAttribute("data-type") || "";
        document.getElementById("roomNumber").textContent =
            elem.getAttribute("data-number") || "";
        document.getElementById("roomCapacity").textContent =
            elem.getAttribute("data-capacity") || "";
        document.getElementById("roomPrice").textContent =
            elem.getAttribute("data-price") || "";
        document.getElementById("roomDescription").textContent =
            elem.getAttribute("data-description") || "";

        const imageContainer = document.getElementById("roomImage");
        imageContainer.innerHTML = "";

        let imagePaths;
        try {
            imagePaths = JSON.parse(elem.getAttribute("data-image") || "[]");
        } catch {
            imagePaths = [];
        }

        let imageHTML = "";
        if (Array.isArray(imagePaths) && imagePaths.length) {
            console.log("Image paths:", imagePaths);

            imageHTML = imagePaths
                .map((path) => {
                    const cleanPath =
                        path.startsWith("http") || path.startsWith("/")
                            ? path
                            : `/${path}`;
                    console.log("Image src:", cleanPath); // ✅ DEBUG each path
                    return `<img src="${cleanPath}">`;
                })
                .join("");
        } else {
            imageHTML =
                '<img src="/default-room.jpg" style="width:100%;" alt="No Image">';
        }

        imageContainer.innerHTML = imageHTML;
        imageContainer.style.display = "block";

        document.getElementById("roomDetailsModal").style.display = "flex";

        document
            .getElementById("closeModalBtn")
            .addEventListener("click", () => {
                document.getElementById("roomDetailsModal").style.display =
                    "none";
            });

        document
            .getElementById("roomDetailsModal")
            .addEventListener("click", (e) => {
                if (e.target === e.currentTarget) {
                    e.currentTarget.style.display = "none";
                }
            });
    };
});
document.addEventListener("DOMContentLoaded", () => {
    window.showQR = function (url) {
        const qrImage = document.getElementById("qrImage");
        const qrModal = document.getElementById("qrModal");

        if (!qrImage || !qrModal) {
            console.warn("❌ QR modal elements not found in DOM.");
            return;
        }

        console.log("✅ showQR called with URL:", url);
        qrImage.src = url;
        qrModal.style.display = "flex";

        // Ensure close functionality is bound
        qrModal.addEventListener("click", (e) => {
            if (e.target === qrModal) {
                closeQR();
            }
        });
    };

    window.closeQR = function () {
        const qrImage = document.getElementById("qrImage");
        const qrModal = document.getElementById("qrModal");

        if (!qrImage || !qrModal) return;

        console.log("❎ closeQR called");
        qrImage.src = '';
        qrModal.style.display = "none";
    };
});




// ---- Staff Assignment ----
(() => {
    document.addEventListener('DOMContentLoaded', () => {
          const staffData = window.staffData || [];
        console.log("[DEBUG] Loaded staff data:", staffData);

        const staffSelect = document.getElementById('staffSelect');
        const assignForm = document.getElementById('assignStaffForm');

        if (!staffSelect) console.error("[ERROR] staffSelect dropdown element not found!");
        if (!assignForm) console.error("[ERROR] assignStaffForm element not found!");

        document.querySelectorAll('.assign-staff-btn').forEach(button => {
            button.addEventListener('click', function () {
                const requestId = this.dataset.requestId;
                console.log("[DEBUG] Clicked assign button for requestId:", requestId);

                if (!staffSelect) return;
                staffSelect.innerHTML = '';

                if (!Array.isArray(staffData) || staffData.length === 0) {
                    const option = document.createElement('option');
                    option.textContent = 'No staff available';
                    option.disabled = true;
                    option.selected = true;
                    staffSelect.appendChild(option);
                } else {
                    staffData.forEach((staff, index) => {
                        const option = document.createElement('option');
                        option.value = staff.id;
                        option.textContent = staff.name;
                        staffSelect.appendChild(option);
                    });
                }

                if (assignForm) {
                    assignForm.action = `/owner/maintenance/approve/${requestId}`;
                    console.log("[DEBUG] Form action set to:", assignForm.action);
                }
            });
        });

        if (assignForm) {
            assignForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                console.log("[DEBUG] Submitting form with data:", Object.fromEntries(formData.entries()));

                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token')
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error('Request failed');
                    return response.json();
                })
                .then(data => {
                    console.log("[DEBUG] Server response:", data);
                    const modalEl = document.getElementById('assignStaffModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    modal.hide();
                    location.reload();
                })
                .catch(error => {
                    console.error('[ERROR] Assignment error:', error);
                    alert('Failed to assign staff. Please try again.');
                });
            });
        }
    });

    
document.addEventListener('DOMContentLoaded', function() {
    const alertBox = document.querySelector('.alert-alert-success');
    if(alertBox){
        setTimeout(() => {
            alertBox.style.opacity = '0';
            alertBox.style.pointerEvents = 'none';
        }, 3000); // 3 seconds

        setTimeout(() => {
            if(alertBox.parentNode) alertBox.parentNode.removeChild(alertBox);
        }, 3700); // Remove from DOM after fade out
    }
});

})();