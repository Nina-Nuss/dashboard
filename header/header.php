<div id="header" style="background-color: white;display: flex;height: 15vh; padding-left: 0vh">
    <div style="display: flex;">
        <img src="../images/bild.png" alt="bild"
            style="margin-right: 60px;  margin-left: 5vh; margin-bottom: 2px; border-radius: 2vh;">
        <img src="../images/logo.png" alt="logo" style="padding-bottom: 25px;">
    </div>
    <link rel="stylesheet" href="../css/index_new.css">
    
</div>

<style>
    .clock {
        text-align: center;
        padding: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .clock h1 {
        margin: 0;
        font-size: 2rem;
        color: #ffffff;
    }

    .clock p {
        margin: 10px 0 0;
        font-size: 4.5rem;
        color: #ffffff;
    }

    .div {
        text-align: center;
    }
</style>

<div class="parallelogram col-md-12">
    <div class="para_inhalt col-md-10 d-flex text justify-content-between px-5">
        <div class="clock"> Infoterminal Dashboard</div>
        <div class="clock">
            <div id="time"></div>
            <div>/</div>
            <div id="date"></div>
        </div>

    </div>
</div>
<script>
    function updateTime() {
        const now = new Date();
        const timeElement = document.getElementById('time');
        const dateElement = document.getElementById('date');

        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        const day = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are zero-based
        const year = now.getFullYear();

        timeElement.textContent = `${hours}:${minutes}:${seconds}`;
        dateElement.textContent = `${day}.${month}.${year}`;
    }

    setInterval(updateTime, 1000);
    updateTime(); // Initial call to set immediately
</script>