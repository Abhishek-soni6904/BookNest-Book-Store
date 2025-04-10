document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.querySelector(".search-container input");
  const products = document.querySelectorAll(".product-card");
  const categoryFilter = document.getElementById("categoryFilter");
  const authorFilter = document.getElementById("authorFilter");
  const sortFilter = document.getElementById("sortFilter");

  // Search functionality
  searchInput.addEventListener("input", function () {
      // Reset filters when searching
      if (searchInput.value.trim() !== "") {
          categoryFilter.value = "";
          authorFilter.value = "";
      }
      applyFilters();
  });

  // Category filter
  categoryFilter.addEventListener("change", function () {
      applyFilters();
  });

  // Author filter
  authorFilter.addEventListener("change", function () {
      applyFilters();
  });

  // Sort filter
  sortFilter.addEventListener("change", function () {
      applyFilters();
  });

  function applyFilters() {
      const searchTerm = searchInput.value.toLowerCase().trim();
      const category = categoryFilter.value.toLowerCase();
      const author = authorFilter.value.toLowerCase();
      const sortValue = sortFilter.value;

      // First filter the products
      const visibleProducts = Array.from(products).filter((product) => {
          const productName = product.querySelector(".product-name").textContent.toLowerCase();
          const productDescription = product.querySelector(".product-description").textContent.toLowerCase();
          const productCategory = product.getAttribute("data-category").toLowerCase();
          const productAuthor = product.getAttribute("data-author").toLowerCase();

          const matchesSearch = searchTerm === "" ||
              productName.includes(searchTerm) ||
              productDescription.includes(searchTerm) ||
              productCategory.includes(searchTerm) ||
              productAuthor.includes(searchTerm);

          const matchesCategory = !category || productCategory === category;
          const matchesAuthor = !author || productAuthor === author;

          // Update visibility
          product.style.display = (matchesSearch && matchesCategory && matchesAuthor) ? "flex" : "none";
          return matchesSearch && matchesCategory && matchesAuthor;
      });

      // Then sort the visible products
      const productsGrid = document.querySelector(".products-grid");
      visibleProducts.sort((a, b) => {
          const aName = a.querySelector(".product-name").textContent;
          const bName = b.querySelector(".product-name").textContent;
          const aPrice = parseFloat(a.querySelector(".current-price").textContent.replace(/[₹,]/g, ""));
          const bPrice = parseFloat(b.querySelector(".current-price").textContent.replace(/[₹,]/g, ""));

          switch (sortValue) {
              case "name-asc":
                  return aName.localeCompare(bName);
              case "name-desc":
                  return bName.localeCompare(aName);
              case "price-asc":
                  return aPrice - bPrice;
              case "price-desc":
                  return bPrice - aPrice;
              default:
                  return 0;
          }
      });

      // Update the DOM
      productsGrid.innerHTML = "";
      visibleProducts.forEach((product) => {
          productsGrid.appendChild(product);
      });
  }

  // Initial filter application if any filter is selected
  if (categoryFilter.value || authorFilter.value) {
      applyFilters();
  }
});

// Keep existing click handlers
Array.from(document.getElementsByClassName("view-product")).forEach((btn) => {
  btn.addEventListener("click", () => {
      window.location.assign(`viewProduct.php?id=${btn.id}`);
  });
});