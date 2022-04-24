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
 * Get the window location, and give a hover effect on the sidebar,
 *      to the specific link using a switch statement.
 * We use the location.pathname to get the current page.
 *   and we split the pathname by '/' 
 *      and use lastIndexOf to get the last index of the last '/' 
 *        and add one to it to get the last part of the path.
 * then we switch through the fileLocation variable to change the needed class to the sidebar links.
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

// get all the textarea elements from the dom and spread it into an array with the spreader operator, and store them in the textareas constant.
const textareas = [...document.querySelectorAll('textarea')];

// a function that takes an item as a parameter and changes the height of that item to the height of the content.
const changeHeightOnLoad = (item) => {
  item.style.height = `${item.scrollHeight}px`;
};

// the same function as above but this time it takes an event as a parameter. so that we can assign it to be called on a certain event
const changeHeightOnInput = (e) => {
  e.target.style.height = `${e.target.scrollHeight}px`;
};

/**
 * 
 * we loop through the textareas array and call the changeHeightOnLoad function on each item 
 *   to change the height so that when the page loads the height fits the content inside.
 *     and we add an event listener to each textarea to listen for the keydown event.
 * 
 */
textareas.forEach((textarea) => {
  changeHeightOnLoad(textarea);
  textarea.addEventListener('keydown', changeHeightOnInput);
});
