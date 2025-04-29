document.getElementById('loginForm').addEventListener('submit', function (event) {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    if (username === '' || password === '') {
        alert('Bitte füllen Sie alle Felder aus.');
        event.preventDefault();
    }
    fetch("login.php").then(async (response) => {
        this.responseText = await response.text();
        var obj = JSON.parse(this.responseText);

        obj.forEach(o => {
            anzeigebereichv.innerHTML += o + `<br>`
        });

    });

});
