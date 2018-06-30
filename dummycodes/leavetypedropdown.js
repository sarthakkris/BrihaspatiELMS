
//leave type dropdown
<script>
$(document).ready(function(){
$('#button').click(function(){
$.getJSON(url,function (data){
  $('#select').append('<option value = ""' + value.ID+> + value.Name + '</option>'
});
});
});

$('#select').change(function () {
          $('').text('Selected Item: ' + this.options[this.selectedIndex].text);
      });
  });



//leave remaining 
