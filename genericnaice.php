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


    if(!empty($_POST)) {

        $NAICSCode = trim($_POST['NAICSCode']);

        try {
            $client = new SoapClient("http://www.webservicex.net/GenericNAICS.asmx?WSDL");
            $params = array('NAICSCode' => $NAICSCode);
            $response = $client->GetNAICSByID($params);
            $records = $response->NAICSData->Records;
            if($records > 0)
                $response = $response->NAICSData->NAICSData->NAICS;

        } catch (SoapFault $exception) {
            echo $exception->getMessage();
        }
    }
    ?>

<form action="genericnaice.php" method="post">
    <?
    if(!empty($_POST) && $records > 0) {
        ?>
        <table cellpadding="5" cellspacing="5" border="1">
            <tr>
                <td>
                    NAICS Code:
                </td>
                <td>
                    <?
                    echo $response->NAICSCode;
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    Title:
                </td>
                <td>
                    <?
                    echo $response->Title;
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    Country:
                </td>
                <td>
                    <?
                    echo $response->Country;
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    IndustryDescription:
                </td>
                <td>
                    <?
                    echo $response->IndustryDescription;
                    ?>
                </td>
            </tr>
        </table>
    <?}?>
<!--    http://www.naics.com/six-digit-naics/?code=51-->
    <p>NAICS Code : <input type="text" value="511110" name="NAICSCode"></p>
    <p><input type="submit" value="Check"></p>
</form>

</body>
</html>