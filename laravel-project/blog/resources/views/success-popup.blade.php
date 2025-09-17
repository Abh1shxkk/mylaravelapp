<div id="success-popup" class="success-popup" style="display: none; position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background-color: #4CAF50; color: white; padding: 10px 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 1000;">
    Success
</div>

<script>
    // Popup ko show karne ke liye
    document.addEventListener('DOMContentLoaded', function() {
        var popup = document.getElementById('success-popup');
        if (sessionStorage.getItem('showPopup')) {
            popup.style.display = 'block';
            setTimeout(function() {
                popup.style.display = 'none';
                sessionStorage.removeItem('showPopup'); // Ek baar hide hone ke baad clear
            }, 3000); // 3 seconds
        }
    });
</script>