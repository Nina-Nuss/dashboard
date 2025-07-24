<?php include 'assets/links.html'; ?>
<?php include 'header/header.php'; ?>

<?php include 'modal/hinzufuegen.html'; ?>
<?php include 'modal/loeschen.html'; ?>


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
                <div class="col-md-12 mx-auto pl-auto bg-gray-100 ">
                    <div class="d-flex justify-content-center" id="startBtns" style="margin-right: 10vh;">
                        <button id="infotherminalBereich" type="button" class="btn  text-dark start-btn  pt-0"
                            style="background-color: rgba(255, 255, 255, 0.952); border-color: #006c99; border-radius: 8px;">Infoterminal</button>
                        <button id="templateBereich" type="button" class="btn  text-dark  start-btn" style="border-color: #006c99; border-radius: 8px;"
                            style="background-color: rgba(255, 255, 255, 0.952);">Templates</button>
                        <button id="adminBereich" type="button" class="btn   text-dark start-btn" style="border-color: #006c99; border-radius: 8px;"
                            style="background-color: rgba(255, 255, 255, 0.952);">Administation</button>
                        <button type="button" class="btn   text-dark start-btn" style="border-color: #006c99; border-radius: 8px;"
                            style="background-color: rgba(255, 255, 255, 0.952);">Video</button>
                    </div>
                </div>
               
 <div id="settingsPanel">
                </div>
                <hr />

            </div>

        </div>
    </div>
</div>
</div>
</div>
</div>  
</body>
<?php include 'assets/scripts.html'; ?>

</html>