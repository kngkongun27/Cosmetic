// = = = = = = = = = = = = = = = = changeImg = = = = = = = = = = = = = = = =
function previewImages(input) {
    const preview = document.getElementById('images');
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const li = document.createElement('li');
                li.style.width = '32%';
                li.style.display = 'inline-block';
                li.style.margin = '5px';
                li.innerHTML = `<img src="${e.target.result}" style="width:100%; height:200px; object-fit:cover;">`;
                preview.appendChild(li);
            }
            reader.readAsDataURL(file);
        });
    }
}

document.getElementById('imageUpload').addEventListener('change', function() {
    previewImages(this);
});
