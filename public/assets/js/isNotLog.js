const iconeProfile = document.getElementById('connect');

const loginList = document.getElementById('to-connect');
loginList.style.display = 'none';

iconeProfile.addEventListener('click', () => {
    if (loginList.style.display === 'none') {
        loginList.style.display = 'flex';
    } else {
        loginList.style.display = 'none';
    }
});
