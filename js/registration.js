
$('document').ready(() => {

   let validEmail = false;
   let validPassword = false;
   let validName = false;
   let validUsername = false;

   //VALIDACIJA ZA EMAIL
   $('#email').on('input', () => {
      const email = $('#email');
      const emailErr = $('#emailErr');
      const emailStatus = $('#emailStatus');

      if (email.val().length >= 4 && !email.val().includes('@')) {
         emailErr.html('<i class="fa-solid fa-triangle-exclamation error"></i>');
         emailStatus.html('Email must be valid.');
      } else if (email.val().length < 4) {
         emailErr.html('');
         emailStatus.html('');
      }
      else {
         emailErr.html('<i class="fa-solid fa-check success"></i>');
         emailStatus.html('');
         validEmail = true;
      }
   });

   //VALIDACIJA ZA NAME
   $('#name').on('input', () => {
      const name = $('#name');
      const nameErr = $('#nameErr');
      const nameStatus = $('#nameStatus');

      if (name.val().split(' ').length < 2) {
         nameErr.html('<i class="fa-solid fa-triangle-exclamation error"></i>');
         nameStatus.html('You must include your full name.');
      } else if (name.val().length < 4) {
         nameErr.html('');
         nameStatus.html('');
      }
      else {
         nameErr.html('<i class="fa-solid fa-check success"></i>');
         nameStatus.html('')
         validName = true;
      }
   });


   //VALIDA ZA USERNAME
   $('#username').on('input', () => {
      const username = $('#username');
      const usernameErr = $('#usernameErr');
      const usernameStatus = $('#usernameStatus');
      const regex = /[!@#$%^&*(),.?":{} |<>]/g;

      if (regex.test(username.val()) || username.val().length >= 30) {
         usernameErr.html('<i class="fa-solid fa-triangle-exclamation error"></i>');
         usernameStatus.html('Username must be all lowercase letters and no special characters. 30 characters maximum. !@#$%^&*()');
      } else if (username.val().length < 3) {
         usernameErr.html('');
         usernameStatus.html('');
      }
      else {
         usernameErr.html('<i class="fa-solid fa-check success"></i>');
         usernameStatus.html('');
         validUsername = true;
      }
   });

   //VALIDA ZA PASSWORD
   $('#password').on('input', () => {
      const password = $('#password');
      const passwordErr = $('#passwordErr');
      const passwordStatus = $('#passwordStatus');

      if (password.val().length < 8 || password.val().length > 20) {
         passwordErr.html('<i class="fa-solid fa-triangle-exclamation error"></i>');
         passwordStatus.html("Password length must be greater than 8 and less than 20 characters.");
      }
      else {
         passwordErr.html('<i class="fa-solid fa-check success"></i>');
         passwordStatus.html('');
         validPassword = true;
      }
   });

   //DUGME VALIDACIJA
   $('#name, #username, #email, #password').on('change', () => {
      if (validEmail && validName && validPassword && validUsername) {
         $('#submit-btn').attr('disabled', false);
      } else {
         $('#submit-btn').attr('disabled', true);
      }
   })
});
