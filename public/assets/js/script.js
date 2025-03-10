// Fungsi untuk toggle sidebar dan main content
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    const hamburgerMenu = document.querySelector('.hamburger-menu');

    // Toggle active class pada sidebar dan main content
    sidebar.classList.toggle('active');
    mainContent.classList.toggle('active');
    hamburgerMenu.classList.toggle('active');
}

document.addEventListener("DOMContentLoaded", function() {
    const alertBox = document.getElementById("alertBox");

    document.getElementById("closeAlert")?.addEventListener("click", function() {
        alertBox.remove();
    });

    if (alertBox) {
        setTimeout(function() {
            alertBox.remove();
        }, 2000); 
    }
});
