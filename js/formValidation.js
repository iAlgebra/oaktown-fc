$(document).ready(function(){

	$('#submit').click(function(event){
		var requiredFields = $('.required');

		$('#form-validation p').css('visibility', 'hidden');
		$(".form-group").removeClass('has-error');
		$(".form-group").addClass('has-success');

		for(var i=0; i < requiredFields.length; i++){

			var requiredField = requiredFields[i];
			var errorElementId = requiredField.name + "-error";

			if(requiredField.value == "") {
				var errorText = "You must complete your " + requiredField.name;
				$('#' + errorElementId).text(errorText);
				$('#' + errorElementId).css('visibility', 'visible');
				$(requiredField).parent('.form-group').removeClass('has-success');
				$(requiredField).parent('.form-group').addClass('has-error');
				event.preventDefault();
			} else {

				if(requiredField.name == "email" && requiredField.value.indexOf('@') == -1){
					$('#' + errorElementId).text('Your email is invalid');
					$('#' + errorElementId).css('visibility', 'visible');
					$(requiredField).parent('.form-group').removeClass('has-success');
					$(requiredField).parent('.form-group').addClass('has-error');
					event.preventDefault();
				}

				if(requiredField.name == "email" && requiredField.value.length <= 2){
					$('#' + errorElementId).text('Your email must be at least 3 characters long');
					$('#' + errorElementId).css('visibility', 'visible');
					$(requiredField).parent('.form-group').removeClass('has-success');
					$(requiredField).parent('.form-group').addClass('has-error');
					event.preventDefault();
				}

				if(requiredField.name == "phone" && requiredField.value.length <= 2){
					$('#' + errorElementId).text('Your phone number must be at least 3 characters long');
					$('#' + errorElementId).css('visibility', 'visible');
					$(requiredField).parent('.form-group').removeClass('has-success');
					$(requiredField).parent('.form-group').addClass('has-error');
					event.preventDefault();
				}
			}
		}
	});
});
