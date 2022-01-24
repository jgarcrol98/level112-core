let meses = [];


$(document).on('click', '.seleccion_pago', function(e)
{
	$this = $(this);
	var mesyear = $this.attr('data-mes')+''+$this.attr('data-year');

	if( $('#mes'+mesyear+'.card-suscripcion').hasClass('bg-danger') ){
		$('#mes'+mesyear+'.card-suscripcion').removeClass('bg-danger');
		let pos = meses.indexOf(mesyear)
		meses.splice(pos, 1)
	}else{
		$('#mes'+mesyear+'.card-suscripcion').addClass('bg-danger');
		meses.push(mesyear);
	}

	$('#realizarPagoSuscripcionMeses').val(meses);

	if( $('.card-suscripcion').hasClass('bg-danger') ){
		$('#realizarPago').removeClass('hide');

		var count = meses.length;

		var countall = $('.card-suscripcion').length;

		if(count > 1){
			var dias = Number($('.card-suscripcion.bg-danger').length) * 30;
		}else{
			var dias = Number($('.card-suscripcion.bg-danger').length) * 31;
		}


		if(count < 3 ){
			if($('#days'+dias).length){ 
				$('.precio_mes_').html( Math.round10(($('#days'+dias).attr('date-precio') / count), -2) +'€');
				$('#realizarPagoSuscripcion').val($('#days'+dias).attr('date-value'));
			}else{
				if($('#days'+dias).length){ 
					$('.precio_mes_').html( Math.round10(($('#days31').attr('date-precio')), -2) +'€');
					$('#realizarPagoSuscripcion').val($('#days31').attr('date-value'));
				}else{
					$('.precio_mes_').html( Math.round10(($('#days30').attr('date-precio')), -2) +'€');
					$('#realizarPagoSuscripcion').val($('#days30').attr('date-value'));
				}
			}
		}
		if(count > 2 && $('#days90').attr('date-precio')){
			$('.precio_mes_').html( Math.round10(($('#days90').attr('date-precio') / 3), -2) +'€');
			$('#realizarPagoSuscripcion').val($('#days90').attr('date-value'));
		}
		if(count > 3 && $('#days120').attr('date-precio')){
			$('.precio_mes_').html( Math.round10(($('#days120').attr('date-precio') / 4), -2) +'€');
			$('#realizarPagoSuscripcion').val($('#days120').attr('date-value'));
		}
		if(count > 5 && $('#days180').attr('date-precio')){
			$('.precio_mes_').html( Math.round10(($('#days180').attr('date-precio') / 6), -2) +'€');
			$('#realizarPagoSuscripcion').val($('#days180').attr('date-value'));
		}

		if(countall == count){
			$('.precio_mes_').html( Math.round10(($('#days365').attr('date-precio') / count), -2) +'€');
			$('#realizarPagoSuscripcion').val($('#days365').attr('date-value'));
		}

	}else{
		$('#realizarPago').addClass('hide');
	}

});
