    const togglePassword = document.getElementById('showpass');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
      const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordField.setAttribute('type', type);

      // Ganti ikon
      this.classList.toggle('bx-eye-slash');
      this.classList.toggle('bx-eye');
    });

    const togglePassword2 = document.getElementById('showpass2');
    const passwordField2 = document.getElementById('password2');

    togglePassword2.addEventListener('click', function() {
      const type = passwordField2.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordField2.setAttribute('type', type);

      // Ganti ikon
      this.classList.toggle('bx-eye-slash');
      this.classList.toggle('bx-eye');
    });