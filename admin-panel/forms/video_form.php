
<!-- Load css -->
<style>
    .card-header {
        padding: 6px 12px;
        background-color: #e9f2fb;
        color: #2666a3;
        font-weight: bold;
        font-size: 16px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .card {
        border-radius: 6px;
    }
    .row {
        margin-left: 0;
        margin-right: 0;
    }
    .col-md-6 {
        padding-left: 10px;
        padding-right: 10px;
    }
   .card {
        border: 1px solid #ccc !important;   /* Ensures border shows */
        border-radius: 6px;                  /* Slightly rounded corners */
        margin-bottom: 20px;                 /* Space between vertical cards */
        padding: 0;                          /* No inner padding on outer card (use inside elements) */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05); /* Light shadow */
        background-color: #fff;              /* Ensure white background */
    }
    .card-header {
        background-color: #f5f9fd;           /* Soft blue header */
        color: #2666a3;                      /* Text color */
        font-weight: 600;
        font-size: 16px;
        padding: 10px 15px;
        border-bottom: 1px solid #ccc;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
    }
    .card-body {
        padding: 15px;
    }
</style>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">Video Form</div>
                <div class="card-body">

                        <?php if (!empty($edit) && !empty($customer['video_name'])): ?>
                            <div class="form-group" id="current-video-block">
                                <label class="font-weight-bold">Current Video:</label><br>
                                <video width="520" height="240" controls>
                                    <source src="uploads/videos/<?php echo htmlspecialchars($customer['video_name'], ENT_QUOTES, 'UTF-8'); ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        <?php endif; ?>


                        <!-- Preview Selected Video -->
                        <div id="video-preview" style="display:none;" class="form-group">
                            <label class="font-weight-bold">Selected Video Preview:</label><br>
                            <video width="520" height="240" controls id="preview-player">
                                <source src="" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold" for="video_file"><?php echo (!empty($edit) ? 'Change Video' : 'Upload Video *'); ?></label>
                            <input type="file" name="video_file" id="video_file" class="form-control" accept="video/*" <?php echo empty($edit) ? 'required' : ''; ?>>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-warning">
                                Save <span class="glyphicon glyphicon-send"></span>
                            </button>
                        </div>            

                </div>            
            </div>            
        </div>            
    </div>            
</div>    

<script>
    document.getElementById('video_file').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('video-preview');
        const previewPlayer = document.getElementById('preview-player');
        const currentVideoBlock = document.getElementById('current-video-block');

        if (file && file.type.startsWith('video/')) {
            const fileURL = URL.createObjectURL(file);
            previewPlayer.src = fileURL;
            previewContainer.style.display = 'block';

            // Hide current video block
            if (currentVideoBlock) {
                currentVideoBlock.style.display = 'none';
            }
        } else {
            previewContainer.style.display = 'none';
            previewPlayer.src = '';

            // Show current video block again if no new file selected
            if (currentVideoBlock) {
                currentVideoBlock.style.display = 'block';
            }
        }
    });
</script>




