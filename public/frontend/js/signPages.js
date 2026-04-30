/* signPages.js — BanglaBazar */

// ── Toast ──────────────────────────────
function showToast(msg, type = 'success') {
    let toast = document.getElementById('toast') || document.getElementById('register-toast');
    if (!toast) return;
    toast.textContent = msg;
    toast.className = 'toast toast-' + type + ' show';
    setTimeout(() => toast.classList.remove('show'), 3500);
}

// ── Validation ──────────────────────────
function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.trim());
}

function showErr(fieldId, errId, msg) {
    const f = document.getElementById(fieldId);
    const e = document.getElementById(errId);
    if (f) f.classList.add('error');
    if (e) { e.querySelector ? (e.style.display = 'flex') : null; e.style.display = 'flex'; }
}

function clearErr(fieldId, errId) {
    const f = document.getElementById(fieldId);
    const e = document.getElementById(errId);
    if (f) f.classList.remove('error');
    if (e) e.style.display = 'none';
}

// ── Password Toggle ──────────────────────
function togglePw(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (!input) return;
    input.type = input.type === 'password' ? 'text' : 'password';
    if (icon) icon.innerHTML = input.type === 'password'
        ? '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'
        : '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
}

// ══════════════════════════════════════════
//  SIGN IN
// ══════════════════════════════════════════
const loginBtn = document.getElementById('login-btn');
if (loginBtn) {

    // Password toggle
    document.getElementById('toggle-pw')?.addEventListener('click', () => togglePw('password', 'eye-icon'));

    // Clear errors on type
    document.getElementById('email')?.addEventListener('input', () => clearErr('field-email', 'email-err'));
    document.getElementById('password')?.addEventListener('input', () => clearErr('field-pw', 'pw-err'));

    loginBtn.addEventListener('click', async () => {
        const email = document.getElementById('email').value.trim();
        const pw    = document.getElementById('password').value;
        let valid   = true;

        if (!isValidEmail(email)) {
            showErr('field-email', 'email-err'); valid = false;
        }
        if (!pw || pw.length < 6) {
            showErr('field-pw', 'pw-err'); valid = false;
        }
        if (!valid) return;

        loginBtn.disabled = true;
        loginBtn.textContent = 'Signing in...';

        try {
            const res  = await fetch(SIGNIN_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ email, password: pw, remember: document.getElementById('remember')?.checked ? 1 : 0 }),
            });
            const data = await res.json();

            if (data.success) {
                showToast(data.message, 'success');
                setTimeout(() => window.location.href = data.redirect, 1000);
            } else {
                showToast(data.message || 'Invalid credentials.', 'error');
                loginBtn.disabled = false;
                loginBtn.textContent = 'Login';
            }
        } catch {
            showToast('Something went wrong!', 'error');
            loginBtn.disabled = false;
            loginBtn.textContent = 'Login';
        }
    });

    // Enter key support
    document.getElementById('password')?.addEventListener('keydown', e => {
        if (e.key === 'Enter') loginBtn.click();
    });
}

// ══════════════════════════════════════════
//  REGISTER
// ══════════════════════════════════════════
const registerBtn = document.getElementById('register-btn');
if (registerBtn) {

    document.getElementById('toggle-reg-pw')?.addEventListener('click',  () => togglePw('reg-password',         'eye-icon-pw'));
    document.getElementById('toggle-reg-cpw')?.addEventListener('click', () => togglePw('reg-confirm-password', 'eye-icon-cpw'));

    document.getElementById('reg-email')?.addEventListener('input',            () => clearErr('field-reg-email', 'reg-email-err'));
    document.getElementById('reg-password')?.addEventListener('input',         () => clearErr('field-reg-pw',    'reg-pw-err'));
    document.getElementById('reg-confirm-password')?.addEventListener('input', () => clearErr('field-reg-cpw',   'reg-cpw-err'));

    registerBtn.addEventListener('click', async () => {
        const email = document.getElementById('reg-email').value.trim();
        const pw    = document.getElementById('reg-password').value;
        const cpw   = document.getElementById('reg-confirm-password').value;
        const terms = document.getElementById('reg-terms')?.checked;
        let valid   = true;

        if (!isValidEmail(email)) { showErr('field-reg-email', 'reg-email-err'); valid = false; }
        if (!pw || pw.length < 6) { showErr('field-reg-pw',    'reg-pw-err');    valid = false; }
        if (pw !== cpw)           { showErr('field-reg-cpw',   'reg-cpw-err');   valid = false; }
        if (!terms) {
            const termsErr = document.getElementById('register-terms-err');
            if (termsErr) termsErr.style.display = 'flex';
            valid = false;
        }
        if (!valid) return;

        registerBtn.disabled = true;
        registerBtn.textContent = 'Creating...';

        try {
            const res  = await fetch(REGISTER_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    email,
                    password: pw,
                    password_confirmation: cpw,
                    terms: terms ? 'on' : '',
                }),
            });
            const data = await res.json();

            if (data.success) {
                showToast(data.message, 'success');
                setTimeout(() => window.location.href = data.redirect, 1200);
            } else {
                if (data.errors?.email) showToast(data.errors.email[0], 'error');
                else showToast(data.message || 'Registration failed.', 'error');
                registerBtn.disabled = false;
                registerBtn.textContent = 'Create Account';
            }
        } catch {
            showToast('Something went wrong!', 'error');
            registerBtn.disabled = false;
            registerBtn.textContent = 'Create Account';
        }
    });
}