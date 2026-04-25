

// main content
// Categories Array (একই রাখো)
const categories = [
  { name: "Vegetables", count: 150, slug: "vegetables",active: true},
    { name: "Fresh Fruit", count: 25, slug: "fresh-fruit", },
    { name: "Cooking", count: 54, slug: "cooking" },
    { name: "Snacks", count: 47, slug: "snacks" },
    { name: "Beverages", count: 43, slug: "beverages" },
    { name: "Beauty & Health", count: 38, slug: "beauty-health" },
    { name: "Bread & Bakery", count: 15, slug: "bread-bakery" }
];

function renderCategories() {
    const container = document.getElementById('categories-list');
    container.innerHTML = '';
    
    categories.forEach(cat => {
        const div = document.createElement('div');
        div.className = `category-item d-flex align-items-center justify-content-between py-2 px-3 rounded-3 mb-1 cursor-pointer ${cat.active ? 'active' : ''}`;
        
        div.innerHTML = `
            <div><i class="bi bi-circle-fill me-2" style="font-size:10px;"></i> ${cat.name}</div>
            <span class="badge bg-light text-dark">${cat.count}</span>
        `;
        
        div.onclick = () => {
            // Active class update
            document.querySelectorAll('.category-item').forEach(el => el.classList.remove('active'));
            div.classList.add('active');
            
            // Filter products
            filterByCategory(cat.slug);
            
            // Mobile এ category সিলেক্ট করলে sidebar hide হয়ে যাবে
            if (window.innerWidth < 992) {
                closeSidebar();
            }
        };
        container.appendChild(div);
    });
}

function filterByCategory(categorySlug) {
    const allCards = document.querySelectorAll('.product-col');
    
    allCards.forEach(card => {
        if (categorySlug === 'all' || card.classList.contains(categorySlug)) {
            card.classList.remove('hidden');
        } else {
            card.classList.add('hidden');
        }
    });
}

function filterProducts() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
    const allCards = document.querySelectorAll('.product-col');
    
    allCards.forEach(card => {
        const nameEl = card.querySelector('.product-name');
        if (!nameEl) return;
        const name = nameEl.textContent.toLowerCase();
        
        if (name.includes(searchTerm)) {
            card.classList.remove('hidden');
        } else {
            card.classList.add('hidden');
        }
    });
}

// Close Sidebar Function
function closeSidebar() {
    const sidebar = document.getElementById('filter-sidebar');
    sidebar.classList.remove('show');
    
    // Backdrop hide
    const backdrop = document.querySelector('.sidebar-backdrop');
    if (backdrop) backdrop.style.display = 'none';
}

// Toggle Sidebar (Filter button থেকে)
function toggleSidebar() {
    const sidebar = document.getElementById('filter-sidebar');
    let backdrop = document.querySelector('.sidebar-backdrop');

    if (!backdrop) {
        backdrop = document.createElement('div');
        backdrop.className = 'sidebar-backdrop';
        document.body.appendChild(backdrop);

        backdrop.addEventListener('click', closeSidebar);
    }

    const isVisible = sidebar.classList.contains('show');
    
    if (isVisible) {
        closeSidebar();
    } else {
        sidebar.classList.add('show');
        backdrop.style.display = 'block';
    }
}

// Click outside to close (mobile)
document.addEventListener('click', function(e) {
    if (window.innerWidth >= 992) return; // Desktop এ কাজ করবে না

    const sidebar = document.getElementById('filter-sidebar');
    const filterBtn = e.target.closest('.filter-btn');

    if (!sidebar.contains(e.target) && !filterBtn) {
        if (sidebar.classList.contains('show')) {
            closeSidebar();
        }
    }
});
const popularTags = [
    { name: "Healthy",      active: true },
    { name: "Low fat",      active: false },
    { name: "Vegetarian",   active: false },
    { name: "Kid foods",    active: false },
    { name: "Vitamins",     active: false },
    { name: "Bread",        active: false },
    { name: "Meat",         active: false },
    { name: "Snacks",       active: false },
    { name: "Tiffin",       active: false },
    { name: "Lunch",        active: false },
    { name: "Dinner",       active: false },
    { name: "Breakfast",    active: false },
    { name: "Fruit",        active: false }
];

function renderPopularTags() {
    const container = document.getElementById('tags-container');
    container.innerHTML = '';

    popularTags.forEach(tag => {
        const btn = document.createElement('button');
        btn.className = `tag-btn ${tag.active ? 'active' : ''}`;
        btn.textContent = tag.name;
        
        btn.onclick = () => {
            // Optional: Tag click-এ ফিল্টার করতে চাইলে এখানে লজিক দিতে পারো
            // এখন শুধু active style দেখানোর জন্য
            document.querySelectorAll('.tag-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            console.log(`Tag clicked: ${tag.name}`);
            // filterProducts() কল করতে পারো যদি tag দিয়ে ফিল্টার করতে চাও
        };
        
        container.appendChild(btn);
    });
}

// Initialize
window.onload = () => {
    renderCategories();
    renderPopularTags();        // ← নতুন যোগ করা হয়েছে
    filterByCategory('vegetables');   // Default show vegetables
    
};



/* ═══════════════════════════════════════════════
   NAVBAR ACTIVE PAGE DETECTOR
   তোমার existing navbar design এর সাথে মিলিয়ে বানানো
   ═══════════════════════════════════════════════ */

