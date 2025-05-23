<!-- Form PHP -->
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

<!-- previre php  -->
 <?php
// DB connection (PDO or mysqli assumed to be initialized as $conn)
$settingsData = [];
while ($row = $settings) {
    $settingsData[$row['setting_key']] = $row['setting_value'];
}
?>


<!-- Load preview css -->
<style>
    .preview {
        background-color: black;
        padding: 2px;
        margin-bottom: 10px;
    }
    .card-preview {
        background-color: #101827; 
        color: white;
        border-radius: 10px;
        padding: 20px 15px;
        text-align: center;
        max-width: 320px;
        width: 100%;
        margin: 20px auto;
    }

    .card-preview h1 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .card-preview p {
        font-size: 0.95rem;
        color: #cdd1d5;
        margin-bottom: 20px;
    }

    .card-preview .btn {
        display: inline-block;
        background-color: #17A34A;
        color: white;
        padding: 12px 30px;
        font-size: 0.95rem;
        font-weight: 600;
        border: none;
        border-radius: 6px;
        text-decoration: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .card-preview .btn:hover {
        background-color: #28b35d;
    }
</style>

<!-- Preview Html -->
<div class="container mt-4">
    <div class="row">
        <!-- Welcome Card -->
        <div class="col-md-6 mb-4">
            <div class="preview">
                <div class="card-preview" id="welcome-card">
                    <h1 id="preview-title"><?= htmlspecialchars($settingsData['welcome_title'] ?? 'Welcome') ?></h1>
                    <p id="preview-desc"><?= htmlspecialchars($settingsData['welcome_desc'] ?? 'Do you want to view the content?') ?></p>
                    <a class="btn"
                       id="continue-btn"
                       href="#"
                       style="background: <?= htmlspecialchars($settingsData['welcome_button_color'] ?? '#17A34A') ?>">
                        <?= htmlspecialchars($settingsData['welcome_button_text'] ?? 'Continue') ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Desktop Card -->
        <div class="col-md-6 mb-4">
            <div class="preview">
                <div class="card-preview" id="desktop-card">
                    <h1 id="desktop-title"><?= htmlspecialchars($settingsData['desktop_title'] ?? 'Get Our Mobile App') ?></h1>
                    <p id="desktop-desc"><?= htmlspecialchars($settingsData['desktop_desc'] ?? 'This content is only available on smartphones.') ?></p>
                    <a class="btn"
                       id="desktop-btn"
                       href="#"
                       style="background: <?= htmlspecialchars($settingsData['desktop_button_color'] ?? '#17A34A') ?>">
                        <?= htmlspecialchars($settingsData['desktop_button_text'] ?? 'Download from Google Play') ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ********************************************************************* -->

<!-- Load Form css -->
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

<!-- form html -->
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


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mappings = {
            'welcome_title': '#preview-title',
            'welcome_desc': '#preview-desc',
            'welcome_button_text': '#continue-btn',
            'welcome_button_color': '#continue-btn'
        };

        // Watch all relevant input fields
        document.querySelectorAll('[name^="values"]').forEach(input => {
            input.addEventListener('input', function () {
                const settingKey = input.closest('.form-group').querySelector('label').textContent.toLowerCase().replace(/\s+/g, '_');
                const selector = mappings[settingKey];

                if (!selector) return;

                if (settingKey === 'welcome_button_color') {
                    document.querySelector(selector).style.backgroundColor = input.value;
                } else if (settingKey === 'welcome_button_text') {
                    document.querySelector(selector).textContent = input.value;
                } else {
                    document.querySelector(selector).innerText = input.value;
                }
            });
        });

        const mappingsDesktop = {
            'desktop_title': '#desktop-title',
            'desktop_desc': '#desktop-desc',
            'desktop_button_text': '#desktop-btn',
            'desktop_button_color': '#desktop-btn'
        };

        // Watch all relevant input fields
        document.querySelectorAll('[name^="values"]').forEach(input => {
            input.addEventListener('input', function () {
                const settingKey = input.closest('.form-group').querySelector('label').textContent.toLowerCase().replace(/\s+/g, '_');
                const selector = mappingsDesktop[settingKey];

                if (!selector) return;

                if (settingKey === 'desktop_button_color') {
                    document.querySelector(selector).style.backgroundColor = input.value;
                } else if (settingKey === 'desktop_button_text') {
                    document.querySelector(selector).textContent = input.value;
                } else {
                    document.querySelector(selector).innerText = input.value;
                }
            });
        });
    });
</script>
