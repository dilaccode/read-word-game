<script>
<?php
foreach ($ArrayVar as $Key => $Value) {
    $ValueStr = "";
    // bool
    if (is_bool($Value)) {
        $ValueStr = $Value ? "true" : "false";
    }
    //
    echo "var $Key = $ValueStr;";
}
?>
</script>
