$(document).ready(function(){


	  $('.datepicker').daterangepicker({
	    singleDatePicker: true,
	    showDropdowns: true,
	    minYear: 1901,
	    maxYear: parseInt(moment().format('YYYY'),10)
	  }, function(start, end, label) {
	    var years = moment().diff(start, 'years');
	    $("input[name='c_age']").val(years);
	  });
	  $('.datepicker').val('');
	$('.new-button').click(function(){

		$(".loaderwrp ").show();
	  	$.ajax({
	            type: "POST",
	            url: './functions/controller.php',
	            data: $('.register-form').serialize(),
	            dataType: 'json',
	              beforeSend: function ( xhr ) {
	              
	          	  },
			      success: function(response) {

			        $(".loader").hide();
			        if(response.status ==3){

			        	$("input[name='name']").addClass("error");
			        	$("input[name='email']").addClass("error");
			        	$("select[name='category']").parent().addClass("error");
			        }if(response.state ==4){

			        	$(".error-msg").html(response.message);
			        }
			        else if (response.status == 0) {

				      	if (response.error.missing_fields.name !='') {$("input[name='name']").addClass("error");}
				      	else{$("input[name='name']").removeClass("error");}

				      	if (response.error.missing_fields.dob !='') {$("input[name='dob']").addClass("error");}
				      	else{$("input[name='dob']").removeClass("error");}

				  		if (response.error.missing_fields.email !='') {$("input[name='email']").addClass("error"); }
				  		else{$("input[name='email']").removeClass("error");}

				  		if (response.error.missing_fields.category !='') {$("select[name='category']").parent().addClass("error"); }
				  		else{$("select[name='category']").parent().removeClass("error");}
				  		
			        	$(".loaderwrp ").fadeOut();
			        }else{
			        	$("input[name='name']").removeClass("error");$("input[name='email']").removeClass("error");$("select[name='category']").parent().removeClass("error");
			        	$('.register-form').hide();
			        	$('.error-msg').hide();
			        	$(".success-msg").html(response.message);


			        }
			
			      },
	      		error: function() {
	         
	      		},
	          	fail : function( response ) {
	            console.log(response);
	            //$( '#result' ).html(response.message);
	          	}

		});

	});



})