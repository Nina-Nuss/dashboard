<?php include 'assets/links.html'; ?>
<?php include 'header/header.php'; ?>

<?php include 'modal/hinzufuegen.html'; ?>
<?php include 'modal/loeschen.html'; ?>


<div id="content">
    <div class="container-fluid">
        <div class="row ">
            <div id="rowForCards" class="bearbeiten col-md-2 text-center ">
                <p style="font-size: 3vh; font-weight: bold; margin-bottom: 1vh;">Bearbeiten</p>
                <!-- Card Objecte -->
                <div id="dokumente">
                    <button id="minusBtn" type="button" class="btn btn-light">Select
                    </button>
                    <div id="counter">0</div>
                    <h2 id="titelUmgebung"></h2>
                    <div class="container d-flex " id="umgebungsContainer" style="justify-content: center; align-items: center;">
                        <div id="rowForCards" class="col-4 p-2">
                            <div></div>
                        </div>
                    </div>
                </div>
                <!-- Card Objecte -->
            </div>
            <div class="col-md-10 text-center pt-2">
                <?php include 'bereiche/selectBereich.php'; ?>
                <?php include 'bereiche/crud.php'; ?>
                <div id="settingsPanel">

                </div>
                <hr />

            </div>

        </div>
    </div>
</div>
</div>
</div>
</body>
<?php include 'assets/scripts.html'; ?>

</html>