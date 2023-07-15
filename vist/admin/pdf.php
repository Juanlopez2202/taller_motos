<?php
    require('pdf/fpdf.php');


    class PDF extends FPDF
    {
    // Cabecera de página
    function Header()
    {;
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        $this->Cell(70);
        // Título
        $this->Cell(50,15,'Codigos de barras',0,0,'C');
        // Salto de línea
        $this->Ln(20);

        $this-> cell(95,15,'Nombre',1,0,'c',0);
        $this-> cell(95,15, 'Codigo de barras',1,1,'c',0);
    }}

    require_once("../../bd/conexion.php");
    $conet = new database();
    $db = $conet -> conectar();

    $consul = $db -> prepare("SELECT nombre, barcode FROM barcode");
    $consul -> execute();
    $row = $consul -> fetch(PDO::FETCH_ASSOC);

    

    $arraycodigos = array();

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','',18);

    while($row = $consul -> fetch(PDO::FETCH_ASSOC)):

        $arraycodigos[] = (string)$row['barcode'];  

        

        $pdf-> cell(95,15, $row['nombre'],1,0,'c',0);
        $pdf-> cell(95,15, $row['barcode'],1,1,'c',0);

    endwhile;

    $pdf->Output();
?>
<script type="text/javascript">
    function arrayjsonbarcode(j){
        json = JSON.parse(j);
        arr = [];
        for(var x in json){
            arr.push(json[x]);
        }
        return arr;
    }

    jsonvalor = '<?php echo json_encode($arraycodigos)?>';
    valores =arrayjsonbarcode(jsonvalor);

        for (var i = $pdf['barcode']; i < valores.length; i++){
            JsBarcode("#barcode" + valores[i], valores[i].toString(),{
                format:"CODE128",
                lineColor: "#000",
                widht: 2,
                height: 30,
                displayValue: true,
            });
        }
</script>