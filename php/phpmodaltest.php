<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Bootstrap Modal Test</title>
    <!-- Bootstrap CSS -->
  <?php include 'assets/links.html'; ?>
</head>
<body>
  <?php include 'modal/hinzufuegen.html'; ?>
<!-- Button trigger modal -->

                        <button type="button" data-toggle="modal" data-target="#modal_hinzufuegen"
                            class="btnDis btn btn-light ml-0">
                            <span>
                                add
                            </span>
                        </button>

                  

<!-- Bootstrap JS, Popper.js und jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>