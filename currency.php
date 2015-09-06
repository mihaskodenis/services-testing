<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <?php

        ini_set('display_errors', true);
        ini_set("soap.wsdl_cache_enabled", "0");
        error_reporting(E_ALL);

    $currency = array("AFA","ALL","DZD","ARS","AWG","AUD","BSD","BHD","BDT","BBD","BZD","BMD","BTN","BOB","BWP","BRL","GBP","BND","BIF","XOF","XAF","KHR","CAD",
                "CVE","KYD","CLP","CNY","COP","KMF","CRC","HRK","CUP","CYP","CZK","DKK","DJF","DOP", "XCD","EGP","SVC","EEK","ETB","EUR","FKP","GMD","GHC","GIP","XAU",
				"GTQ","GNF","GYD","HTG","HNL","HKD","HUF","ISK","INR","IDR","IQD","ILS","JMD","JPY","JOD","KZT","KES","KRW","KWD","LAK","LVL","LBP","LSL","LRD",
				"LYD","LTL","MOP","MKD","MGF","MWK","MYR","MVR","MTL","MRO","MUR","MXN","MDL","MNT","MAD","MZM","MMK","NAD","NPR","ANG","NZD","NIO","NGN","KPW",
				"NOK","OMR","XPF","PKR","XPD","PAB","PGK","PYG","PEN","PHP","XPT","PLN","QAR","ROL","RUB","WST","STD","SAR","SCR","SLL","XAG","SGD","SKK","SIT",
				"SBD","SOS","ZAR","LKR","SHP","SDD","SRG","SZL","SEK","CHF","SYP","TWD","TZS","THB","TOP","TTD","TND","TRL","USD","AED","UGX","UAH","UYU","VUV",
				"VEB","VND","YER","YUM","ZMK","ZWD","TRY");

        if(!empty($_POST)) {

            $from = trim($_POST['from']);
            $to = trim($_POST['to']);
            $sum = trim($_POST['sum']);
            $result = '';
            $rate = '';

            try {
                $client  = new SoapClient("http://www.webservicex.net/CurrencyConvertor.asmx?WSDL");
                $params = array('FromCurrency' => $from, 'ToCurrency' => $to);
                $response = $client->ConversionRate($params);
                $rate = $response->ConversionRateResult;
                $result = $rate * $sum;
            }
            catch (SoapFault $exception) {
                echo $exception->getMessage();
            }
        }


    ?>

    <form action="currency.php" method="post">

        <table>
            <tr>
                <td>
                    Convert
                </td>
                <td>
                    <input type="text" value="<? if(!empty($sum)){ echo $sum; } else { echo "1"; }?>" name="sum" style="width: 100px;">
                </td>
                <td>
                    <select name="from" style="width: 60px;">
                        <option disabled>Choose currency</option>
                            <?
                                for($i = 0; $i < count($currency); $i++) {
                                    $selected = '';
                                    if(!empty($from)) {
                                        if($currency[$i] == $from)
                                            $selected = 'selected';
                                    } else {
                                        if($currency[$i] == "USD")
                                            $selected = 'selected';
                                    }
                                    echo "<option value='$currency[$i]' $selected>$currency[$i]</option>";
                                }
                            ?>
                    </select>
                </td>
                <td>
                    to
                    <select name="to" style="width: 60px;">
                        <option disabled>Choose currency</option>
                            <?
                            for($i = 0; $i < count($currency); $i++) {
                                $selected = '';
                                if(!empty($to)) {
                                    if($currency[$i] == $to)
                                        $selected = 'selected';
                                } else {
                                    if($currency[$i] == "PLN")
                                        $selected = 'selected';
                                }
                                echo "<option value='$currency[$i]' $selected>$currency[$i]</option>";
                            }
                            ?>
                    </select>
                </td>
                <td>
                    <p><input type="submit" value="Convert"></p>
                </td>
            </tr>
            <?
                if(!empty($rate)) {
            ?>
            <tr>
                <td>
                    Rate :
                </td>
                <td>
                    <? echo $rate; ?>
                </td>
                <td>
                    Result :
                </td>
                <td colspan="2">
                    <? echo $sum; ?> <? echo $from; ?> = <? echo $result; ?> <? echo $to; ?>
                </td>
            </tr>
            <?}?>
        </table>
    </form>

</body>
</html>

