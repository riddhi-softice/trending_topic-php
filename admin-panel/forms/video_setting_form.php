<fieldset>

    <!-- <div class="form-group">
        <label>Video Status * </label>
        <label class="radio-inline">
            <input type="radio" name="setting_value" value="is_show" <?php echo ($edit &&$customer['setting_value'] =='is_show') ? "checked": "" ; ?> required="required"/> Show
        </label>
        <label class="radio-inline">
            <input type="radio" name="setting_value" value="not_show" <?php echo ($edit && $customer['setting_value'] =='not_show')? "checked": "" ; ?> required="required" id=""/>Not Show
        </label>
    </div> -->

    <div class="form-group">
        <label>Video Status</label>
        <?php $opt_arr = array("is_show", "not_show"); ?>
        <select name="setting_value" class="form-control selectpicker" required>
            <?php
            foreach ($opt_arr as $opt) {
                $sel = ($edit && $opt == $customer['setting_value']) ? "selected" : "";
                $display_text = ucwords(str_replace("_", " ", $opt));
                echo '<option value="' . $opt . '" ' . $sel . '>' . $display_text . '</option>';
            }
            ?>
        </select>
    </div>

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
    </div>            
</fieldset>