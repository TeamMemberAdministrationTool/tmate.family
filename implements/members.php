<span id="family-select-names"></span>
<button type="button" class="btn" id="btn-family-select">Familienmitglieder auswählen</button>
<input type="hidden" name="familie" id="family-select-id" value="<?php echo($data[$name]); ?>" readonly>

<script>

    $("#btn-family-select").click(function() {
        createWindow("list", "addons/family/implements/query", <?php echo($id); ?>);
    });

</script>