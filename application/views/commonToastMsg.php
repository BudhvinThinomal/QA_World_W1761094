<!-- Toast Message styles -->
<link rel="stylesheet" type="text/css" href="<?php echo (base_url()); ?>assets/css/commonToastMsg.css">

<div id="toast-template" class="toast" style="display: none;">
  <p class="toast-message"></p>
</div>

<script>
    function showToast(message) {
        var toast = $('#toast-template').clone();
        toast.find('.toast-message').text(message);
        toast.appendTo('body');
        toast.fadeIn(200).delay(3000).fadeOut(200, function() {
            $(this).remove();
        });
    }
</script>