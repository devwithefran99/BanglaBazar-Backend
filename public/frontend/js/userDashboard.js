
  /* Dynamic greeting — safe to add inside userDashboard.js too */
        (function () {
            const h = new Date().getHours();
            const text = h < 12 ? 'Good morning' : h < 17 ? 'Good afternoon' : 'Good evening';
            const el = document.getElementById('udbGreeting');
            if (el) el.innerHTML = text + ', Erfan ✦';
        })();
 
        function editProfile()  { alert('Edit Profile — Coming Soon 🔥'); }
        function editAddress()  { alert('Address Updated!'); }
        function viewAllOrders(){ alert('All Orders Page'); }
// userDashboard js ends

