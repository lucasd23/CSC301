<?php
if (!isset($_SERVER['CONTENT_LENGTH'])){}
else {
    require_once('JSONtility.php');
    writeJSON('data.json', $_POST);
}

?>
<html>
<h1>Create Tenant</h1>
<form action="create.php" method="POST">
    First: <input name="first" type="text"> Last: <input name="last" type="text"><br>
    Link to Photo: <input name="picture" type="text"><br>
    Apartment Number: <input name="aptNum" type="text"><br>
    Rent: $<input name="rent" type="number" step="0.01"><br>
    Number of Late Payments: <input name="latePayments" type="number"><br>
    <button type="submit">Submit</button>
</form>

</html>