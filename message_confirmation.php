<?php //message  de confirmation
            if(isset($_GET['msg'])){ //if 1
    ?>	
    <?php if($_GET['type_msg']== '1'){ //if 2 ?>
        <div class="alert alert-success alert-dismissible fade in" 
             role="alert" id="p_msg_confirmation">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <strong><?php echo $_GET['msg']; ?></strong> 
       </div>
    <?php 
            } //fin if 2 
             else if($_GET['type_msg']== '0'){ 
    ?>
      <div class="alert alert-danger alert-dismissible fade in"
           role="alert" id="p_msg_confirmation">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong><?php echo $_GET['msg']; ?></strong> 
      </div>
    <?php } //fin else if ?>	

    <?php }//fin if 1 $_GET['msg'] ?>