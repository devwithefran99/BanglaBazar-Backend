
// form part starts
function handleSend() {
    const name = document.getElementById('fname').value.trim();
    const email = document.getElementById('femail').value.trim();
    if (!name || !email) {
      alert('Please fill in your name and email.');
      return;
    }
    const msg = document.getElementById('successMsg');
    msg.classList.add('show');
    document.getElementById('fname').value = '';
    document.getElementById('femail').value = '';
    document.getElementById('fmessage').value = '';
    document.getElementById('fsubject').value = '';
    setTimeout(() => msg.classList.remove('show'), 3500);
  }
 
  function toggleMapEdit() {
    const row = document.getElementById('mapInputRow');
    row.classList.toggle('open');
  }
 
  function applyMap() {
    const input = document.getElementById('mapEmbedInput').value.trim();
    if (!input) { alert('Please paste the embed URL.'); return; }
    const src = input.includes('<iframe') ? input.match(/src="([^"]+)"/)?.[1] : input;
    if (!src) { alert('Invalid URL. Copy only the src value from the iframe.'); return; }
    document.getElementById('mapFrame').src = src;
    document.getElementById('mapInputRow').classList.remove('open');
    document.getElementById('mapEmbedInput').value = '';
  }