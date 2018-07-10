
//leave type dropdown//
<script>
$(document).ready(function(){
$('#mySelect').click(function(){   // select is the id in the html page

  var url =
   $.getJSON(url,function (data){                    //here data is the array of leave types sent by the server with each leavetype having a specific leave id
     $.each(data, function (index, value) {         //index is index no. of elements of array, function is the callback function which is executed once data is recieved from the server
 $('#mySelect').append('<option value="' + value.leaveid + '">' + value.leavetype + '</option>');  //this shows the leave types dropdown menu
});
});
});

//$('#mySelect').change(function () {
        //  $('msg').text('Selected Item: ' + this.options[this.selectedIndex].text);
      //});
  });



//leave remaining//
$(document).ready(function(){
  $('#lrmain').on(function(){            //leaveremain is the id in the html page.
     var leavetype=$('#mySelect').val();            //geting the leavetype from the selected field leave type

    $.ajax({
      type:'POST',
			url :"<?php echo base_url();?>sisindex.php/ ",    //sending the type of leave selected to the server to calculate the no of days remaining in that particular leave type
			data:{'leavetype':leavetype},
			dataType:"html",                                  //return datatype
				success: function() {                           //function to be executed if successfully received from server
            var leaveremain = $('#lrmain').val();     //geting the leave remaining

            if (leaveremain !=0 ){                        //leave ramianing feild is not zero hence leave can be applied
              alert('leave can be applied');
            }
            else{
              alert("no leaves remaining");              //if leave remaining field is zero hence leave cannot be applied

            }

          $('#lrmain').html("leaveremaining is" = leaveremain );   //showing the leave remaining in the leave remaining  field


    })

  })
})



//calculating no of days using from & to fields.

//<script type="text/javascript">
//$('#StartDate').datepicker({
    //dateFormat: 'yy-mm-dd',
    //changeMonth: true,
    //changeYear: true,
//});
//$('#LastDate').datepicker({
    //dateFormat: 'yy-mm-dd',
  //  changeMonth: true,
    //changeYear: true,
//});
//$('#StartDate').datepicker().bind("change", function () {
  //  var minValue = $(this).val();
  //  minValue = $.datepicker.parseDate("yy-mm-dd", minValue);
  //  $('#LastDate').datepicker("option", "minDate", minValue);
    //calculate();
//});
//$('#LastDate').datepicker().bind("change", function () {
    //var maxValue = $(this).val();
    //maxValue = $.datepicker.parseDate("yy-mm-dd", maxValue);
    //$('#StartDate').datepicker("option", "maxDate", maxValue);
    //calculate();
//});

//function calculate() {
//    var d1 = $('#StartDate').datepicker('getDate');
    //var d2 = $('#LastDate').datepicker('getDate');
    //var oneDay = 24*60*60*1000;
    //var diff = 0;
  //  if (d1 && d2) {

      //diff = Math.round(Math.abs((d2.getTime() - d1.getTime())/(oneDay)));
    //}
    //$('.calculated').val(diff);
    //$('.minim').val(d1)
//}
//</script>



//sending the no of leaves taken to the server to update the database.//

$(document).ready(function(){
  $('#apply').click(function(){
  var fromdate = $('#StartDate').datepicker('getDate');     //geting the fromdate
  var todate = $('#LastDate').datepicker('getDate');         // geting the todate
  var oneDay = 24*60*60*1000;
  var diff = 0;
  if(fromdate='' || todate=''){
    alert('please fill dates');
  }
  else{
   diff = Math.round(Math.abs((todate.getTime() - fromdate.getTime())/(oneDay)));  //calculating the no of days leave applied for
  }

         $('#leavetaken').html('diff')

         $.ajax({
           url: "<?php echo base_url();?>sisindex.php/mobile/leavemgmtmobile.php/leaveapply",
           data: {'diff' : diff},
           method: 'POST',
           datatype: string,
           success: function(){
             alert("reached server successfully");
           }

         })

       })              }




//recieving data from server and showing the data on the leavestatus page
       $("#apply").click(function(){
    $(".TFtable ").load(                       //TFtable is the class of the table in the view page where data has to be loaded
        url :"<?php echo base_url();?>sisindex.php/mobile/leavemgmtmobile.php/lavestatus",  //url of the controller
        function(responseTxt, statusTxt, xhr)
        {
        if(statusTxt == "success")             //if success then block of code in this loop


            //alert("External content loaded successfully!");
        if(statusTxt == "error")                   //condition if error occurs
            alert("Error: " + xhr.status + ": " + xhr.statusText);
    });
});




recieving status data from server and displaying it on an html table

$(document).ready(function(){
  $.getJSON("url of the array", function(data){
    var status_data = " ";
    $.each(data,function(key,value){
      status_data += '<tr>';
        status_data += '<td>'+value.S.No.+'</td>';
      status_data += '<td>'+value.Leave Type+'</td>';
        status_data += '<td>'+value.Leave Description+'</td>';
          status_data += '<td>'+value.From Date+'</td>';
            status_data += '<td>'+value.To Date+'</td>';
              status_data += '<td>'+value.Reason for Rejecting Leave+'</td>';
                status_data += '<td>'+value.Status+'</td>';
                status_data += '</tr>';
    })
$('#status table').append(status table);

  })
})
