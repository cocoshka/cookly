import markdownIt from 'https://cdn.jsdelivr.net/npm/markdown-it@13.0.1/+esm'

const md = markdownIt()

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
if (!!recipeContent) {
  const details = recipeContent.getAttribute("data-md") ?? '';
  recipeContent.innerHTML = md.render(details);
}
