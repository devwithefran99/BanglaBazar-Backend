
  /* Dynamic greeting — safe to add inside userDashboard.js too */
        (function () {
            const h = new Date().getHours();
            const text = h < 12 ? 'Good morning' : h < 17 ? 'Good afternoon' : 'Good evening';
            const el = document.getElementById('udbGreeting');
            if (el) el.innerHTML = text + ', Erfan ✦';
        })();

        function viewAllOrders(){ alert('All Orders Page'); }

        (function () {
    const h = new Date().getHours();
    const greeting = h < 12 ? 'Good morning' 
                   : h < 17 ? 'Good afternoon' 
                   : h < 21 ? 'Good evening' 
                   : 'Good night';
    
    const nameEl = document.getElementById('udbUserName');
    const name = nameEl ? nameEl.textContent.trim() : 'there';
    
    const el = document.getElementById('udbGreeting');
    if (el) el.innerHTML = greeting + ', ' + name + ' ✦';
})();
// userDashboard js ends

