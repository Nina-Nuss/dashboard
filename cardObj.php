<?php include 'assets/links.html';?>
<body>
    <select id="selectUmgebung" class="form-select" aria-label="Default select example"></select>
    <div class="d-flex">
        <button id="plusBtn" type="button" class="btn btn-primary">Create</button>
        <div id="counter">0</div>
        <button id="minusBtn" type="button" class="btn btn-light">Select</button>
        <button id="deleteBtnForCards" type="button" class="btn btn-danger d-none">delete</button>
        <button id="saveBtn" type="button" class="btn btn-success d-block">save</button>
    </div>
    <h2 id="titelUmgebung"></h2>
    <div class="container d-flex" id="umgebungsContainer">
        <div id="rowForCards" class="col-4 p-2"><!-- bild Obj -->

        </div>
    </div>
    <?php include 'assets/scripts.html';?>
</body>