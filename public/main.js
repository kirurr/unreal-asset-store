const signInForm = document.getElementById("sign-in-form");

signInForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  const formData = new FormData(e.target);

  const response = await fetch("/api/signin", {
    method: "POST",
    body: formData,
  });

  if (response.ok) {
    window.location.href = "/";
  } else {
    response.json().then((data) => console.log(data));
  }
});
const signUpForm = document.getElementById("sign-up-form");

signUpForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  const formData = new FormData(e.target);

  const response = await fetch("/api/signup", {
    method: "POST",
    body: formData,
  });

  if (response.ok) {
    window.location.href = "/";
  } else {
    response.json().then((data) => console.log(data));
  }
});
