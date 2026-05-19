// ================================================================
// contact.js  –  AJAX submit + SweetAlert2 + inline validation
// ================================================================

document.addEventListener('DOMContentLoaded', function () {

  const form = document.getElementById('contactForm');
  if (!form) return;

  const fields = {
    name:    document.getElementById('fname'),
    email:   document.getElementById('femail'),
    subject: document.getElementById('fsubject'),
    message: document.getElementById('fmessage'),
  };

  // ── helpers ──────────────────────────────────────────────────
  function showError(input, msg) {
    input.classList.add('is-invalid-custom');
    let err = input.parentElement.querySelector('.field-error');
    if (!err) {
      err = document.createElement('div');
      err.className = 'field-error';
      input.parentElement.appendChild(err);
    }
    err.innerHTML = `<i class="bi bi-exclamation-circle-fill me-1"></i>${msg}`;
  }

  function clearError(input) {
    input.classList.remove('is-invalid-custom');
    const err = input.parentElement.querySelector('.field-error');
    if (err) err.remove();
  }

  function clearAll() {
    Object.values(fields).forEach(clearError);
  }

  // ── Submit করার পরে কোনো field ঠিক করলে শুধু সেটার error সরাবে ──
  Object.values(fields).forEach(input => {
    input.addEventListener('input', () => {
      if (input.classList.contains('is-invalid-custom')) clearError(input);
    });
  });

  // ── validators ───────────────────────────────────────────────
  function validateName() {
    const v = fields.name.value.trim();
    if (!v) { showError(fields.name, 'Name is required.'); return false; }
    if (!/^[a-zA-Z\u0980-\u09FF\s]+$/.test(v)) {
      showError(fields.name, 'Name can only contain letters — numbers or symbols are not allowed.');
      return false;
    }
    if (v.length < 2) { showError(fields.name, 'Name must be at least 2 characters long.'); return false; }
    clearError(fields.name);
    return true;
  }

  function validateEmail() {
    const v = fields.email.value.trim();
    if (!v) { showError(fields.email, 'Email is required.'); return false; }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) {
      showError(fields.email, 'Please enter a valid email address.');
      return false;
    }
    clearError(fields.email);
    return true;
  }

  function validateSubject() {
    const v = fields.subject.value.trim();
    if (!v) { showError(fields.subject, 'Subject is required.'); return false; }
    if (v.length < 3) { showError(fields.subject, 'Subject must be at least 3 characters long.'); return false; }
    clearError(fields.subject);
    return true;
  }

  function validateMessage() {
    const v = fields.message.value.trim();
    if (!v) { showError(fields.message, 'Message is required.'); return false; }
    if (v.length < 10) { showError(fields.message, 'Message must be at least 10 characters long.'); return false; }
    clearError(fields.message);
    return true;
  }

  // ── form submit → AJAX ───────────────────────────────────────
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    clearAll();
    // সব validator চালাও — একটা false হলেও বাকিগুলোও চলবে (সব error একসাথে দেখাবে)
    const results = [validateName(), validateEmail(), validateSubject(), validateMessage()];
    if (results.includes(false)) return;

    const btn = form.querySelector('#sendBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Sending...';

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(form.action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN':     csrfToken,
        'X-Requested-With': 'XMLHttpRequest',
        'Accept':           'application/json',
      },
      body: new FormData(form),
    })
    .then(res => res.json())
    .then(data => {
      btn.disabled = false;
      btn.innerHTML = '<i class="bi bi-send-fill"></i> Send Message';

      if (data.success) {
        Swal.fire({
          toast:             true,
          position:          'top-end',
          icon:              'success',
          title:             data.message || 'Message sent successfully!',
          showConfirmButton: false,
          timer:             3500,
          timerProgressBar:  true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
          }
        });
        form.reset();
        clearAll();

      } else if (data.errors) {
        if (data.errors.name)    showError(fields.name,    data.errors.name[0]);
        if (data.errors.email)   showError(fields.email,   data.errors.email[0]);
        if (data.errors.subject) showError(fields.subject, data.errors.subject[0]);
        if (data.errors.message) showError(fields.message, data.errors.message[0]);
      }
    })
    .catch(() => {
      btn.disabled = false;
      btn.innerHTML = '<i class="bi bi-send-fill"></i> Send Message';
      Swal.fire({
        toast:             true,
        position:          'top-end',
        icon:              'error',
        title:             'Something went wrong. Please try again.',
        showConfirmButton: false,
        timer:             3000,
        timerProgressBar:  true,
      });
    });
  });

  window.handleSend = function () {};

});