 <!-- <?php include 'assets/links.html'; ?> 

 <body>
     <?php include 'header/header.php'; ?>
     <div id="content">
         <div class="container-fluid">
             <div class="row ">
                 <div class="bearbeiten col-md-2 text-center ">
                     <p style="font-size: 3vh; font-weight: bold; margin-bottom: 1vh;">Bearbeiten</p>
                     <!-- Card Objecte -->
                     <div id="dokumente">

                         <select id="selectUmgebung" class="form-select" aria-label="Default select example"></select>
                         <button id="minusBtn" type="button" class="btn btn-light">Select

                         </button>
                         <div id="counter">0</div>
                         <h2 id="titelUmgebung"></h2>
                         <div class="container d-flex " id="umgebungsContainer" style="justify-content: center; align-items: center;">
                             <div id="rowForCards" class="col-4 p-2">
                             </div>
                         </div>
                     </div>
                     <!-- Card Objecte -->
                 </div>
                 <div class="col-md-10 text-center pt-2">
                     <div class="col-md-12 mx-auto pl-auto bg-gray-100 ">
                         <div class="d-flex justify-content-center" style="margin-right: 10vh;">
                             <button type="button" class="btn  text-dark start-btn  pt-0"
                                 style="background-color: rgba(255, 255, 255, 0.952); border-color: #006c99;">Infoterminal</button>
                             <button type="button" class="btn  text-dark  start-btn" style="border-color: #006c99;"
                                 style="background-color: rgba(255, 255, 255, 0.952);">Templates</button>
                             <button id="adminBereich" type="button" class="btn   text-dark start-btn" style="border-color: #006c99;"
                                 style="background-color: rgba(255, 255, 255, 0.952);">Administation</button>
                             <button type="button" class="btn   text-dark start-btn" style="border-color: #006c99;"
                                 style="background-color: rgba(255, 255, 255, 0.952);">Video</button>
                         </div>
                     </div>
                     <div class="col-md-12  mx-auto pl-auto bg-gray-100 pt-2">
                         <div class="d-flex justify-content-center" style="margin-left: 10vh;">
                             <button id="plusBtn" type="button" class="btn btn-primary">add
                             </button>
                             <button id="saveBtn" type="button" class="shadow-sm save btn btn-success">
                                 <span>save</span>
                             </button>
                             <button id="deleteBtnForCards" type="button" class="shadow-sm btn btn-danger">
                                 <span>delete</span>
                             </button>
                             <button type="button" class="shadow-sm btn btn-dark">
                                 <span>close</span>
                             </button>

                         </div>
                     </div>
                     <div id="settingsPanel">
                         <div class="col-md-11 pt-3 d-flex align-items-center justify-content-center position-relative">
                             <div class=" col-md-4 container-fluid position-relative ">
                                 Webseite name: <span style="font-weight: bold;">Snapbar_Warm</span><br>
                                 <input type="checkbox" name="checkA">
                                 <label style="margin-right: 2vh;" for="checkA">Aktiv</label>
                                 <select id="timerSelectRange">
                                     <option value="3">1</option>
                                     <option value="4">2</option>
                                     <option value="5">3</option>
                                     <option value="6">4</option>
                                     <option value="7">5</option>
                                     <option value="8">6</option>
                                     <option value="9">7</option>
                                 </select>
                                 <button type="button"
                                     class="btn shadow-sm btn-light w-50">neues Display</button>
                             </div>

                             <div style="display:block" class="col-md-4">

                                 <!-- Modal Error Log -->
                                 <!-- Modal Datum Von -->
                                 <!-- Modal hinzufügen -->
                                 <!-- Modal löschen -->
                                 <?php include 'modal/loeschen.html'; ?>
                                 <?php include 'modal/hinzufuegen.html'; ?>
                             </div>
                             <div id="IP_Adresse_main" class="border border-grey rounded ">
                                 <div class=" d-block d-flex" id="IP_Adress">
                                     <div class="mr-2 mt-3" id="btnPosition">
                                         <button type="button" data-toggle="modal" data-target="#modal_hinzufuegen"
                                             id="btnDis" class="btn btn-light ml-0">
                                             <span>
                                                 add
                                             </span></button>
                                         </br>
                                         <button type="button" id="btnDis" data-toggle="modal" class="btn btn-light ml-0" data-target="#modal_loeschen">
                                             <span>
                                                 del
                                             </span>
                                         </button>
                                     </div>
                                     <div class="container" style="max-height: 75px;overflow: auto;" id="anzeigebereichV">
                                         <!-- <div class="displayIp" id="anzeigebereichV"> -->
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <hr />
                 </div>
             </div>
         </div>
     </div>
     </div>
 </body>
 <?php include 'assets/scripts.html'; ?>

 </html>