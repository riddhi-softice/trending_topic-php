<?php
// Group settings by category
$welcome_settings = [];
$desktop_settings = [];
$mobile_settings = [];
$video_status_settings = [];

foreach ($settings as $setting) {
    $key = $setting['setting_key'];

    if (strpos($key, 'welcome_') === 0) {
        $welcome_settings[] = $setting;
    } elseif (strpos($key, 'desktop_') === 0) {
        $desktop_settings[] = $setting;
    } elseif (strpos($key, 'mobile_') === 0) {
        $mobile_settings[] = $setting;
    } elseif ($key === 'video_show_status') {
        $video_status_settings[] = $setting;
    }
}

// Helper to render form fields
function renderField($setting) {
    $html = '<div class="form-group">';
    $html .= '<label class="font-weight-bold">' . ucwords(str_replace("_", " ", $setting['setting_key'])) . '</label>';
    $html .= '<input type="hidden" name="ids[]" value="' . $setting['id'] . '" />';
    
    $value = htmlspecialchars($setting['setting_value']);
    $key = $setting['setting_key'];

    if ($key === 'video_show_status') {
        $options = ['is_show' => 'Show', 'not_show' => 'Not Show'];
        $html .= '<select class="form-control" name="values[' . $setting['id'] . ']">';
        foreach ($options as $val => $label) {
            $selected = ($setting['setting_value'] === $val) ? ' selected' : '';
            $html .= "<option value=\"$val\"$selected>$label</option>";
        }
        $html .= '</select>';

    } elseif (strpos($key, 'color') !== false) {
        $val = preg_match('/^#[0-9A-Fa-f]{6}$/', $value) ? $value : '#000000';
        $html .= '<input type="color" class="form-control" name="values[' . $setting['id'] . ']" value="' . $val . '" />';

    } elseif (strpos($key, 'desc') !== false) {
        $html .= '<textarea class="form-control" name="values[' . $setting['id'] . ']" rows="2">' . $value . '</textarea>';

    } else {
        $html .= '<input type="text" class="form-control" name="values[' . $setting['id'] . ']" value="' . $value . '" />';
    }

    $html .= '</div>';
    return $html;
}
?>

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
    .btn-primary {
        padding: 8px 24px;
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

<div class="container mt-4">
    <form method="post" action="">
        <!-- Row 1: Welcome + Desktop -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">Welcome Settings</div>
                    <div class="card-body">
                        <?php foreach ($welcome_settings as $s) echo renderField($s); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">Desktop Settings</div>
                    <div class="card-body">
                        <?php foreach ($desktop_settings as $s) echo renderField($s); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 2: Mobile + Video -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">Mobile Settings</div>
                    <div class="card-body">
                        <?php foreach ($mobile_settings as $s) echo renderField($s); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">Video Status</div>
                    <div class="card-body">
                        <?php foreach ($video_status_settings as $s) echo renderField($s); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="form-group text-center mt-4">
            <button type="submit" class="btn btn-primary">Save All Settings</button>
        </div>
    </form>
</div>

