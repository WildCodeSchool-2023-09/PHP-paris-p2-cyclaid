const iconeProfile = document.getElementById('connect');

const logoutList = document.getElementById('to-deconnect');
logoutList.style.display = 'none';

iconeProfile.addEventListener('click', () => {
    if (logoutList.style.display === 'none') {
        logoutList.style.display = 'flex';
    } else {
        logoutList.style.display = 'none';
    }
});
