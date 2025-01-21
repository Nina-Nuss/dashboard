<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bildergalerie mit Upload</title>
    <style>
        .gallery {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .gallery-item {
            text-align: center;
        }
        img {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Bildergalerie mit Upload</h1>
    <input type="file" id="imageInput1" multiple accept="image/*">
    <div id="gallery1" class="gallery"></div>
    <input type="file" id="imageInput2" multiple accept="image/*">
    <div id="gallery2" class="gallery"></div>
    <input type="file" id="imageInput3" multiple accept="image/*">
    <div id="gallery3" class="gallery"></div>


    <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const files = event.target.files;
            const gallery = document.getElementById('gallery');

            gallery.innerHTML = ''; // Reset the gallery

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const galleryItem = document.createElement('div');
                    galleryItem.className = 'gallery-item';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = `Bild ${i + 1}`;

                    const description = document.createElement('p');
                    description.textContent = `Beschreibung für Bild ${i + 1}`;

                    galleryItem.appendChild(img);
                    galleryItem.appendChild(description);
                    gallery.appendChild(galleryItem);
                };

                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
