const htmlFormMarkup = `
<div class="body-sub-title-paragraph">
    <div class="input-field">
        <label>Sub Title</label>
        <input type="text" name="subtitle[]" required>
    </div>
    <div class="input-field">
        <label>Paragraph</label>
        <textarea name="paragraph[]" required></textarea>
    </div>
</div>`

const addFieldButton = document.getElementById('add-another-field');
const formFields = document.getElementById('body-fields-wrapper');
addFieldButton?.addEventListener('click', () => {
const div = document.createElement('div');
div.innerHTML = htmlFormMarkup.trim();
formFields.appendChild(div.firstElementChild);
})

removeFieldButton = document.getElementById('remove-field');
removeFieldButton.addEventListener('click', () => {
const lastChild = formFields.lastElementChild;
if (lastChild && formFields.children.length > 1) {
formFields.removeChild(lastChild);
}
})
