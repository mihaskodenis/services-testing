<?php
    $BarColor = array("White", "Red", "Black", "Blue");
    $BGColor = array("White", "Red", "Black", "Blue");
    $BarcodeType = array("Code_2_5_interleaved", "Code39", "Code93", "CodeUPC_A");
    $ShowTextPosition = array("TopLeft", "TopRight", "TopCenter", "BottomLeft", "BottomRight", "BottomCenter");
    $BarCodeImageFormat = array("BMP", "EMF", "EXIF", "GIF", "ICON", "JPEG", "MemoryBMP", "PNG", "TIFF", "WMF");
//
    if(!empty($_POST)) {
        header("Content-type: image/gif");
        ini_set('display_errors', true);
        ini_set("soap.wsdl_cache_enabled", "0");
        error_reporting(E_ALL);

    $height = trim($_POST['height']);
    $width = trim($_POST['width']);
    $angle = trim($_POST['angle']);
    $ratio = trim($_POST['ratio']);
    $barColor = trim($_POST['barColor']);
    $bgColor = trim($_POST['bgColor']);
    $fontSize = trim($_POST['fontSize']);
    $barcodeType = trim($_POST['barcodeType']);
    $showTextPosition = trim($_POST['showTextPosition']);
    $barCodeImageFormat = trim($_POST['barCodeImageFormat']);
    $barCodeText = trim($_POST['barCodeText']);


    try {
        $client  = new SoapClient("http://www.webservicex.net/genericbarcode.asmx?WSDL");
        $params = array('BarCodeParam' => array(
            'Height' => $height,
            'Width' => $width,
            'Angle' => $angle,
            'Ratio' => $ratio,
            'Module' => 1,
            'Left' => 1,
            'Top' => 1,
            'CheckSum' => false,
            'FontName' => "Arial" ,
            'BarColor' => $barColor ,
            'BGColor' => $bgColor ,
            'FontSize' => $fontSize,
            'barcodeOption' => "Code" ,
            'barcodeType' => $barcodeType ,
            'checkSumMethod' => "None" ,
            'showTextPosition' => $showTextPosition,
            'BarCodeImageFormat' => $barCodeImageFormat),
            'BarCodeText' => $barCodeText);
        $response = $client->GenerateBarCode($params);
        $result = $response->GenerateBarCodeResult;

        print_r($result);

    }
    catch (SoapFault $exception) {
        echo $exception->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?
    if(empty($_POST)) {
?>
<form action="genericbarcode.php" method="post">

    <p>
        BarCode Parametrs:
    </p>
    <table>
        <tr>
            <td>Height</td>
            <td><input type="text" value="100" name="height"></td>
        </tr>
        <tr>
            <td>Width</td>
            <td><input type="text" value="100" name="width"></td>
        </tr>
        <tr>
            <td>Angle</td>
            <td><input type="text" value="0" name="angle"></td>
        </tr>
        <tr>
            <td>Ratio</td>
            <td><input type="text" value="10" name="ratio"></td>
        </tr>
        <tr>
            <td>BarColor</td>
            <td>
                <select name="barColor" style="width: 60px;">
                    <?
                    for($i = 0; $i < count($BarColor); $i++) {
                        $selected = '';
                        if($BarColor[$i] == "Black")
                            $selected = 'selected';
                        echo "<option value='$BarColor[$i]' $selected>$BarColor[$i]</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>BGColor</td>
            <td>
                <select name="bgColor" style="width: 60px;">
                    <?
                    for($i = 0; $i < count($BGColor); $i++) {
                        $selected = '';
                        if($BGColor[$i] == "White")
                            $selected = 'selected';
                        echo "<option value='$BGColor[$i]' $selected>$BGColor[$i]</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>FontSize</td>
            <td><input type="text" value="10" name="fontSize"></td>
        </tr>
        <tr>
            <td>barcodeType</td>
            <td>
                <select name="barcodeType" style="width: 60px;">
                    <?
                    for($i = 0; $i < count($BarcodeType); $i++) {
                        $selected = '';
                        if($BarcodeType[$i] == "Code39")
                            $selected = 'selected';
                        echo "<option value='$BarcodeType[$i]' $selected>$BarcodeType[$i]</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>showTextPosition</td>
            <td>
                <select name="showTextPosition" style="width: 60px;">
                    <?
                    for($i = 0; $i < count($ShowTextPosition); $i++) {
                        $selected = '';
                        if($ShowTextPosition[$i] == "TopLeft")
                            $selected = 'selected';
                        echo "<option value='$ShowTextPosition[$i]' $selected>$ShowTextPosition[$i]</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>BarCodeImageFormat</td>
            <td>
                <select name="barCodeImageFormat" style="width: 60px;">
                    <?
                    for($i = 0; $i < count($BarCodeImageFormat); $i++) {
                        $selected = '';
                        if($BarCodeImageFormat[$i] == "PNG")
                            $selected = 'selected';
                        echo "<option value='$BarCodeImageFormat[$i]' $selected>$BarCodeImageFormat[$i]</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>BarCodeText</td>
            <td><input type="text" value="85983458" name="barCodeText"></td>
        </tr>
        <tr>
            <td>
                <p><input type="submit" value="Generate"></p>
            </td>
        </tr>
    </table>
</form>

</body>
</html>
<?}?>