



//   Create Account JS

if (document.getElementById('register-btn')) {
 
  const regEmail  = document.getElementById('reg-email');
  const regPw     = document.getElementById('reg-password');
  const regCpw    = document.getElementById('reg-confirm-password');
  const fEmail    = document.getElementById('field-reg-email');
  const fPw       = document.getElementById('field-reg-pw');
  const fCpw      = document.getElementById('field-reg-cpw');
  const errEmail  = document.getElementById('reg-email-err');
  const errPw     = document.getElementById('reg-pw-err');
  const errCpw    = document.getElementById('reg-cpw-err');
  const errTerms  = document.getElementById('register-terms-err');
  const regBtn    = document.getElementById('register-btn');
  const toastEl   = document.getElementById('register-toast');
  let pwVis = false, cpwVis = false;
 
  /* ── Toast ── */
  function showRegToast(msg, type = '') {
    toastEl.textContent = msg;
    toastEl.className = 'show ' + type;
    clearTimeout(toastEl._t);
    toastEl._t = setTimeout(() => toastEl.className = '', 2800);
  }
 
  /* ── Eye toggles ── */
  const EYE_OPEN   = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
  const EYE_CLOSED = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23" stroke-linecap="round"/>';
 
  document.getElementById('toggle-reg-pw').addEventListener('click', () => {
    pwVis = !pwVis;
    regPw.type = pwVis ? 'text' : 'password';
    document.getElementById('eye-icon-pw').innerHTML = pwVis ? EYE_CLOSED : EYE_OPEN;
  });
 
  document.getElementById('toggle-reg-cpw').addEventListener('click', () => {
    cpwVis = !cpwVis;
    regCpw.type = cpwVis ? 'text' : 'password';
    document.getElementById('eye-icon-cpw').innerHTML = cpwVis ? EYE_CLOSED : EYE_OPEN;
  });
 
  /* ── Validators ── */
  function valEmail(v) {
    const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
    fEmail.classList.toggle('has-error', !ok);
    errEmail.classList.toggle('show', !ok);
    return ok;
  }
 
  function valPw(v) {
    const ok = v.length >= 6;
    fPw.classList.toggle('has-error', !ok);
    errPw.classList.toggle('show', !ok);
    return ok;
  }
 
  function valCpw(v) {
    const ok = v === regPw.value && v.length > 0;
    fCpw.classList.toggle('has-error', !ok);
    errCpw.classList.toggle('show', !ok);
    return ok;
  }
 
  /* ── Blur listeners ── */
  regEmail.addEventListener('blur',  () => valEmail(regEmail.value.trim()));
  regPw.addEventListener('blur',     () => valPw(regPw.value));
  regCpw.addEventListener('blur',    () => valCpw(regCpw.value));
 
  regEmail.addEventListener('input', () => { if (fEmail.classList.contains('has-error')) valEmail(regEmail.value.trim()); });
  regPw.addEventListener('input',    () => { if (fPw.classList.contains('has-error'))    valPw(regPw.value); });
  regCpw.addEventListener('input',   () => { if (fCpw.classList.contains('has-error'))   valCpw(regCpw.value); });
 
  /* ── Submit ── */
  regBtn.addEventListener('click', () => {
    const e1 = valEmail(regEmail.value.trim());
    const e2 = valPw(regPw.value);
    const e3 = valCpw(regCpw.value);
    const terms = document.getElementById('reg-terms').checked;
    errTerms.classList.toggle('show', !terms);
 
    if (!e1 || !e2 || !e3 || !terms) {
      showRegToast('Please fix the errors above.', 'error-toast');
      return;
    }
 
    regBtn.textContent = 'Creating account';
    regBtn.classList.add('loading');
    setTimeout(() => {
      regBtn.classList.remove('loading');
      regBtn.textContent = 'Create Account';
      showRegToast('Account created successfully!', 'success');
    }, 1800);
  });
}