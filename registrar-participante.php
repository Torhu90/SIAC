<?php
session_start();
require_once "includes/pdo.php";
require_once "includes/util.php";
validarAdmin();

$query = "SELECT IdDpto, NombreDpto FROM departamento";
$resultadodepto=$pdo->query($query);

$query = "SELECT IdBarrio, NombreBarrio FROM barrio";
$resultadobarrio=$pdo->query($query);

$sql = "SELECT IdPadrinazgo, NombrePadrinazgo FROM padrinazgo";
$resultadopadrinazgo = $pdo-> query($sql);

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Registar Participante</title>
  <?php require_once "includes/header.php" ?>
  <link rel="stylesheet" href="styles/admin.css">
  <link rel="stylesheet" href="styles/form.css">
</head>
<script>
	$(document).ready(function(){
		$("#lugar").change(function () {
			$("#lugar option:selected").each(function () {
				IdDpto = $(this).val();
				$.post("includes/getMunicipio.php", { IdDpto: IdDpto }, function(data){
					$("#muni").html(data);
				});            
			});
		})
	});
</script>


<body>
<?php require_once "includes/nav-admin.php" ?>
<h2 style="text-align: center; color:darkblue; padding:0.5cm; margin-top:70px; margin-bottom:-130px">Registro de Nuevo Participante</h2>
<form id="regForm" action="">
  <ul class="nav flex-column flex-md-row ">
    <li class="nav-item">
      <a class="nav-link custom" href="#">Datos Educador</a>
    </li>
    <li class="nav-item">
      <a class="nav-link custom" href="#">Datos Generales</a>
    </li>
    <li class="nav-item">
      <a class="nav-link custom" href="#">Educación</a>
    </li>
    <li class="nav-item">
      <a class="nav-link custom" href="#">Vivienda</a>
    </li>
    <li class="nav-item">
      <a class="nav-link custom" href="#">Relaciones Familiares</a>
    </li>
    <li class="nav-item">
      <a class="nav-link custom" href="#">Estructura Familiar</a>
    </li>
    <li class="nav-item">
      <a class="nav-link custom" href="#">Trabajo Infantil</a>
    </li>
    
  </ul>

  <!-- One "tab" for each step in the form: -->
  <div class="tab">
    <h3 style="text-align: center; margin-top:40px;margin-bottom:40px;">Datos del Educador</h3>
    <input type="number" class="form-control" id="codigoEdu" name="codigoEdu" placeholder="Ingrese el Código del Educador" maxlength="11" required/>
  </div>

  <div class="tab">
    <h3 style="text-align: center; margin-top:40px; margin-bottom:40px">Datos generales del/la Participante</h3>
    <form>
      <div class="form-row">
        <div class="form-group col-md-4">
          <!--No esta obligatorio por si no tienen foto del participante--> 
          <label for="foto">Foto del participante</label>
          <input type="file" class="form-control" id="foto">
        </div>

        <div class="form-group col-md-4">
          <label for="tipo">Tipo de Padrinazgo</label>
          <select class="form-control" id="TipoPadrinazgo" name="TipoPadrinazgo">
						<option hidden="">Seleccione el tipo de padrinazgo</option>
						<?php
						while ($row = $resultadopadrinazgo->fetch()) {
						?>
						<option value="<?php echo $row [0]?>"><?php echo $row[1]?></option>
						<?php
						}?>
					</select>
        </div>

        <!--Creo que es autoincrement entonces no sería necesario-->
        <div class="form-group col-md-4">
          <label for="CodigoNino">Código del/la participante </label>
          <input type="number" id="CodigoNino" class="form-control" placeholder="Codigo del/la participante" maxlength="11" required/>
        </div>

        <div class="form-group col-md-4">
          <label for="IdNino">Identidad</label>
          <input type="text" name="IdNino" id="IdNino" class="form-control" placeholder="Identidad" onkeypress="return identidad(event)" minlength="13" maxlength="13" required/>
        </div>

        <div class="form-group col-md-4">
          <label for="IdNino" >Nombres</label>
          <input type="text" class="form-control" id="NombreNino" placeholder="Nombres del/la participante" onkeypress="return caracterletra(event)" minlength="3" maxlength="40" required/>
        </div>

        <div class="form-group col-md-4">
          <label for="ApellidosNino">Apellidos</label>
          <input type="text" class="form-control" id="ApellidosNino" placeholder="Apellidos del/la participante" onkeypress="return caracterletra(event)" minlength="3" maxlength="50" required/>
        </div>
				
        <div class="form-group col-md-4">
					<label for="genero">Género</label>
          <select id="genero" class="form-control" required>
						<option hidden="">Seleccione el género</option>
            <option>Femenino</option>
            <option>Masculino</option>
          </select>
        </div>

        <div class="form-group col-md-4">
					<label for="fechaNac">Fecha de Nacimiento</label>
          <input type="date" class="form-control" id="fechaNac" placeholder="Fecha de nacimiento" required/>
        </div>

				<!--No accede a los municipios-->
        <div class="form-group col-md-4">
					<label for="" >Lugar de nacimiento</label>
					<div >
						<input type="hidden" name="LugarNacimiento" id="LugarNacimiento" class="form-control">
						<select class="form-control" id="lugar" name="lugar">
							<option hidden="">Seleccione el Lugar de Nacimiento</option>
							<?php while($row = $resultadodepto->fetch()) { ?>
							<option value="<?php echo $row['IdDpto']; ?>"><?php echo $row['NombreDpto']; ?></option>
							<?php } ?>
						</select>
					</div> 
				</div>
				<div class="form-group col-md-4">
					<label for="Municipio" >Municipio</label>
					<div >
						<input type="hidden" class="form-control" id="Municipio" name="Municipio">
						<select class="form-control" id="muni" name="muni">
							<option hidden>Seleccione el Municipio </option>
						</select>
					</div>
        </div>

        <div class="form-group col-md-4">
					<label for="">Direccion de domicilio</label>
          <input type="text" class="form-control" id="DireccionDom" name="DireccionDom" placeholder="Direccion domicilio" minlength="4" maxlength="100" required/>
        </div>

        <div class="form-group col-md-4">
					<label for="Barrio" >Barrio</label>
          <input type="hidden" class="form-control" id="Barrio" placeholder="Barrio" name="Barrio">
          <select class="form-control" id="bar" name="bar"> 
            <option hidden>Seleccione el Barrio </option>
            <?php while($row = $resultadobarrio->fetch()) { ?>
          	<option value="<?php echo $row['IdBarrio']; ?>"><?php echo $row['NombreBarrio']; ?></option>
            <?php } ?>
          </select>
        </div>
				<!--Es dinámico con respecto al barrio pero no esta hecha la conexion-->
        <div class="form-group col-md-4">
					<label for="" >Sector de domicilio:</label>
					<input type="hidden" class="form-control" id="Sector" placeholder="Sector" name="Sector">
					<select class="form-control" id="sec" name="sec"> 
						<option hidden>Seleccione el Sector </option>
					</select>
        </div>
				<!--Es dinámico respecto a los dos anteriores pero no esta hecha la conexion-->
        <div class="form-group col-md-4">
				<label for="">Centro Comunitario de referencia:</label>
        <input type="hidden" name="CentroReferencia" id="CentroReferencia" class="form-control">
          <select class="form-control" id="centroc" name="centroc">
            <option hidden="">Seleccione el Centro de Referencia</option>
          </select>
        </div>

        <div class="form-group col-md-4">
				<label for="">Facebook</label>
					<input type="text" class="form-control" id="Facebook" placeholder="Facebook" name="Facebook" minlength="4" maxlength="50">
        </div>

        <div class="form-group col-md-4">
					<label for="">Correo</label>
					<input type="email" class="form-control" id="correonino" placeholder="Correo electrónico" name="correonino" maxlength="45">
        </div>

        <div class="form-group col-md-4">
					<label for="">Telefono Fijo</label>
					<input type="text" class="form-control" id="telefononino" placeholder="Telefono" name="telefononino"  onkeypress="return telefono(event)" minlength="8" maxlength="8">
        </div>

        <div class="form-group col-md-4">
					<label for="">Celular</label>
				  <input type="text" class="form-control" id="Celularnino" placeholder="Celular" name="Celularnino" onkeypress="return telefono(event)" minlength="8" maxlength="8">
        </div>

        <div class="form-group col-md-4">
					<label for="">Fecha ingreso</label>
         	<input type="date" class="form-control" id="fechaIng" placeholder="fecha de Ingreso" name="fechaIng" required/>
        </div>

        <div class="form-group col-md-4">
					<label for="">Responsable del/la participante</label>
          <input type="text" class="form-control" id="Responsable" placeholder="Responsable del Niño/a" name="ResponsableNino" onkeypress="return caracterletra(event)" minlength="4" maxlength="50" required>
        </div>

        <div class="form-group col-md-4">
					<label for="">Identidad de la madre</label>
          <input type="text" class="form-control" id="idMadre" placeholder="Identidad de la Madre" name="IdMadre"  onkeypress="return identidad(event)" minlength="13" maxlength="13" required>
        </div>

        <div class="form-group col-md-4">
					<label for="">Nombre de la madre</label>
         	<input type="text" class="form-control" id="nomMadre" placeholder="Nombre de la Madre" name="NombreMadre" onkeypress="return caracterletra(event)" minlength="4" maxlength="50" required>
        </div>

        <div class="form-group col-md-4">
					<label for="">Identidad del padre</label>
          <input type="text" class="form-control" id="idPadre" placeholder="Identidad del padre" name="IdPadre"  onkeypress="return identidad(event)" minlength="13" maxlength="13" required>
        </div>

        <div class="form-group col-md-4">
					<label for="">Nombre del padre</label>
          <input type="text" class="form-control" id="nomPadre" placeholder="Nombre del padre" name="NombrePadre" onkeypress="return caracterletra(event)" minlength="4" maxlength="50" required>
        </div>

        <div class="form-group col-md-4">
					<label for="">Con quien Vive:</label>
          <input type="hidden" name="vivecon" id="vivecon" class="form-control">
					<select class="form-control" id="vivecon" name="vivecon" required>
						<option hidden="">Seleccione con quien vive</option>
						<?php
						$sql = "SELECT IdViveCon, ViveCon FROM ViveCon WHERE 1 = 1";
						$resultado = $pdo -> query($sql);
						while ($row = $resultado-> fetch()) {
						?>
						<option value="<?php echo $row [0]?>"><?php echo $row[1]?></option>
						<?php
						}?>
					</select>
        </div>

        <div class="form-group col-md-4">
					<label for="">Reconocido por:</label>
          <input type="hidden" name="reconocido" id="reconocido" class="form-control">
          <select class="form-control" id="reconocido" name="reconocido" required>
            <option hidden="">Seleccione por quien fue reconocido</option>
            <?php
						$sql = "SELECT IdREconocidoPor, ReconocidoPor FROM ReconocidoPor WHERE 1 = 1";
						$resultado = $pdo -> query($sql);
						while ($row = $resultado-> fetch()) {
						?>
						<option value="<?php echo $row [0]?>"><?php echo $row[1]?></option>
						<?php
						}?>
          </select>
        </div>

        <div class="form-group col-md-4">
					<label for="">Riesgo de abandonar el hogar:</label>
					<select class="form-control" id="abandono" name="abandono" required>
						<option hidden="">Seleccione si o no</option>
						<option value="Si">Si</option>
						<option value="No">No</option>
					</select>
        </div>

        <div class="form-group col-md-4">
					<label for="">Motivos de riesgo de abandono de hogar:</label>
          <input type="hidden" name="abandono" id="abandono" class="form-control">
          <select class="form-control" id="abandonoHogar" name="abandonoHogar">
            <option hidden="">seleccione el motivo del riesgo de abandono del hogar</option>
						<?php
						$sql = "SELECT IdMotivosRiesgoAbandonoH, MotivosRiesgoAbandonoH FROM MotivosRiesgoAbandonoH";
						$resultado = $pdo -> query($sql);
						while ($row = $resultado-> fetch()) {
						?>
						<option value="<?php echo $row [0]?>"><?php echo $row[1]?></option>
						<?php
						}?> 
          </select>
        </div>
      </div>
    </form>
  </div>

  <div class="tab">
    <p><input placeholder="dd" oninput="this.className = ''"></p>
    <p><input placeholder="mm" oninput="this.className = ''"></p>
    <p><input placeholder="yyyy" oninput="this.className = ''"></p>
  </div>

  <div class="tab">
    <p><input placeholder="Username..." oninput="this.className = ''"></p>
    <p><input placeholder="Password..." oninput="this.className = ''"></p>
  </div>

  <div class="tab">
    <p><input placeholder="Username..." oninput="this.className = ''"></p>
    <p><input placeholder="Password..." oninput="this.className = ''"></p>
  </div>

  <div class="tab">
    <p><input placeholder="Username..." oninput="this.className = ''"></p>
    <p><input placeholder="Password..." oninput="this.className = ''"></p>
  </div>

  <div class="tab">
    <p><input placeholder="Username..." oninput="this.className = ''"></p>
    <p><input placeholder="Password..." oninput="this.className = ''"></p>
  </div>

  <div class="btn-group" role="group" aria-label="Basic example" style="margin-left:80%git">
			<button class="btn btn-warning btn btn-secondary" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button class="btn btn-success btn btn-secondary" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
  </div>

  <!-- Circles which indicates the steps of the form: -->
  <div style="text-align:center;margin-top:40px;">
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
  </div>
</form>


<script src="js/form.js"></script>


</body>
</html>