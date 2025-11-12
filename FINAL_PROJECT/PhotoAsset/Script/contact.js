function myFunction() {

  const email = document.querySelector("#email").value;
  const name = document.querySelector("#name").value;
  const message = document.querySelector("#message").value;
  
  if (!email || !name || !message) {
    return;
  }

  email.value = "";
  name.value = "";
  message.value = "";

  return window.alert("Message sent!");

}