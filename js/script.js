document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    this.style.transform = "scale(0.98)";
    setTimeout(() => {
        window.location.href = "./HR/dashboard.php";
    }, 300);
});


function showSection(sectionId) {
    document.querySelectorAll('.section').forEach(section => {
        section.classList.remove('active');
    });
    document.getElementById(sectionId).classList.add('active');
}


function logout() {
    if(confirm('Are you sure you want to logout?')) {
        document.getElementById('dashboard').style.opacity = 0;
        setTimeout(() => {
            document.getElementById('dashboard').style.display = 'none';
            document.getElementById('loginScreen').style.display = 'flex';
        }, 300);
    }
}

showSection('announcements');

function showTab(tabId) {
    const parent = event.target.closest('.card');
    parent.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    parent.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
    event.target.classList.add('active');
}
