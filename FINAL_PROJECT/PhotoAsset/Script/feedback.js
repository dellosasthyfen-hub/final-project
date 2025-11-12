document.addEventListener("DOMContentLoaded", () => {
  const feedbackWrapper = document.querySelector(".feedback-wrapper");

  fetch("PhotoAsset/Script/feedback.php")
    .then(response => {
      if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
      return response.json().catch(() => { throw new Error("Invalid JSON"); });
    })
    .then(data => {
      feedbackWrapper.innerHTML = "";

      if (data.status === "success" && data.data.length > 0) {
        data.data.forEach(item => {
          const lastInitial = item.last_name ? item.last_name.charAt(0) + '.' : '';
          const feedbackCard = `
            <div class="col-md-4">
              <div class="p-4 border rounded h-100">
                <p class="text-dark">“${item.message}”</p>
                <h6 class="fw-bold mt-3 mb-0">- ${item.first_name} ${lastInitial}</h6>
              </div>
            </div>
          `;
          feedbackWrapper.insertAdjacentHTML("beforeend", feedbackCard);
        });
      } else if (data.status === "success") {
        feedbackWrapper.innerHTML = `
          <div class="col-12">
            <p class="text-muted">No feedback yet. Be the first to share your experience!</p>
          </div>
        `;
      } else {
        feedbackWrapper.innerHTML = `
          <div class="col-12">
            <p class="text-danger">${data.message || "Unable to load feedback."}</p>
          </div>
        `;
      }
    })
    .catch(error => {
      console.error("Error loading feedback:", error);
      feedbackWrapper.innerHTML = `
        <div class="col-12">
          <p class="text-danger">Unable to load feedback right now. Please try again later.</p>
        </div>
      `;
    });
});



