<?php
 function decode(){
   $combid = $this->input->post('credentials');
   print_r(credentials); die;
  $parts = explode('&&' , $combid,2);
echo ($parts);
}
?>