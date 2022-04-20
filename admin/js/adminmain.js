/*
 *  
 * use a query selector to get the elements inside .navigation with the class
 *      of admin-link.
 * That gives us a HTML collection, we spread it into an array with the spreader
 *    operator.
 * 
 */
const list = [...document.querySelectorAll('.navigation .admin-link')];
list.shift(); // remove first element, title, we do not need it for the hover effect.

/**
 *
 * Get the window location, and give a hover effect on the navbar,
 *      to the specific link.
 *
 */
const path = window.location.pathname;
const fileLocation = path.substring(path.lastIndexOf('/') + 1);

switch (fileLocation) {
  case 'index.php':
    list[0].classList.add('active');
    break;
  case 'posts.php':
    list[1].classList.add('active');
    break;
  case 'users.php':
    list[2].classList.add('active');
    break;
}


const htmlFormMarkup = `
    <div class="body-sub-title-paragraph">
        <div class="input-field">
            <label for="title">Sub Title</label>
            <input type="text" name="subtitle[]" id="title" required>
        </div>
        <div class="input-field">
            <label for="paragraph">Paragraph</label>
            <textarea name="paragraph[]" id="paragraph" required></textarea>
        </div>
    </div>`

const addFieldButton = document.getElementById('add-another-field');
const formFields = document.getElementById('body-fields-wrapper');
addFieldButton.addEventListener('click', () => {
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