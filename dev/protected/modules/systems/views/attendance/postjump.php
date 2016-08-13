<form action="<?php echo @$url; ?>" method="post" id="formmoney">
    <?php
    foreach ($params as $k => $v) {
        echo '<input type="hidden" name="' . $k . '" value="' . $v . '">';
    }
    ?>
</form>
<script type="text/javascript">
     document.getElementById('formmoney').submit();
</script>