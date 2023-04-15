import markdownIt from 'https://cdn.jsdelivr.net/npm/markdown-it@13.0.1/+esm'

const md = markdownIt({
  linkify: true,
  typographer: true
})

const menuOpenButtons = document.querySelectorAll(".menu-toggle");
menuOpenButtons?.forEach((btn) => {
  btn.addEventListener("click", () => {
    document.body.classList.toggle("menu-opened")
  })
})

const menuButtons = document.querySelectorAll(".button--menu");

menuButtons?.forEach((btn) => {
  btn.addEventListener("click", (evt) => {
    if (!btn.classList.contains("button--opened")) {
      document.addEventListener("click", () => {
        btn.classList.remove("button--opened");
      }, {
        once: true
      })
    }

    btn.classList.toggle("button--opened")
    evt.stopPropagation();
  })
})

const radioInputs = document.querySelectorAll(".radio");

radioInputs?.forEach((el) => {
  el.addEventListener("input", (evt) => {
    const radioName = evt.target.name;
    if (!radioName) return;
    const radioValue = evt.target.value;
    document.body.setAttribute(`data-radio-${radioName}`, radioValue);
    document.dispatchEvent(new CustomEvent(`data-radio-${radioName}`, {
      detail: radioValue
    }))
  })
})

const detailsMarkdown = document.getElementById('details-markdown');
const detailsPreview = document.getElementById('details-preview');

document.addEventListener("data-radio-preview", () => {
  const template = detailsMarkdown.value;
  detailsPreview.innerHTML = md.render(template);
})

const recipeContent = document.getElementById('recipe-content');
if (recipeContent) {
  const details = recipeContent.getAttribute("data-md") ?? '';
  recipeContent.innerHTML = md.render(details);
}

const starsRate = document.querySelector("#stars-rate");
starsRate?.addEventListener("click", async (evt) => {
  const target = evt.target;
  if (target.tagName !== "I") return;
  const stars = Array.from(target.parentElement.children).indexOf(target) + 1;

  const params = new URLSearchParams(location.search);
  const id = parseInt(params.get("id"));

  if (!id) return;

  const resp = await fetch("/rate", {
    method: 'post',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      id: id,
      stars: stars
    })
  }).then(resp => resp.json())

  document.querySelectorAll(".stars").forEach((el) => {
    el.innerHTML = resp.rating;
  })
  starsRate.innerHTML = resp.userRating;
})
