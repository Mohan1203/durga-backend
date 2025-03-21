document.addEventListener("DOMContentLoaded", function () {

    if (document.querySelector('input[name="name"]') && document.querySelector('input[name="slug"]')) {
        handleSlug();
    }
    if (document.getElementById("loading-spinner")) {
        handleSpinner();
    }
    if (document.getElementById("sidebarToggle")) {
        handleSideBar();
    }
    if (document.getElementById("feature") && document.getElementById("feature-add-btn")) {
        const initialFeatures = JSON.parse(document.getElementById("featuresArray").value || "[]");

        handleAddFeature(initialFeatures);
    }
    if (document.getElementById("imageContainer")) {
        handleImageUpload();
    }

});
function handleSlug() {
    const nameInput = document.querySelector('input[name="name"]');
    const slugInput = document.querySelector('input[name="slug"]');
    if (nameInput && slugInput) {
        nameInput.addEventListener("input", function () {
            let slug = nameInput.value
                .toLowerCase()
                .trim()
                .replace(/[\s\W-]+/g, "-");

            slugInput.value = slug;
        });
    }
}
function handleSpinner() {
    const spinner = document.getElementById("loading-spinner");
    const table = document.getElementById("categories-table");
    setTimeout(() => {
        spinner.classList.add("d-none");
        table.classList.remove("d-none");
    }, 1000);
}
function handleSideBar() {
    document.getElementById("sidebarToggle").addEventListener("click", function () {
        document.querySelector(".sidebar-offcanvas").classList.toggle("active");
    });
}
function handleAddFeature(initialFeatures = []) {
    let features = [...initialFeatures];
    const featureInput = document.getElementById("feature");
    const addFeatureBtn = document.getElementById("feature-add-btn");
    const featuresContainer = document.getElementById("features-container");
    const featuresArrayInput = document.getElementById("featuresArray");
    console.log("feature container", featuresContainer)
    // Function to update the UI and hidden input
    function updateFeatureList() {
        featuresContainer.innerHTML = "";
        features.forEach((feature, index) => {
            const featureItem = document.createElement("div");
            featureItem.classList.add("d-flex", "justify-content-between", "align-items-center", "border", "p-2", "mb-2");
            featureItem.innerHTML = `
                <span>${feature}</span>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeFeature(${index})">Remove</button>
            `;
            featuresContainer.appendChild(featureItem);
        });
        featuresArrayInput.value = JSON.stringify(features);
    }

    // Add feature event listener
    addFeatureBtn.addEventListener("click", function () {
        const featureText = featureInput.value.trim();
        if (featureText && !features.includes(featureText)) {
            features.push(featureText);
            updateFeatureList();
            featureInput.value = "";
        }
    });

    // Remove feature function
    window.removeFeature = function (index) {
        features.splice(index, 1);
        updateFeatureList();
    };

    // Initialize the feature list on page load
    updateFeatureList();
}
function handleImageUpload() {
    const imageInput = document.getElementById("imageInput");
    const previewImage = document.getElementById("previewImage");
    const removeImageBtn = document.getElementById("removeImageBtn");
    const imageContainer = document.getElementById("imageContainer");

    // Handle image preview on file select
    imageInput.addEventListener("change", function (event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                if (!previewImage) {
                    // Create new image if not present
                    const newImg = document.createElement("img");
                    newImg.id = "previewImage";
                    newImg.className = "h-100 w-100 img-thumbnail";
                    imageContainer.appendChild(newImg);
                }
                previewImage.src = e.target.result;
                removeImageBtn.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    });

    // Handle remove image button
    removeImageBtn?.addEventListener("click", function () {
        if (previewImage) {
            previewImage.remove();
        }
        removeImageBtn.style.display = "none";
        imageInput.value = ""; // Clear file input
    });
}





