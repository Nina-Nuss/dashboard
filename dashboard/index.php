<?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/links.html'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/layout/header.php'; ?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/modal/hinzufuegen.html'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/modal/loeschen.html'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/database/deleteFileFolder.php'; ?>

<div id="content">
    <div class="container-fluid">
        <div class="row">
            <div id="rowForCards" class="col-md-2 text-center">
                <!-- Card Objecte -->
                <div id="dokumente">
                    <h2 id="titelUmgebung"></h2>
                    <div id="umgebungsContainer">
                        <div id="cardContainer" class="cardContainer"></div>
                    </div>
                </div>
                <!-- Card Objecte -->
            </div>
            <div class="col-md-10 text-center pt-2">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/layout/selectPanel.php'; ?>
            </div>

        </div>
    </div>
</div>
</div>
</div>
</div>
</body>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/scripts.html'; ?>

</html>