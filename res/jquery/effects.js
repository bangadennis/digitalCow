//onchange the selection of cow id
//for updating, registered cow


function Checkthis(str)
{
	alert(str);
	var cow_id=str;
	$.ajax({
		type: 'POST',
		url: 'http://localhost/record/index.php/dashboard/get_update_details',
		data: 'cow_id='+cow_id,
		success: function(data)
		{
			$('#test').html(data);
		}
	});


}

//for deleting a registered cow details
function Deletethis(str)
{

	var confirm=window.confirm('Do you really want to delete this Record');

    if(confirm==true)
    {

	$.ajax({
		type: 'POST',
		url: 'http://localhost/record/index.php/dashboard/veiw_delete_details',
		data: 'cow_id='+str,
		success: function(data)
		{
			$('#delete_info').html(data);
		}
	});

	}


}


function Check_cow_id(cow_id)
{

	$('#delete_cow').click(function (){

	var confirm=window.confirm('Delete This Record!');

	if(confirm==true)
	{
		alert('hello');
	}
	else
	{
		return false;
	}

	});
}

//confirm delete cow
function confirm_delete_cow()
{
	$('#delete_cow').val();
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////MILK RECORD/////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////

//Show the dates 
function Show_date(str)
{	
	alert(str);
	$.ajax({
		type: 'POST',
		url: 'http://localhost/record/index.php/dashboard/show_date',
		data: 'cow_id='+str,
		success: function(data)
		{
			$('#date_update').html(data);
		}
	});

}

//to display the milk update form
function Show_milk_record(date,cow_id)
{
	//alert(cow_id);
	//alert(date);
	$.ajax({
		type: 'POST',
		url: 'http://localhost/record/index.php/dashboard/display_milk_update',
		data: 'cow_id='+cow_id+'&date='+date,
		success: function(data)
		{
			$('#update_record').html(data);
		}
	});
}


//show the milk analysis details.
function Show_total_milk(cow, from, to, price)
{
	
	//var pricei=prompt("Enter Price of Milk");
	//alert(price);
	if(to==''||from==''||cow=='')
	{
		alert('All Fields should be Selected');
	}
	else 
		if (from>to) 
			{
				alert("check From and to Dates");
			}
			else
				{
					$.ajax({
					type: 'POST',
					url: 'http://localhost/record/index.php/dashboard/analysis_milk_record',
					data: 'cow='+cow+'&from='+from+'&to='+to+'&price='+price,
					success: function(data)
					{
						$('#analysis_results').html(data);
					}
				});
				}
}


function Show_analysis_graph(cow_id)
{
	//alert(cow_id);

	$.ajax({
		type: 'POST',
		url: 'http://localhost/record/index.php/dashboard/display_milk_graph',
		data: 'cow_id='+cow_id,
		success: function(data)
		{
		
			$('#chart_graph').html(data);
			window.location.reload();
		}
	});

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////FEED///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

// display dates for the cows
function Show_feed_date(str)
{	
	//alert(str);

	$.ajax({
		type: 'POST',
		url: 'http://localhost/record/index.php/dashboard/show_feed_date',
		data: 'cow_id='+str,
		success: function(data)
		{
			$('#show_feed_date').html(data);
		}
	});

}
//display the update form

function Update_feed_record(date_feed, cow_id)
{
	//alert(cow_id);
	//alert(date_feed);
	
	$.ajax({
		type: 'POST',
		url: 'http://localhost/record/index.php/dashboard/display_feed_update',
		data: 'cow_id='+cow_id+'&date_feed='+date_feed,
		success: function(data)
		{
			$('#update_feed_record').html(data);
		}
	});
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////Insemination///////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

// display dates for the cows
function Show_insemination_date(str)
{	
	//alert(str);

	$.ajax({
		type: 'POST',
		url: 'http://localhost/record/index.php/dashboard/show_insemination_date',
		data: 'cow_id='+str,
		success: function(data)
		{
			$('#show_insemination_date').html(data);
		}
	});

}
//display the update form

function Update_insemination_record(date_insemination, cow_id)
{
	//alert(cow_id);
	//alert(date_insemination);
	
	$.ajax({
		type: 'POST',
		url: 'http://localhost/record/index.php/dashboard/display_insemination_update',
		data: 'cow_id='+cow_id+'&date_insemination='+date_insemination,
		success: function(data)
		{
			$('#update_insemination_record').html(data);
		}
	});
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////HEALTH RECORDS//////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////


// display health dates
function Show_health_date(str)
{	
	//alert(str);

	$.ajax({
		type: 'POST',
		url: 'http://localhost/record/index.php/dashboard/show_health_date',
		data: 'cow_id='+str,
		success: function(data)
		{
			$('#show_health_date').html(data);
		}
	});

}
//display the update form health

function Update_health_record(date_treatment, cow_id)
{
	//alert(cow_id);
	//alert(date_treatment);
	
	$.ajax({
		type: 'POST',
		url: 'http://localhost/record/index.php/dashboard/display_health_update',
		data: 'cow_id='+cow_id+'&date_treatment='+date_treatment,
		success: function(data)
		{
			$('#update_health_record').html(data);
		}
	});
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////CALVING RECORDS//////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////

//show valid calf id
function Show_calf_id_valid(cow_id)
{
	//alert(cow_id);
	 
	$.ajax({
		type: 'POST',
		url: 'http://localhost/record/index.php/dashboard/show_calf_id_valid',
		data: 'cow_id='+cow_id,
		success: function(data)
		{
			$('#valid_calf').html(data);
		}
	});


}

//display calf ids
function Show_calf_id(cow_id)
{
	//alert(cow_id);

	$.ajax({
		type: 'POST',
		url: 'http://localhost/record/index.php/dashboard/show_calf_id',
		data: 'cow_id='+cow_id,
		success: function(data)
		{
			$('#show_calf_id').html(data);
		}
	});


}

//display update calving record
function Update_calving_record(calf_id, cow_id)
{
	//alert(cow_id);
	//alert(calf_id);
	
	$.ajax({
		type: 'POST',
		url: 'http://localhost/record/index.php/dashboard/display_calving_update',
		data: 'cow_id='+cow_id+'&calf_id='+calf_id,
		success: function(data)
		{
			$('#update_calving_record').html(data);
		}
	});
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////REMINDER RECORDS//////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////

//display update reminder record
function Update_reminder_record(reminder)
{
	//alert(reminder);
	

	$.ajax({
		type: 'POST',
		url: 'http://localhost/record/index.php/dashboard/display_reminder_update',
		data: 'reminder_id='+reminder,
		success: function(data)
		{
			$('#update_reminder_record').html(data);
		}
	});
}





///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////Income and Expense RECORDS//////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////

//display update income and expense record
function Update_income_expense_record(income)
{
	//alert(income);
	

	$.ajax({
		type: 'POST',
		url: 'http://localhost/record/index.php/dashboard/display_income_expense_update',
		data: 'income_id='+income,
		success: function(data)
		{
			$('#update_income_expense_record').html(data);
		}
	});
}




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///FORM VALIDATION///////////////////////////////////////

//valiadate form register cow
function Check_register()
{
	//date of birth of the cow
		var birth_date=document.forms['register_cow']['dob'].value;
   		var split=birth_date.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {
		  	var y=document.getElementById("form_dob");
  			y.innerHTML="Error: Invalid Date of Birth";
		
		 	return false;
		  }

	//validate breed;
	var breed=document.forms['register_cow']['breed'].value;

	if(breed==''||breed==null)
	{
		alert('Breed Field-Value Required');
		return false;
	}


}

//validate update cow record form

//valiadate form register cow
function Check_Update_Cow()
{
	//date of birth of the cow
		var birth_date=document.forms['update_cow']['dob'].value;
   		var split=birth_date.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {
		  	
  			alert("Error: Invalid Date of Birth");
		
		 	return false;
		  }

	//validate breed;
	var breed=document.forms['update_cow']['breed'].value;

	if(breed==''||breed==null)
	{
		alert('Breed Field Value Required');
		return false;
	}


}







//validate milk form
function Check_milk_form()
{
	//date of milking of the cow not greater than today
		var birth_date=document.forms['milk_form']['milk_date'].value;
   		var split=birth_date.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {
		  	var y=document.getElementById("form_milk_date");
  			y.innerHTML="Error: Invalid Date of Milking";
		
		 	return false;
		  }

	//validate morning amount;
	var amount=document.forms['milk_form']['morning_amount'].value;

	if(amount<0||amount>25)
	{
		var amount_error=document.getElementById("form_error_morning");
  			amount_error.innerHTML="Error: Amount Should between 0 and 25 litres";
		return false;
	}
	else
	{
		var amount_error=document.getElementById("form_error_morning");
  			amount_error.innerHTML='';	
	}

//validate evening amount;
	var amount=document.forms['milk_form']['evening_amount'].value;

	if(amount<0||amount>25)
	{
		var amount_error=document.getElementById("form_error_evening");
  			amount_error.innerHTML="Error: Amount Should between 0 and 25 litres";
		return false;
	}
	else
	{
		var amount_error=document.getElementById("form_error_evening");
  			amount_error.innerHTML="";
	}

}


//validate milk form update
function Check_milk_update()
{
	//date of milking of the cow not greater than today
		var birth_date=document.forms['milk_update']['date_cow'].value;
   		var split=birth_date.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {
		  	
  			alert("Error: Invalid Date of Milking");
		
		 	return false;
		  }

	//validate morning amount;
	var amount=document.forms['milk_update']['morning_amount'].value;

	if(amount<0||amount>25)
	{
  			alert("Error:Morning Amount Should between 0 and 25 litres");
		return false;
	}

//validate evening amount;
	var amount=document.forms['milk_update']['evening_amount'].value;

	if(amount<0||amount>25)
	{
		alert("Error:Evening Amount Should between 0 and 25 litres");
		return false;
	}

}


//validate feed form
function Check_feed_form()
{
	//date of feeding of the cow not greater than today
		var feed_date=document.forms['feed_form']['date_feed'].value;
   		var split=feed_date.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {
		  	alert("Error: Invalid Feeding Date");
		
		 	return false;
		  }

}

//validate feed form
function Check_feed_update()
{
	//date of feeding of the cow not greater than today
		var feed_date=document.forms['feed_update']['feed_date'].value;
   		var split=feed_date.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {
		  	alert("Error: Invalid Feeding Date");
		
		 	return false;
		  }

}


//validate income/expense form
function Check_income_form()
{
	//date of income/expense of the cow not greater than today
		var income_date=document.forms['income_form']['income_date'].value;
   		var split=income_date.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {
		  	alert("Error: Invalid Income/Expense Date");
		
		 	return false;
		  }

}

//validate income/expense form
function Check_income_update()
{
	//date of income/expense of the cow not greater than today
		var income_date=document.forms['income_update']['income_date'].value;
   		var split=income_date.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {
		  	alert("Error: Invalid Income/Expense Date");
		
		 	return false;
		  }

}


//validate reminder form
function Check_reminder_form()
{
	//date of activity of the  greater than today
		var activity_date=document.forms['reminder_form']['activity_date'].value;
   		var split=activity_date.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x<today)
		  {
		  	alert("Error: Invalid Activity Date: Be Greater Than Today");
		
		 	return false;
		  }

}


//validate reminder form
function Check_reminder_update()
{
	//date of activity of the  greater than today
		var activity_date=document.forms['reminder_update']['activity_date'].value;
   		var split=activity_date.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x<today)
		  {
		  	alert("Error: Invalid Activity Date: Be Greater Than Today");
		
		 	return false;
		  }

}


//validate insemination form
function Check_ins_form()
{
	//date of insemination of the not greater than today
		var ins_date=document.forms['ins_form']['date_insemination'].value;
   		var split=ins_date.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {
		  	alert("Error: Invalid Insemination Date: Not Greater than Today's Date");
		
		 	return false;
		  }

}

//validate insemination form
function Check_ins_update()
{
	//date of insemination of the not greater than today
		var ins_date=document.forms['ins_update']['date_insemination'].value;
   		var split=ins_date.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {
		  	alert("Error: Invalid Insemination Date: Not Greater than Today's Date");
		
		 	return false;
		  }

}


//validate health form
function Check_health_form()
{
	//date of treatment of the not greater than today
		var health_date=document.forms['health_form']['date_treatment'].value;
   		var split=health_date.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {
		  	alert("Error: Invalid Treatment Date: Not Greater than Today's Date");
		
		 	return false;
		  }

}

//validate health form
function Check_health_update()
{
	//date of treatment of the not greater than today
		var health_date=document.forms['health_update']['date_treatment'].value;
   		var split=health_date.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {
		  	alert("Error: Invalid Treatment Date: Not Greater than Today's Date");
		
		 	return false;
		  }

}

//functions
$(document).ready(function()
{




 $('#tblMilk').dataTable( {
        "sDom": 'T<"clear">lfrtip',
        "oTableTools": {
            "aButtons":  ['copy', 'pdf', 'print'],
            "bJQueryUI": true,
			"sPaginationType": "full_numbers"
        }
    } );
 

 $('#tblcalving').dataTable( {
        "sDom": 'T<"clear">lfrtip',
        "oTableTools": {
            "aButtons": ['copy', 'pdf', 'print']
        }
    } );

 $('#tblIns').dataTable( {
        "sDom": 'T<"clear">lfrtip',
        "oTableTools": {
            "aButtons":  ['copy', 'pdf', 'print']
        }
    } );

 $('#tblfeed').dataTable( {
        "sDom": 'T<"clear">lfrtip',
        "oTableTools": {
            "aButtons": ['copy', 'pdf', 'print']
        }
    } );

 $('#tblhealth').dataTable( {
        "sDom": 'T<"clear">lfrtip',
        "oTableTools": {
            "aButtons":  ['copy', 'pdf', 'print']

        }
    } );

 $('#tblIncome').dataTable( {
        "sDom": 'T<"clear">lfrtip',
        "oTableTools": {
            "aButtons":  ['copy', 'pdf', 'print']

        }
    } );


 $('#tblinactiveusers').dataTable( {
        "sDom": 'T<"clear">lfrtip',
        "oTableTools": {
            "aButtons":  ['copy', 'pdf', 'print']

        }
    } );

  $('#tblactiveusers').dataTable( {
        "sDom": 'T<"clear">lfrtip',
        "oTableTools": {
            "aButtons":  ['copy', 'pdf', 'print']

        }
    } );

 

//provide data for analysis
$('#btn_income').click(function(){

	to=$('#to_date_income').val();
	from=$('#from_date_income').val();

	if(to!=null && to!='' && from!=null && from!='')
	{
		$('#form_income_error').html("");	

		if(to>from)
		{
			$.ajax({
					type: 'POST',
					url: 'http://localhost/record/index.php/dashboard/analysis_income_record',
					data: 'from='+from+'&to='+to,
					success: function(data)
					{
						$('#analysis_income_result').html(data);
					}
			
			});
		}
		else
		{
			alert('To date should be Greater than From Date');
		}
	}
	else
	{
		$('#form_income_error').html("<em>Both dates should be set</em><br/>");	
	}

});

	 //////////////////////////////////////////////////////////////////////////////////////////////////////


    //onblur on the cow field  for removing spaces.
    $('#cow_id_field').blur(function()
   	{	
   		var cow_id=$(this).val();
   		var split=cow_id.split(' ');
   		var join= split.join('');

   		cow_id=join;
   		$.ajax({
		type: 'POST',
		url: 'http://localhost/record/index.php/dashboard/check_if_cow_id_exists',
		data: 'cow_id='+cow_id,
		success: function(data)
		{
			if(data==1)
			{
				$('#form_cow_id').html("<em>Cow Id exists check another one</em><br/>");
				$('#cow_add_btn').attr('disabled', 'disabled');
			}
			else
			{
				$('#form_cow_id').html("");
				$('#cow_add_btn').removeAttr('disabled');
			}
				
		}

		});
   	

   	});//end


   	//onblur on the date of birth  
    $('#date_cow_birth').blur(function()
   	{	
   		var date_record=$(this).val();

   		var split=date_record.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {

		 	var y=document.getElementById("form_dob");
  			y.innerHTML="Invalid Date of Birth";

		  }
		  else
		  {
		  	var y=document.getElementById("form_dob");
  			y.innerHTML="";

		  }
   	

   	});//end

   	//onblur on the date of treatment
    $('#date_treatment').blur(function()
   	{	
   		var date_record=$(this).val();

   		var split=date_record.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {

		 	var y=document.getElementById("form_health_date");
  			y.innerHTML="Invalid Treatment Date";

		  }
		  else
		  {
		  	var y=document.getElementById("form_health_date");
  			y.innerHTML="";

		  }
   	

   	});//end


   		//onblur on the date of insemination
    $('#date_insemination').blur(function()
   	{	
   		var date_record=$(this).val();

   		var split=date_record.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {

		 	var y=document.getElementById("form_insemination_date");
  			y.innerHTML="Invalid Insemination Date";

		  }
		  else
		  {
		  	var y=document.getElementById("form_insemination_date");
  			y.innerHTML="";

		  }
   	

   	});//end


   		//onblur on the date of feeding 
    $('#date_feed').blur(function()
   	{	
   		var date_record=$(this).val();

   		var split=date_record.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {

		 	var y=document.getElementById("form_feed_date");
  			y.innerHTML="Invalid feed Date";

		  }
		  else
		  {
		  	var y=document.getElementById("form_feed_date");
  			y.innerHTML="";

		  }
   	

   	});//end


   		//onblur on the date of calving
    $('#date_calving').blur(function()
   	{	
   		var date_record=$(this).val();

   		var split=date_record.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {

		 	var y=document.getElementById("form_calving_date");
  			y.innerHTML="Invalid Calving Date";

		  }
		  else
		  {
		  	var y=document.getElementById("form_calving_date");
  			y.innerHTML="";

		  }
   	

   	});//end

   		//onblur on the date of milk
    $('#milk_date').blur(function()
   	{	
   		var date_record=$(this).val();

   		var split=date_record.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {

		 	var y=document.getElementById("form_milk_date");
  			y.innerHTML="Invalid Milk Date";

		  }
		  else
		  {
		  	var y=document.getElementById("form_milk_date");
  			y.innerHTML="";

		  }
   	

   	});//end

    //onblur on the date of income/expense
   	$('#income_date').blur(function()
   	{	
   		var date_record=$(this).val();

   		var split=date_record.split('-');
   		var year=split[0];
   		var month=split[1];
   		var date=split[2];

   		var x=new Date();
		x.setFullYear(year,month-1, date);
   		var today=new Date();

		if (x>today)
		  {

		 	var y=document.getElementById("form_income_date");
  			y.innerHTML="Invalid Income Date";

		  }
		  else
		  {
		  	var y=document.getElementById("form_income_date");
  			y.innerHTML="";

		  }
   	

   	});//end












//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Delete Records
    //Delete Reminder record.
    $('.delete_reminder').click(function() {

    var confirm=window.confirm('Do you really want to delete this Record');

    if(confirm==true)
    {
        var parent = $(this).closest('tr');
        var str=$(this).val();
        $.ajax({

        	type: 'POST',
		    url: 'http://localhost/record/index.php/dashboard/delete_reminder_record',
		    data: 'reminder_id='+str,
            success: function() {
            	parent.css("color","red");
                parent.fadeOut(300,function() {
                    parent.remove();
                    window.location.reload();
                });
            }
        });        
    
    }

    }); 

//Delete income and expenses record

     $('.delete_income').click(function() {

    var confirm=window.confirm('Do you really want to delete this Record');

    if(confirm==true)
    {
        var parent = $(this).closest('tr');
        var str=$(this).val();
        $.ajax({

        	type: 'POST',
		    url: 'http://localhost/record/index.php/dashboard/delete_income_expense_record',
		    data: 'income_id='+str,
            success: function() {
            	parent.css("color","red");
                parent.fadeOut(300,function() {
                    parent.remove();
                    window.location.reload();
                });
            }
        });        
    
    }

    }); 
//delete calving record

 $('.delete_calving').click(function() {

    var confirm=window.confirm('Do you really want to delete this Record');

    if(confirm==true)
    {
        var parent = $(this).closest('tr');
        var str=$(this).val();
        $.ajax({

        	type: 'POST',
		    url: 'http://localhost/record/index.php/dashboard/delete_calving_record',
		    data: 'calf_id='+str,
            success: function() {
            	parent.css("color","red");
                parent.fadeOut(300,function() {
                    parent.remove();
                    window.location.reload();
                });
            }
        });        
    
    }

    }); 

//delete health record

 $('.delete_health').click(function() {

    var confirm=window.confirm('Do you really want to delete this Record');

    if(confirm==true)
    {
        var parent = $(this).closest('tr');
        var str=$(this).val();
        $.ajax({

        	type: 'POST',
		    url: 'http://localhost/record/index.php/dashboard/delete_health_record',
		    data: 'health_id='+str,
            success: function() {
            	parent.css("color","red");
                parent.fadeOut(300,function() {
                    parent.remove();
                    window.location.reload();
                });
            }
        });        
    
    }

    }); 

//Delete feed record
 $('.delete_feed').click(function() {

    var confirm=window.confirm('Do you really want to delete this Record');

    if(confirm==true)
    {
        var parent = $(this).closest('tr');
        var str=$(this).val();
        $.ajax({

        	type: 'POST',
		    url: 'http://localhost/record/index.php/dashboard/delete_feed_record',
		    data: 'feed_id='+str,
            success: function() {
            	parent.css("color","red");
                parent.fadeOut(300,function() {
                    parent.remove();
                    window.location.reload();
                });
            }
        });        
    
    }

    }); 

 //Delete Insemination record
 $('.delete_insemination').click(function() {

    var confirm=window.confirm('Do you really want to delete this Record');

    if(confirm==true)
    {
        var parent = $(this).closest('tr');
        var str=$(this).val();
        $.ajax({

        	type: 'POST',
		    url: 'http://localhost/record/index.php/dashboard/delete_insemination_record',
		    data: 'insemination_id='+str,
            success: function() {
            	parent.css("color","red");
                parent.fadeOut(300,function() {
                    parent.remove();
                    window.location.reload();
                });
            }
        });        
    
    }

    }); 


 //Delete Milk record
 $('.delete_milk').click(function() {

    var confirm=window.confirm('Do you really want to delete this Record');

    if(confirm==true)
    {
        var parent = $(this).closest('tr');
        var str=$(this).val();
        $.ajax({

        	type: 'POST',
		    url: 'http://localhost/record/index.php/dashboard/delete_milk_record',
		    data: 'milk_id='+str,
            success: function() {
            	parent.css("color","red");
                parent.fadeOut(300,function() {
                    parent.remove();
                     window.location.reload();
                });
            }
        });        
    
    }

    }); 

//Delete user 
 $('.delete_user').click(function() {

    var confirm=window.confirm('Do you really want to delete this User');

    if(confirm==true)
    {
        var parent = $(this).closest('tr');
        var str=$(this).val();
        $.ajax({

        	type: 'POST',
		    url: 'http://localhost/record/index.php/dashboard/delete_user',
		    data: 'phone_no='+str,
            success: function() {
            	parent.css("color","red");
                parent.fadeOut(300,function() {
                    parent.remove();
                   // window.location.reload();
                });
            }
        });        
    
    }

    }); 




});