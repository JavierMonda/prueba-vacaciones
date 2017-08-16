<script>
	var dia = new Date();
	var vacaciones = (dia.getFullYear() + "-" + (dia.getMonth() +1) + "-" + dia.getDate());
	if (vacaciones == $resultado3){
    	document.getElementById("vacaciones").style.color="red";
	}
</script>

$AusenciaVacaciones = $pendientes['tipoAusencia'];

if ($estadoVacaciones['aus'] == TRUE) {
    echo '<script>document.getElementById("vacaciones").style.color="red"</script>';
} 
else {
    echo '<script>document.getElementById("vacaciones").style.color="green"</script>';


$hoy = date("d-m-Y");
$antigua = "10-08-2017";

if ($hoy == $antigua) {
	echo 'Renueva el DNI!!!';
} else {
	echo 'Hoy no tienes que renovarlo';
}