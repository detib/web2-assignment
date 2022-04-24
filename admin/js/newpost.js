/**
 *
 * html markup of the form element for the new post:
 * this is the same markup as it is used on the new post page in the admin panel.
 * it is used to add a new field for the form and uses the same names for the inputs.
 *
 *  */
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
</div>`;

// get the button with the id of add-another-field from the dom
const addFieldButton = document.getElementById('add-another-field');
// get the form fields container from the dom
const formFields = document.getElementById('body-fields-wrapper');

/**
 *
 * This is the function that is called when the add-another-field button is clicked.
 * It adds the html markup to the form fields container.
 * it uses a special syntax before the addEventListener the "?"
 *   to make sure that the variable is defined.
 *
 */
addFieldButton?.addEventListener('click', () => {
  // create a variable that creates a div element
  const div = document.createElement('div');
  // add the html markup to the div element
  div.innerHTML = htmlFormMarkup.trim();
  // append the div elements firstchild to the form fields container, we create the div only to be as a temporary holder for the html markup.
  formFields.appendChild(div.firstElementChild);
});

// we get the remove-field button from the dom
removeFieldButton = document.getElementById('remove-field');
// we add a click event listener that calls a function to remove the last child of the form fields container
removeFieldButton.addEventListener('click', () => {
    // get the last child of the form fields container and store in a variable
  const lastChild = formFields.lastElementChild;
    /**
     * we use the removeChild method to remove the last child of the form fields container
     *   when the condition that it is not leaving the form without at least one field and lastchild exists.
     */
  if (lastChild && formFields.children.length > 1) {
    formFields.removeChild(lastChild);
  }
});
