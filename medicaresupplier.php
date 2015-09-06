<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <?php
    //
    ini_set('display_errors', true);
    ini_set("soap.wsdl_cache_enabled", "0");
    error_reporting(E_ALL);

    $data = '';
    if(!empty($_POST)) {

        $zip = $_POST['zip'];

        try {
            $client  = new SoapClient("http://www.webservicex.net/medicareSupplier.asmx?WSDL");
            $params = array('zip' => $zip);
            $response = $client->GetSupplierByZipCode($params);
            $records = $response->SupplierDataLists->TotalRecords;
            if($records > 0)
                $data = $response->SupplierDataLists->SupplierDatas->SupplierData;


        }
        catch (SoapFault $exception) {
            echo $exception->getMessage();
        }
    }
    ?>

<form action="medicaresupplier.php" method="post">

    <?
    if(!empty($_POST) && $records > 0) {
    ?>
        <table cellpadding="1" cellspacing="1" border="1">
            <tr>
                <td>Supplier Number</td>
                <td>Company Name</td>
                <td>Address</td>
                <td>City</td>
                <td>Zip</td>
                <td>ZipPlus4</td>
                <td>Telephone</td>
                <td>Description</td>
                <td>IsSupplierParticipating</td>
            </tr>
            <?
                for($i = 0; $i < count($data); $i++) {
            ?>
                <tr>
                    <td><? echo $data[$i]->SupplierNumber; ?></td>
                    <td><? echo $data[$i]->CompanyName; ?></td>
                    <td><? echo $data[$i]->Address1; ?></td>
                    <td><? echo $data[$i]->City; ?></td>
                    <td><? echo $data[$i]->Zip; ?></td>
                    <td><? echo $data[$i]->ZipPlus4; ?></td>
                    <td><? echo $data[$i]->Telephone; ?></td>
                    <td><? echo $data[$i]->Description; ?></td>
                    <td><? echo $data[$i]->IsSupplierParticipating; ?></td>
                </tr>
            <?}?>
        </table>
    <?}?>
    <p>Zip : <input type="text" value="94121" name="zip"></p>
    <p><input type="submit" value="Check"></p>
</form>

</body>
</html>