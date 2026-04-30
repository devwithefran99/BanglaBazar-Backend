/* wishlist.js — BanglaBazar */

// ── Cart button এর সাথে conflict আটকাও ──
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.wishlist-btn');
    if (!btn) return;

    e.preventDefault();   
    e.stopPropagation();  

    const productId   = btn.dataset.productId;
    const productType = btn.dataset.productType || 'product';

    if (!productId) {
        console.error('Product ID missing!');
        return;
    }

    const WISHLIST_URL = document.querySelector('meta[name="wishlist-url"]')?.content;
    const CSRF         = document.querySelector('meta[name="csrf-token"]')?.content;

    if (!WISHLIST_URL || !CSRF) {
        console.error('Meta tags missing!');
        return;
    }

    fetch(WISHLIST_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'Accept':       'application/json',
        },
        body: JSON.stringify({
            product_id:   productId,
            product_type: productType,
        }),
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success && data.redirect) {
            window.location.href = data.redirect;
            return;
        }

        if (data.success) {
            const icon = btn.querySelector('i');
            if (data.added) {
                icon.className = 'bi bi-heart-fill';
                icon.style.color = '#e74c3c';
                showWishlistToast('❤️ Added to wishlist!');
            } else {
                icon.className = 'bi bi-heart';
                icon.style.color = '';
                showWishlistToast('💔 Removed from wishlist!');
            }

            document.querySelectorAll('#wishlistCount').forEach(el => {
                el.textContent = data.count;
            });
        }
    })
    .catch(err => {
        console.error('Wishlist error:', err);
        showWishlistToast('Something went wrong!');
    });
});

// ── Toast ──
function showWishlistToast(msg) {
    let toast = document.getElementById('wishlist-toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'wishlist-toast';
        toast.style.cssText = `
            position:fixed; bottom:24px; left:50%;
            transform:translateX(-50%) translateY(30px);
            background:#222; color:#fff;
            padding:10px 22px; border-radius:30px;
            font-size:.88rem; font-weight:600;
            opacity:0; transition:all .3s; z-index:9999;
            white-space:nowrap;
        `;
        document.body.appendChild(toast);
    }
    toast.textContent = msg;
    toast.style.opacity = '1';
    toast.style.transform = 'translateX(-50%) translateY(0)';
    clearTimeout(toast._t);
    toast._t = setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(-50%) translateY(30px)';
    }, 2500);
}