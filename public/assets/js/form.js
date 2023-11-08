var image = document.getElementById("image");

var previewPicture  = function (e) {
    const [picture] = e.files

    if (picture) {
        
        image.src = URL.createObjectURL(picture)
    }
} 
