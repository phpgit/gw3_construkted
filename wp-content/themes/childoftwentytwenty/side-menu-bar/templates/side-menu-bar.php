<link href="<?php echo $assets_root; ?>bootstrap-4.1.3.css" rel="stylesheet" media="screen">
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo $assets_root; ?>jquery-3.4.1.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo $assets_root; ?>bootstrap-4.1.3.min.js"></script>

<div class="bst4-wrapper">
    <div class="container-fluid">
        <nav id="navbar-right" class="navbar-right bg-light p-3">
          <ul class="nav flex-column">
            <?php foreach ($items as $key => $item): ?>
            <?php extract($item); ?>
            <li class="nav-item" id="nav-<?php echo $key; ?>">
              <button type="button" class="btn btn-light <?php echo $disabled; ?>" data-toggle="modal" data-target="#<?php echo $key; ?>" title="<?php echo $tooltip; ?>" href="#<?php echo $key; ?>"></button>
            </li>
            <?php endforeach ?>
          </ul>
        </nav>

        <?php 
        foreach ($items as $key => $item){
          extract($item);
          include __DIR__ . '/popup.php';
        } 
        ?>
    </div>
</div>
<script type="text/javascript">
    jQuery(function($){
      $(document).on('click', '#navbar-right .nav-item', function(e) {
        e.stopPropagation();
        // add class active to current button and remove it from the siblings
        $(this).toggleClass('active').siblings().not(this).removeClass('active');
      });
    });
</script>
<style type="text/css">
  .bst4-wrapper #navbar-right {
    height: 100vh;
    right: 0;
    position: absolute;
    padding: 0px !important;
  }

  .bst4-wrapper #navbar-right .nav,
  .bst4-wrapper #navbar-right .nav-item {
    margin:0px !important;
  }

  .bst4-wrapper #navbar-right .nav-item .btn{
    padding: 0px !important;
  }

  .bst4-wrapper .modal-dialog{
    position: absolute !important;
    float: right;
    right: 70px;
    top: 50px;
  }
  .bst4-wrapper .modal-dialog .modal-body{
    overflow: scroll;
  }
<?php foreach ($items as $key => $item): ?>
  <?php extract($item); ?>
  .bst4-wrapper #navbar-right #nav-<?php echo $key; ?> .btn{
      background: url('<?php echo $icons_root . $icon; ?>') no-repeat center center;
      width: 64px;
      height: 64px;
      padding: 10px;
      background-origin: content-box;
  } 
  .bst4-wrapper #navbar-right #nav-<?php echo $key; ?>.active .btn{
      background: url('<?php echo $icons_root . $icon_hl; ?>') no-repeat center center;
  } 
<?php endforeach ?>
</style>
