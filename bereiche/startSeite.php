


<div class="container d-flex ">
    <div class="col-md-10 pt-3 d-flex align-items-center justify-content-center position-relative">
        <div class="col-md-4 container-fluid position-relative">
            Webseite name: <span style="font-weight: bold;">Snapbar_Warm</span><br>
            <div>
                <input type="checkbox" id="" name="checkA">
                 <label style="margin-right: 2vh;" for="checkA">Aktiv</label>
            </div>
            <select id="timerSelectRange">
                <option value="3">1</option>
                <option value="4">2</option>
                <option value="5">3</option>
                <option value="6">4</option>
                <option value="7">5</option>
                <option value="8">6</option>
                <option value="9">7</option>
            </select>
            <button type="button" class="btn shadow-sm btn-light w-50">neues Display</button>
        </div>
        <div style="display:block" class="col-md-4">
            <!-- Modal Error Log -->
            <!-- Modal Datum Von -->
            <!-- Modal hinzufügen -->
            <!-- Modal löschen -->
        </div>
        <div id="IP_Adresse_main" class="border border-grey rounded ">
            <div class="d-flex" id="IP_Adress">
                <div id="btnPosition">
                    <button type="button" data-toggle="modal" data-target="#modal_hinzufuegen" class="btnDis btn btn-light ml-0">
                        <span>add</span>
                    </button>
                    <button type="button" data-toggle="modal" class="btnDis btn btn-light ml-0" data-target="#modal_loeschen">
                        <span>del</span>
                    </button>
                </div>
                <div class="container" style="max-height: 75px;overflow: auto;" id="anzeigebereichV">
                    <!-- <div class="displayIp" id="anzeigebereichV"> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--  -->


</div>

<script>

</script>