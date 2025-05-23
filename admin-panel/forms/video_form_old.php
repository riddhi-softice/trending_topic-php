<fieldset> 
    <?php if (!empty($edit) && !empty($customer['video_name'])): ?>
        <div class="form-group">
            <label>Current Video:</label><br>
            <video width="320" height="240" controls>
                <source src="uploads/videos/<?php echo htmlspecialchars($customer['video_name'], ENT_QUOTES, 'UTF-8'); ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <label for="video_file"><?php echo (!empty($edit) ? 'Change Video' : 'Upload Video'); ?> *</label>
        <input type="file" name="video_file" id="video_file" class="form-control" accept="video/*" <?php echo empty($edit) ? 'required' : ''; ?>>
    </div>

    <div class="form-group text-center">
        <button type="submit" class="btn btn-warning">
            Save <span class="glyphicon glyphicon-send"></span>
        </button>
    </div>            
</fieldset>

