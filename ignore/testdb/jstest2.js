async function deletee(idDelete) {
    prepare = "?idDelete=" + idDelete;
    result = await fetch("delete.php" + prepare)
    result2 = await fetch("test.php")
    console.log("meow")

}
