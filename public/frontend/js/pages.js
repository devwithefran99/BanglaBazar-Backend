// preloader js
window.addEventListener('load', function() {
  const preloader = document.getElementById('preloader');
  
  // ১ সেকেন্ড পর preloader hide করবে (তুমি চাইলে সময় বাড়াতে বা কমাতে পারো)
  setTimeout(() => {
    preloader.classList.add('fade-out');   // ← এটা আমার CSS এর class
    
    // অ্যানিমেশন শেষ হলে DOM থেকে সরিয়ে ফেলবে (performance ভালো থাকবে)
    setTimeout(() => {
      preloader.style.display = 'none';
      preloader.remove();        // optional - পুরোপুরি remove
    }, 800);
  }, 1200);   // 1200ms = 1.2 সেকেন্ড (সুন্দর লাগে)
});
// preloader js ends

// navbar js
document.querySelectorAll('.main-navbar .nav-item').forEach((el, i) => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(-8px)';
    el.style.transition = `opacity .3s ease ${i * 60}ms, transform .3s ease ${i * 60}ms`;
    setTimeout(() => {
      el.style.opacity = '1';
      el.style.transform = 'translateY(0)';
    }, 50);
  });

//   nav bar js ends

// dropdown submenu 
document.querySelectorAll('.mobile-toggle').forEach(item => {
    item.addEventListener('click', function () {
      this.parentElement.classList.toggle('active');
    });
  });
// dropdown submenu ends

// wishlist JS
 let toastTimer;
  function showToast(msg) {
    const wrap = document.getElementById('toastWrap');
    const el   = document.getElementById('toastMsg');
    el.textContent = msg;
    wrap.style.display = 'block';
    el.style.animation = 'none';
    void el.offsetWidth;
    el.style.animation = 'slideUp 0.3s ease';
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => { wrap.style.display = 'none'; }, 2800);
  }
 
  function removeCard(id) {
    const card = document.getElementById(id);
    card.style.transition = 'opacity 0.3s, transform 0.3s';
    card.style.opacity = '0';
    card.style.transform = 'translateX(20px)';
    setTimeout(() => card.remove(), 300);
    showToast('🗑 Item removed from wishlist');
  }

// wishlist JS  

// CheckOut JS starts ////

let qty = 1;

function changeQty(d) {
  const next = qty + d;
  if (next < 1) {
    showToast('Minimum quantity is 1');
    return;
  }
  qty = next;
  document.getElementById('qtyNum').textContent = qty;
}

function showToast(msg) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.classList.add('show');
  clearTimeout(t._t);
  t._t = setTimeout(() => t.classList.remove('show'), 2500);
}

function addToCart() {
  showToast('✓ Added ' + qty + ' item(s) to cart');
}

function buyNow() {
  document.getElementById('modalMsg').innerHTML = 'You\'re ordering <strong>' + qty + ' × Chinese Cabbage</strong>. Choose your payment method:';
  document.getElementById('buyModal').classList.add('open');
}

function closeModal() {
  document.getElementById('buyModal').classList.remove('open');
}

function confirmOrder() {
  const pay = document.querySelector('input[name="pay"]:checked').value;
  closeModal();
  showToast('🎉 Order placed via ' + (pay === 'cod' ? 'Cash on Delivery' : 'bKash') + '!');
}

document.getElementById('thumbs').querySelectorAll('.pd-thumb').forEach((th) => {
  th.addEventListener('click', () => {
    document.querySelectorAll('.pd-thumb').forEach(t => t.classList.remove('active'));
    th.classList.add('active');
    const src = th.querySelector('img').src;
    document.getElementById('mainImg').src = src;
  });
});

document.getElementById('buyModal').addEventListener('click', function(e) {
  if (e.target === this) closeModal();
});

// details cheackout starts
function switchTab(id, btn) {
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  document.getElementById('tab-' + id).classList.add('active');
  btn.classList.add('active');
}
// details checkout ends

// userDashboard js starts
const orders=[
  {name:"Running Shoes",date:"8 Sep, 2020",qty:5,total:135,status:"processing"},
  {name:"Wireless Headphones",date:"24 May, 2020",qty:1,total:25,status:"onway"},
  {name:"Smart Watch Set",date:"22 Oct, 2020",qty:4,total:250,status:"done"},
  {name:"Gym Water Bottle",date:"1 Feb, 2020",qty:1,total:35,status:"done"},
  {name:"Leather Backpack",date:"21 Sep, 2020",qty:13,total:578,status:"done"},
  {name:"Desk Organizer",date:"22 Oct, 2020",qty:7,total:345,status:"done"},
];
const statusLabels={processing:"Processing",onway:"On the Way",done:"Completed"};
 
const list=document.getElementById("order-list");
orders.forEach(o=>{
  const row=document.createElement("div");
  row.className="order-row";
  row.innerHTML=`
    <div><div class="order-name">${o.name}</div><div class="order-date">${o.date}</div></div>
    <div class="qty-cell">${o.qty} pcs</div>
    <div class="total-cell">$${o.total.toFixed(2)}</div>
    <div><span class="badge ${o.status}">${statusLabels[o.status]}</span></div>`;
  list.appendChild(row);
});
 
function openSidebar(){document.getElementById("sidebar").classList.add("open");document.getElementById("overlay").classList.add("open")}
function closeSidebar(){document.getElementById("sidebar").classList.remove("open");document.getElementById("overlay").classList.remove("open")}
 
const CONTEXT=`You are a friendly ecommerce assistant for Dianne Russell. Her orders: ${JSON.stringify(orders.map(o=>({product:o.name,qty:o.qty,total:"$"+o.total,status:o.status,date:o.date})))}. Answer in 1-3 short sentences, be friendly and concise.`;
 
async function sendQ(preset){
  const input=document.getElementById("ai-q");
  const q=preset||input.value.trim();
  if(!q)return;
  input.value="";
  const msgs=document.getElementById("ai-messages");
  const btn=document.getElementById("ai-btn");
  msgs.innerHTML+=`<div class="user-bubble">${q}</div>`;
  const typing=document.createElement("div");
  typing.className="typing";
  typing.innerHTML=`<div class="dot"></div><div class="dot"></div><div class="dot"></div>`;
  msgs.appendChild(typing);
  msgs.scrollTop=msgs.scrollHeight;
  btn.disabled=true;
  try{
    const r=await fetch("https://api.anthropic.com/v1/messages",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({model:"claude-sonnet-4-20250514",max_tokens:1000,system:CONTEXT,messages:[{role:"user",content:q}]})});
    const d=await r.json();
    const txt=d.content?.find(c=>c.type==="text")?.text||"Sorry, I couldn't get a response.";
    typing.remove();
    msgs.innerHTML+=`<div class="ai-bubble">${txt}</div>`;
  }catch(e){
    typing.remove();
    msgs.innerHTML+=`<div class="ai-bubble">Connection error. Please try again.</div>`;
  }
  btn.disabled=false;
  msgs.scrollTop=msgs.scrollHeight;
}

// userdashboard js ends

// billing js starts
/* Payment method highlight */
  document.querySelectorAll('#blPayGroup input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', () => {
      document.querySelectorAll('#blPayGroup .bl-radio-option').forEach(opt => opt.classList.remove('selected'));
      radio.closest('.bl-radio-option').classList.add('selected');
    });
  });
 
  /* Ship to different address toggle (optional: show/hide extra fields) */
  document.getElementById('blShipDiff').addEventListener('change', function () {
    /* extend: show a secondary address form here */
  });
 
  function placeOrder() {
    alert('Order Placed! 🎉');
  }
// billing js ends


