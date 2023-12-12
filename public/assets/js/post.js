const buttonLeft = document.getElementById('to-left');

buttonLeft.addEventListener('click', () => {
    const firstPicture = document.getElementById('picture-displayed');
    const secondPicture = document.getElementById('subpicture_1');
    const thirdPicture = document.getElementById('subpicture_2');
    const fourthPicture = document.getElementById('subpicture_3');

    const firstImage = firstPicture.src;
    const secondImage = secondPicture.src;
    const thirdImage = thirdPicture.src;
    const fourthImage = fourthPicture.src;

    firstPicture.src = fourthImage;
    secondPicture.src = firstImage;
    thirdPicture.src = secondImage;
    fourthPicture.src = thirdImage;
});

const buttonRight = document.getElementById('to-right');

buttonRight.addEventListener('click', () => {
    const firstPicture = document.getElementById('picture-displayed');
    const secondPicture = document.getElementById('subpicture_1');
    const thirdPicture = document.getElementById('subpicture_2');
    const fourthPicture = document.getElementById('subpicture_3');

    const firstImage = firstPicture.src;
    const secondImage = secondPicture.src;
    const thirdImage = thirdPicture.src;
    const fourthImage = fourthPicture.src;

    firstPicture.src = secondImage;
    secondPicture.src = thirdImage;
    thirdPicture.src = fourthImage;
    fourthPicture.src = firstImage;
});

const getButton = document.getElementById('cta_view_part');

const sendRequest = document.getElementById('popup');

const post = document.getElementById('post');

getButton.addEventListener('click', () => {
    sendRequest.classList.replace('hidden', 'shown');
    post.style.filter = 'blur(4px)';
});
