<style>
	.opacity-5{
		opacity: 0.1
	}
	.suscripciones_cards .card-body .card{ border: 1px solid #ccc }
	.bg-danger .text-muted{
		color:#fff !important;
	}
</style>
<div class="container-fluid">

	<?php if($this->ion_auth->in_group(3)){ ?>
		<div class="text-center alert alert-info mt-2"><a href="<?=base_url()?>admin">IR EL PANEL DE CONTROL</a></div>
	<?php } ?>

	<?php if(!$this->curso){?>
		<?php if($this->ion_auth->in_group(3)){ ?>
				<div class="alert alert-danger">No tienes cursos asociados. Pide a administración que asocien a tu ficha de profesor, el curso correspondiente.</div>
		<?php }else{ ?>
			<div class="col-sm-6 offset-3 mt-5">
				<div class="alert alert-danger">Debes matricularte en un curso primero para ver contenidos</div>
			</div>
		<?php } ?>
	<?php } else{ ?>
  	<div class="inner-body">
                
    	<div class="page-header">
      		<div>
                <h2 class="main-content-title tx-24 mg-b-5">Suscripciones</h2>
                <ol class="breadcrumb">
                  	<li class="breadcrumb-item"><a href="academia">Inicio</a></li>
                  	<li class="breadcrumb-item" aria-current="page">Suscripciones</li>
                </ol>
      		</div>
    	</div>

    	<?php $mes_inicio = date('n', $this->curso->datestart)?>
    	<?php $mes_final = date('n', $this->curso->dateend)?>

    	<?php $year_inicio = date('Y', $this->curso->datestart)?>
    	<?php $year_final = date('Y', $this->curso->dateend)?>
    	
    	<?php 
    		$mes_empieza = strtotime('01-'.date('m-Y', $this->curso->datestart));
    		$mes_termina = strtotime('31-'.date('m-Y', $this->curso->dateend));
    		
    	?>

    	<?php 
			foreach ($suscripciones as $suscripciones) {
				if($suscripciones->dias == 31 || $suscripciones->dias == 30){
					$precio_1_meses = $suscripciones->precio;
					echo '<div id="days'.$suscripciones->dias.'" date-value="'.$suscripciones->id.'" date-precio="'.$suscripciones->precio.'"></div>';
				}elseif($suscripciones->dias == 60){
					$precio_2_meses = $suscripciones->precio;
					echo '<div id="days'.$suscripciones->dias.'" date-value="'.$suscripciones->id.'" date-precio="'.$suscripciones->precio.'"></div>';
				}elseif($suscripciones->dias == 90){
					$precio_3_meses = $suscripciones->precio;
					echo '<div id="days'.$suscripciones->dias.'" date-value="'.$suscripciones->id.'" date-precio="'.$suscripciones->precio.'"></div>';
				}elseif($suscripciones->dias == 120){
					$precio_4_meses = $suscripciones->precio;
					echo '<div id="days'.$suscripciones->dias.'" date-value="'.$suscripciones->id.'" date-precio="'.$suscripciones->precio.'"></div>';
				}elseif($suscripciones->dias == 180){
					$precio_6_meses = $suscripciones->precio;
					echo '<div id="days'.$suscripciones->dias.'" date-value="'.$suscripciones->id.'" date-precio="'.$suscripciones->precio.'"></div>';
				}elseif($suscripciones->dias == 365){
					$precio_12_meses = $suscripciones->precio;
					echo '<div id="days'.$suscripciones->dias.'" date-value="'.$suscripciones->id.'" date-precio="'.$suscripciones->precio.'"></div>';
				}
			}

			if(!isset($precio_2_meses)){
				echo '<div id="days60" date-value="'.$suscripciones->id.'" date-precio="'.($precio_1_meses*2).'"></div>';
			}

		?>


		<?php 

			foreach ($this->user_suscripciones as $key => $value) {
					
				$fechainicial = new DateTime(date('d-m-Y', $value['add']));
				$fechafinal = new DateTime(date('d-m-Y', $value['end']));

				$diferencia = $fechainicial->diff($fechafinal);
				$meses = (( $diferencia->y * 12 ) + $diferencia->m );

				if($diferencia->d > 20){
					$meses = $meses +1;
				}

				$pagado[strtotime('01-'.date('m-Y', $value['add']))] = 1;

				for ($r = 1; $r < $meses; $r++) {
					$mmmm = strtotime('01-'.date('m-Y',$value['add'])."+ ".$r." month");
					$pagado[$mmmm] = 1;
				}
			}
		?>


    	<?php if($suscripciones){?>
    	<?php $x = 0; for ($i = $year_inicio; $i <= $year_final; $i++) { ?>
		    <div class="row row-sm pb-2 suscripciones_cards">
				<div class="col" >
					<div class="card bg-light">
                  		<div class="card-header text-center p-1">
                    		<h4 class="m-0">CURSO <?=$this->curso->nombre?> - <?=$i?></h4>
                  		</div>
                  		<div class="card-body">
				    		<div class="row row-sm pb-2">

				    			<?php for ($e = 1; $e <= 12; $e++) { ?>
					    			<div class="col-sm-2 mb-2">
					    				<a href="javascript:" class="seleccion_pago" data-mes="<?=$e?>" data-year="<?=$i?>">
							                <div id="mes<?=$e?><?=$i?>" class="card <?php if( $mes_empieza > strtotime('01-'.$e.'-'.$i) || $mes_termina < strtotime('31-'.$e.'-'.$i) ){ ?>opacity-5<?php }else{ echo 'card-suscripcion';$x++;} ?>">
												<div class="card-body text-center p-2">
													<h4 class="text-uppercase"><?=ago_mes_abbr($e)?></h4>
								                	<div id="">
								                		<div class="text-muted text-uppercase">
								                			&nbsp;
									                		<?php if(isset($pagado[strtotime('01-'.$e.'-'.$i)])){echo 'PAGADO';}?>
									                	</div>
									                </div>
								                	<div id="">
								                		<div class="text-muted text-uppercase precio_mes_"><?=$precio_1_meses?>€</div>
								                	</div>
								               	</div>
							                </div>
							            </a>
						            </div>
					            <?php } ?>

				    		</div>
				    	</div>
                  	</div>
                </div>
            </div>
		<?php } ?>
		<?php } ?>



	</div>
		<?php if($suscripciones){?>
			<p>Selecciona los meses en rojo que quieras pagar.</p>

			<div class="text-center">
				<form id="submitPago" action="pagos/personalizado" method="POST">
					<input type="hidden" name="suscripcionesmeses" id="realizarPagoSuscripcionMeses" value="">
					<input type="hidden" name="suscripciones" id="realizarPagoSuscripcion" value="">
					<button type="submit" id="realizarPago" class="hide btn btn-danger btn-lg">REALIZAR PAGO</button>
				</form>
			</a>

		<?php } ?>
	<?php } ?>

</div>