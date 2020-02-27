<div class="modal fade" id="<?php echo $key; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $key; ?>" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="<?php echo $key; ?>"><?php echo $title; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
      jQuery(function($){
        $("#<?php echo $key; ?> .modal-body").load("<?php echo $loadscript_root . $loadscript; ?>");
      });
</script>

<style type="text/css">
  .bst4-wrapper #<?php echo $key; ?> .modal-dialog{
    <?php if(!empty($width)): ?>
    width: <?php echo $width; ?>;
    <?php endif;//end !empty($width) ?>
    <?php if(!empty($height)): ?>
    height: <?php echo $height; ?>;
    <?php endif;//end !empty($height) ?>
    <?php if(!empty($top)): ?>
    top: <?php echo $top; ?>;
    <?php endif;//end !empty($top) ?>
  }
</style>