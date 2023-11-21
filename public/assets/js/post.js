const getButton = document.getElementById('cta_view_part');

const sendRequest = document.getElementById('popup');

const post = document.getElementById('post');

getButton.addEventListener('click', () => {
    sendRequest.classList.replace('hidden', 'shown');
    post.style.filter = 'blur(4px)';
});
