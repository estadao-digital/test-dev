<?php
	session_start();

	$ano = 2015;
	
	if(isset($_SESSION['carros'])){

		$id = count($_SESSION['carros']) + 1;

	}else{

		$id = "1";

	}
?>
<div class='title'>
    Incluir novo Carro
</div>
<div class='content'>
    <div class='carros'>
    <form>
        <label>ID</label>
        <input type="hidden" class="form-control id-carro" id="id_carro" name="id_carro" value="<?php echo $id ?>">
        <input type="text" class="form-control id-carro" id="id_carroshow" name="id_carroshow" value="<?php echo $id ?>" disabled><br>
        <label>Marca</label>
        <select class="form-control marca-carro" id="marca-carro" name="marca-carro">
            <option value="" selected></option>
            <option value="AGRALE">AGRALE</option>
            <option value="ASTON MARTIN">ASTON MARTIN</option>
            <option value="AUDI">AUDI</option>
            <option value="BENTLEY">BENTLEY</option>
            <option value="BMW">BMW</option>
            <option value="CHANGAN">CHANGAN</option>
            <option value="CHERY">CHERY</option>
            <option value="CHEVROLET">CHEVROLET</option>
            <option value="CHRYSLER">CHRYSLER</option>
            <option value="CITROËN">CITROËN</option>
            <option value="DODGE">DODGE</option>
            <option value="DS">DS</option>
            <option value="EFFA MOTORS">EFFA MOTORS</option>
            <option value="FERRARI">FERRARI</option>
            <option value="FIAT">FIAT</option>
            <option value="FORD">FORD</option>
            <option value="GEELY">GEELY</option>
            <option value="HONDA">HONDA</option>
            <option value="HYUNDAI">HYUNDAI</option>
            <option value="IVECO">IVECO</option>
            <option value="JAC">JAC</option>
            <option value="JAGUAR">JAGUAR</option>
            <option value="JEEP">JEEP</option>
            <option value="JINBEI">JINBEI</option>
            <option value="KIA">KIA</option>
            <option value="LAMBORGHINI">LAMBORGHINI</option>
            <option value="LAND ROVER">LAND ROVER</option>
            <option value="LEXUS">LEXUS</option>
            <option value="LIFAN">LIFAN</option>
            <option value="MASERATI">MASERATI</option>
            <option value="MERCEDES-BENZ">MERCEDES-BENZ</option>
            <option value="MINI">MINI</option>
            <option value="MITSUBISHI">MITSUBISHI</option>
            <option value="NISSAN">NISSAN</option>
            <option value="PEUGEOT">PEUGEOT</option>
            <option value="PORSCHE">PORSCHE</option>
            <option value="RAM">RAM</option>
            <option value="RELY">RELY</option>
            <option value="RENAULT">RENAULT</option>
            <option value="ROLLS ROYCE">ROLLS ROYCE</option>
            <option value="SHINERAY">SHINERAY</option>
            <option value="SMART">SMART</option>
            <option value="SSANGYONG">SSANGYONG</option>
            <option value="SUBARU">SUBARU</option>
            <option value="SUZUKI">SUZUKI</option>
            <option value="TAC">TAC</option>
            <option value="TOYOTA">TOYOTA</option>
            <option value="TROLLER">TROLLER</option>
            <option value="VOLKSWAGEN">VOLKSWAGEN</option>
            <option value="VOLVO">VOLVO</option>
        </select><br>
        <label>Modelo</label>
        <input type="text" class="form-control modelo-carro" id="modelo-carro" name="modelo-carro"><br>
        <label>Ano</label>
        <select class="form-control ano-carro" id="ano-carro" name="ano-carro">
        	<option></option>
        	<?php
        		while ($ano >= 1990){
        			echo "<option value='".$ano."'>".$ano."</option>";
        			$ano--;
        		}
        	?>
        </select><br><br>
        <input type="button" class="btn btn-primary" value="Salvar" onclick="salvaCarro();">
        <input type="button" class="btn btn-primary" value="Cancelar" onclick="cancela();">
    </form>
    </div>
</div>
<script>
	$("#ano_carro").focus();
</script>
