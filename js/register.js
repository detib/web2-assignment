/*
 *
 * This script is used by the register.php page
 * and it is used to validate the inputs the users put through the form
 *
 */

// register form
const form = document.getElementById('register-form');
// email input
const email = document.getElementById('email');
// email input error box for when the email is not valid
const emailError = document.getElementById('email-exists');
// username input
const username = document.getElementById('username');
// username input error box for when the username is not valid
const usernameError = document.getElementById('username-exists');
// password input
const password = document.getElementById('password');
// password input error box for when the password is not valid
const passwordError = document.getElementById('password-error');
// submit button of the form
const submit = document.getElementById('submit');

let emailDisable = false;
let usernameDisable = false;
let passwordDisable = false;

email.addEventListener('keyup', () => {
  // we create a new XMLHttpRequest object
  const conn = new XMLHttpRequest();

  /*
   * onreadystatechange is a property of XMLHttpRequest objects
   * it is a function that is called every time the readyState changes
   *
   */
  conn.onreadystatechange = () => {
    /*
     * conn.readyState is a property of the XMLHttpRequest object
     * it returns the current state of the request
     * 0: request not initialized
     * 1: server connection established
     * 2: request received
     * 3: processing request
     * 4: request finished and response is ready
     * so we check when the state is 4 so we have the response ready
     * and we check the status of the response so we know if the request was successful
     * if the response status is 200 (everything is ok)
     * then we do something with the response given
     * in this case we check if it is true or false and we display the error message if true
     * it is a function that is called every time the readyState changes
     *
     */
    if (conn.readyState === 4 && conn.status === 200) {
      conn.responseText == true ? (emailDisable = true) : (emailDisable = false);
      emailError.style.display = conn.responseText == true ? 'block' : 'none';
    }
    validateInputs();
  };

  /*
   *
   * conn.open is a method of the XMLHttpRequest object
   * it takes 3 parameters:
   * 1. the type of request
   * 2. the url
   * 3. whether or not to send asynchronously (optional - default is true)
   * in this case we are sending a GET request
   * the url is the url of the php file that we want to send the request to
   * We send the request as a get method appended in the url,
   *    so that the php file can query the database for the exact
   *    email written in the input
   *
   */
  conn.open('GET', './config/email.php?email=' + email.value);
  conn.send();
});

/*
 *
 * This event listener is for the username input
 * it checks if the username is already taken
 * if it is taken then the submit button is disabled
 * it works in the same way as the email input
 * it sends a request to the php script
 *
 */
username.addEventListener('keyup', () => {
  const conn = new XMLHttpRequest();

  conn.onreadystatechange = () => {
    if (conn.readyState === 4 && conn.status === 200) {
      conn.responseText == true ? (usernameDisable = true) : (usernameDisable = false);
      usernameError.style.display = conn.responseText == true ? 'block' : 'none';
    }
    validateInputs();
  };

  conn.open('GET', './config/username.php?username=' + username.value);
  conn.send();
});

/*
 *
 * event listener for the password input field
 * this event listener listens for the keyup event
 * The keyup event is triggered when a user releases a key on the keyboard
 *
 */
password.addEventListener('keyup', (e) => {
  /*
   *
   * regular expression that checks that the password is 8 characters long,
   * has 1 uppercase letter and 1 number
   *
   */
  const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
  /*
   * if the password does not match the regex, the error message is shown
   * we check the matching with the test() method
   *
   * if the password does not match the regex, the form is also disabled
   * the form is disabled because we disable the submit button by adding
   * the disabled attribute to the submit button
   */
  if (e.target.value.length > 0) {
    if (regex.test(e.target.value)) {
      passwordError.style.display = 'none';
      passwordDisable = false;
    } else {
      passwordError.style.display = 'block';
      passwordDisable = true;
    }
  }
  validateInputs();
});

const validateInputs = () => {
  /**
   *
   * This function is used to check the inputs of the form
   * if they are not valid then the submit button is disabled
   * and the form cannot be submitted
   * if they are valid then the submit button is enabled
   * and the form can be submitted
   *
   */
  console.log(emailDisable + ' ' + usernameDisable + ' ' + passwordDisable);
  if (emailDisable || usernameDisable || passwordDisable) {
    submit.disabled = true;
  } else {
    submit.disabled = false;
  }
};
