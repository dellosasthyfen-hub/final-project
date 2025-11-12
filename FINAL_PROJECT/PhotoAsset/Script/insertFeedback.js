function submitFeedback(){
  const f_name = document.querySelector("#first_name").value.trim();
  const l_name = document.querySelector("#last_name").value.trim();
  const feedback = document.querySelector("#feedback").value.trim();

  // basic client-side validation
  if (!f_name || !l_name || !feedback) {
    window.alert("Please fill in all fields before submitting.");
    return;
  }

  fetch("PhotoAsset/Script/insertFeedback.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      f_name: f_name,
      l_name: l_name,
      message: feedback
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data && data.status === "success") {
      window.alert("Feedback submitted successfully!");
 
      document.querySelector("#first_name").value = "";
      document.querySelector("#last_name").value = "";
      document.querySelector("#feedback").value = "";
    } else {
      console.error('Server error:', data);
      window.alert(data && data.message ? data.message : "Error submitting feedback.");
    }
  })
  .catch(error => {
    console.error("Error:", error);
    window.alert("Error submitting feedback. Check console for details.");
  });
}