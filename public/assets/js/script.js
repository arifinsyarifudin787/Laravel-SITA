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

function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus saja!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(id).submit();
        }
    });
}

function confirmArchive(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang diarsipkan tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, arsipkan saja!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(id).submit();
        }
    });}
function confirmAccept(status, id) {
    document.getElementById(`status-input-${id}`).value = status;
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "bimbingan yang disetujui tidak bisa diubah!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, setujui saja!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(id).submit();
        }
    });}
function confirmDecline(status, id) {
    document.getElementById(`status-input-${id}`).value = status;
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "bimbingan yang ditolak tidak bisa diubah!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, tolak saja!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(id).submit();
        }
    });}

    function confirmAcceptTA(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "tugas akhir yang disetujui tidak bisa diubah!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, setujui saja!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(id).submit();
            }
        });}

    document.addEventListener("DOMContentLoaded", function() {
        const alertBox = document.getElementById("alertBox");
    
        if (alertBox) {
            alertBox.style.opacity = "0";
            alertBox.style.transform = "translateY(-20px) scale(0.9)";
            alertBox.style.transition = "opacity 0.5s ease, transform 0.5s ease, box-shadow 0.5s ease";
    
            setTimeout(() => {
                alertBox.style.opacity = "1";
                alertBox.style.transform = "translateY(0) scale(1)";
                alertBox.style.boxShadow = "0 5px 10px rgba(0, 0, 0, 0.2)";
            }, 10);
    
            document.getElementById("closeAlert")?.addEventListener("click", function() {
                fadeOutAlert(alertBox);
            });
    
            setTimeout(function() {
                fadeOutAlert(alertBox);
            }, 2000);
        }
    
        function fadeOutAlert(element) {
            if (!element) return;
            element.style.transition = "opacity 0.5s ease, transform 0.5s ease, box-shadow 0.5s ease";
            element.style.opacity = "0";
            element.style.transform = "translateY(-20px) scale(0.9)";
    
            setTimeout(() => element.remove(), 500);
        }
    });



