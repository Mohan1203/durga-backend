document.addEventListener("DOMContentLoaded", function () {

    if (document.querySelector('input[name="name"]') && document.querySelector('input[name="slug"]')) {
        handleSlug();
    }
    if (document.getElementById("categories")) {
        handleCategories();
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
function handleCategories() {
    const categoriesInput = document.getElementById("categories");
    const categoriesContainer = document.getElementById("categories-container");
    const categorySelect = document.getElementById("category_id");
    const categoriesWithNamesInput = document.getElementById("categoriesWithNames");

    if (!categoriesInput || !categoriesContainer || !categorySelect) return;

    // Array to store selected categories
    let selectedCategories = [];

    // Initialize from existing data - first try categoriesWithNames for edit page
    if (categoriesWithNamesInput && categoriesWithNamesInput.value) {
        try {
            const categoriesWithNames = JSON.parse(categoriesWithNamesInput.value);
            if (Array.isArray(categoriesWithNames) && categoriesWithNames.length > 0) {
                selectedCategories = categoriesWithNames;
                console.log('Initialized categories from categoriesWithNames:', selectedCategories);
            }
        } catch (e) {
            console.error("Error parsing categoriesWithNames:", e);
        }
    }

    // If no categories were loaded from categoriesWithNames, try the regular categories input
    if (selectedCategories.length === 0 && categoriesInput.value) {
        try {
            const categoryIds = JSON.parse(categoriesInput.value);

            // If it's just an array of IDs, convert to objects with names
            if (Array.isArray(categoryIds) && categoryIds.length > 0) {
                if (typeof categoryIds[0] !== 'object') {
                    // It's just an array of IDs, get names from select options
                    selectedCategories = categoryIds.map(id => {
                        const option = Array.from(categorySelect.options).find(opt => opt.value == id);
                        return {
                            id: id,
                            name: option ? option.textContent.trim() : 'Unknown'
                        };
                    });
                } else {
                    // It's already an array of objects
                    selectedCategories = categoryIds;
                }
                console.log('Initialized categories from categoriesInput:', selectedCategories);
            }
        } catch (e) {
            console.error("Error parsing categories:", e);
        }
    }

    // Update UI if we have categories
    if (selectedCategories.length > 0) {
        renderCategories();
    }

    categorySelect.addEventListener('change', function () {
        const categoryId = this.value;
        if (!categoryId) return;

        const categoryName = this.options[this.selectedIndex].getAttribute('data-name') ||
            this.options[this.selectedIndex].textContent.trim();

        // Check if category is already selected
        if (selectedCategories.some(cat => cat.id == categoryId)) {
            alert('This category is already selected');
            this.selectedIndex = 0;
            return;
        }

        // Add to selected categories array
        selectedCategories.push({
            id: categoryId,
            name: categoryName
        });

        // Update hidden input
        updateCategoriesInput();

        // Render category items
        renderCategories();

        // Reset select to default option
        this.selectedIndex = 0;
    });

    function renderCategories() {
        categoriesContainer.innerHTML = '';

        selectedCategories.forEach((category, index) => {
            const categoryItem = document.createElement('div');
            categoryItem.className = 'badge bg-primary me-2 mb-2 p-2';
            categoryItem.style.fontSize = '0.9rem';

            const displayName = category.name || 'Unknown';

            categoryItem.innerHTML = `
                ${displayName} <span class="ms-1" style="cursor:pointer;" data-index="${index}">&times;</span>
            `;

            categoriesContainer.appendChild(categoryItem);

            // Add event listener to this specific remove button
            const removeButton = categoryItem.querySelector('span');
            removeButton.addEventListener('click', function () {
                const index = parseInt(this.getAttribute('data-index'));
                selectedCategories.splice(index, 1);
                updateCategoriesInput();
                renderCategories();
            });
        });
    }

    function updateCategoriesInput() {
        // Store only the IDs in the hidden input
        const categoryIds = selectedCategories.map(cat => cat.id);
        console.log("categoryIds", categoryIds);
        categoriesInput.value = JSON.stringify(categoryIds);
        console.log("categoriesInput", categoriesInput.value);
    }
}





