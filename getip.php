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

        $ip = trim($_POST['ip']);

        try {
            $client  = new SoapClient("http://www.webservicex.net/geoipservice.asmx?WSDL");
            $params = array('IPAddress' => $ip);
            $response = $client->GetGeoIP($params);
            $result = $response->GetGeoIPResult;
        }
        catch (SoapFault $exception) {
            echo $exception->getMessage();
        }
    }
    ?>

<form action="getip.php" method="post">
    <?
    if(!empty($_POST) && $result->ReturnCodeDetails == "Success") {
        ?>
        <table cellpadding="5" cellspacing="5" border="1">
            <tr>
                <td>
                    IP:
                </td>
                <td>
                    <?
                    echo $result->IP;
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    CountryName:
                </td>
                <td>
                    <?
                    echo $result->CountryName;
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    CountryCode:
                </td>
                <td>
                    <?
                    echo $result->CountryCode;
                    ?>
                </td>
            </tr>
        </table>
    <?}?>
    <p>IP : <input type="text" value="<? if(!empty($result->IP)){ echo $result->IP; } else { echo "89.231.110.158"; }?>" name="ip"></p>
    <p><input type="submit" value="Check"></p>
</form>

</body>
</html>