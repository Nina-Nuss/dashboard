<link rel="stylesheet" href="../css/index_new.css">
<style>
    .clock {
        text-align: center;
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

<div class="parallelogram">
    <div class="para_inhalt text d-flex justify-content-between align-items-center px-5 gap-2">
        <div class="clock"> Infoterminal CJD Offenburg</div>
        <div class="clock">
            <div id="time"></div>
            <div>/</div>
            <div id="date"></div>
        </div>

    </div>
</div>
<script>
    function updateTime() {
        const dateTime = new Date();
        const timeElement = document.getElementById('time');
        const dateElement = document.getElementById('date');

        const hours = String(dateTime.getHours()).padStart(2, '0');
        const minutes = String(dateTime.getMinutes()).padStart(2, '0');
        const seconds = String(dateTime.getSeconds()).padStart(2, '0');

        const day = String(dateTime.getDate()).padStart(2, '0');
        const month = String(dateTime.getMonth() + 1).padStart(2, '0');
        const year = dateTime.getFullYear();

        timeElement.textContent = `${hours}:${minutes}:${seconds}`;
        dateElement.textContent = `${day}.${month}.${year}`;
    }

    setInterval(updateTime, 1000);
    updateTime();
</script>