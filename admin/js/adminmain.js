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

const textareas = [...document.querySelectorAll('textarea')];

const changeHeightOnLoad = (item) => {
  item.style.height = `${item.scrollHeight}px`;
};

const changeHeightOnInput = (e) => {
  e.target.style.height = `${e.target.scrollHeight}px`;
};

textareas.forEach((textarea) => {
  changeHeightOnLoad(textarea);
  textarea.addEventListener('keydown', changeHeightOnInput);
});
