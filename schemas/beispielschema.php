<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<style>
    .card {
        width: 18rem;

    }


    .card-deck {
        padding: 10px;
    }

    .card-img-top {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .form-check {
        margin-left: 3ch;
    }
</style>

<body>
    <?php include '../assets/links.html'; ?>
    <?php include '../assets/scripts.html'; ?>

    <div class="card-deck">
        <div class="card">
            <img class="card-img-top" src="./uploads/baum2.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                    </label>
                </div>
            </div>
            <div class="card-footer">
                <small class="text-muted">Last updated 3 mins ago</small>
            </div>
        </div>
    </div>
    <div class="card-deck">
        <div class="card">
            <img class="card-img-top" src="./uploads/baum2.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                    <label class="form-check-label" for="flexCheckDefault2">
                    </label>
                </div>
            </div>
            <div class="card-footer">
                <small class="text-muted">Last updated 3 mins ago</small>
            </div>
        </div>


</body>
<script>

    const checkboxes = document.querySelectorAll('.form-check-input');
    const labels = document.querySelectorAll('.form-check-label');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                console.log(`Checkbox with ID ${this.id} is checked`);
                console.log(this.checked);
                checkboxes.forEach(cb => {
                    if (cb !== this) {
                        cb.checked = false;

                    }
                });
                labels.forEach(label => {
                   
                    
                    if (label.html == this.id) {
                        label.innerHTML = "checked"; // Set the label text to "checked" when checked
                    } else {
                        label.innerHTML = ""; // Clear the label text for unchecked checkboxes
                    }
                });
                
            } else {
                console.log(`Checkbox with ID ${this.id} is unchecked`);
            }
        });
    });
</script>

</html>