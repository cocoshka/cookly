const forms = document.body.querySelectorAll("form");
forms?.forEach((form) => formValidation(form))

function formValidation(form) {
  const inputs = form.querySelectorAll("input");
  inputs.forEach((input) => {
    input.addEventListener("change", () => validateForm(form));
    input.addEventListener("input", () => validateForm(form));
  });
  validateForm(form, true);
}

function validateForm(form, test = false) {
  const inputs = Array.from(form.querySelectorAll('input:not([type="submit"]):not([type="button"])'));
  const valid = inputs.map((input) => validateInput(input, test)).every(v => !!v);
  if (valid) {
    form.classList.add("valid");
  } else {
    form.classList.remove("valid");
  }
  const submitButtons = Array.from(form.querySelectorAll('input[type="submit"]'));
  submitButtons.forEach((button) => {
    button.disabled = !valid;
  })
}

function validateInput(input, test = false) {
  const valid = isInputValid(input);
  if (!valid && !test) {
    input.parentElement.classList.add("invalid");
  } else {
    input.parentElement.classList.remove("invalid");
  }
  return valid;
}

function isInputValid(input) {
  if (input.required && !input.value) return false;
  if (input.value && !input.validity.valid) return false;
  return true;
}
