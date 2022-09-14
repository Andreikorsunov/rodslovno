<?php
$xml=simplexml_load_file("jalgpall.xml");
function Tiimid($xml){
    $array=SaadaTiimid($xml);
    return $array;
}
function SaadaTiimid($voistkond){
    $result=array($voistkond);
    $tiimid=$voistkond->duubelvoistkond->voistkond;

    if(empty($tiimid))
        return $result;

    foreach($tiimid as $tiim){
        $array=SaadaTiimid($tiim);
        $result=array_merge($result, $array);
    }
    return $result;
}
function SaadaPohiTiimid($voistkonnad, $voistkond){
    if($voistkond==null) return null;
    foreach($voistkonnad as $pohi){
        if(!JubaTiimid($pohi)) continue;
        foreach($pohi->duubelvoistkond->voistkond as $tiim){
            if($tiim->nimetus == $voistkond->nimetus){
                return $pohi;
            }
        }
    }
    return null;
}
function JubaTiimid($voistkond){
    return !empty($voistkond -> duubelvoistkond -> voistkond);
}
$voistkonnad=Tiimid($xml);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jalgpall</title>
</head>
<body>
<h1>Jalgpalli sugupuu</h1>
<hr>
<h2>Meistriliiga</h2>
<table border="1">
    <tr>
        <th>Põhivõistkond</th>
        <th>Duubelvõistkond</th>
        <th>Aasta loomine</th>
    </tr>
    <?php
    foreach($voistkonnad as $voistkond){
        $pohi=SaadaPohiTiimid($voistkonnad, $voistkond);
        $pohiPohid=SaadaPohiTiimid($voistkonnad, $pohi);
        echo '<tr>';
        if(empty($pohi )){
            echo '<td bgcolor="yellow">puudub</td>"';
        } else
            echo '<td>' .$pohi->nimetus. '</td>';
            echo '<td>' .$pohi->nimetus. '</td>';
            echo '<td>' .$voistkond->looaasta. '</td>';

            echo '</tr>';
    }
    ?>
</table>
</body>
</html>