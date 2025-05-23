<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GPS</title>
    <link href="assets/css/style.css" rel="stylesheet" />
    <style>
    .card span {
        display: block;
        margin-top: 20px;
        font-size: 0.96rem;
        color: #abaaaade;
    }

    #mobile-card,
    #desktop-card,
    #intro-video {
        display: none;
    }

    #intro-video {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        width: 100vw;
        height: 100vh;
        object-fit: cover;
        z-index: 9999;
    }
    .card img {
      max-width: 40%;
    }
    </style>
</head>
<body>

    <?php
        $config = require 'config/connection.php';
        $conn = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $settings = [];
        $sql = "SELECT setting_key, setting_value FROM common_setting WHERE setting_key IN (
            'video_show_status', 'welcome_title', 'welcome_desc', 'welcome_button_text', 'welcome_button_color',
            'desktop_title', 'desktop_desc', 'desktop_btn_text', 'desktop_btn_color', 'desktop_note',
            'mobile_title', 'mobile_desc', 'mobile_redirect_link'
        )";
        $result = $conn->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        }
        $conn->close();
    ?>

    <div class="container">
        <!-- Welcome Screen -->
        <div class="card" id="welcome-card">
            <h1><?= $settings['welcome_title'] ?? 'Welcome' ?></h1>
            <p><?= $settings['welcome_desc'] ?? 'Do you want to view the content?' ?></p>
            <a class="btn" id="continue-btn" href="#"
                style="background: <?= $settings['welcome_button_color'] ?? '#17A34A' ?>">
                <?= $settings['welcome_button_text'] ?? 'Continue' ?>
            </a>
        </div>

        <!-- Video Screen -->
        <video id="intro-video" src="assets/4.mp4" autoplay muted playsinline></video>

        <!-- Mobile View -->
        <div class="card" id="mobile-card">
            <img src="assets/image/gamepad.png" alt="logo">
            <h1><?= $settings['mobile_title'] ?? 'Mobile Screen' ?></h1>
            <!-- <p><?= $settings['mobile_desc'] ?? 'Do you know mobile content?' ?></p> -->
            <a class="btn" href="<?= $settings['mobile_redirect_link'] ?? '#' ?>"
                style="background: <?= $settings['desktop_btn_color'] ?? '#17A34A' ?>">
                <?= $settings['desktop_btn_text'] ?? 'Download from Google Play' ?>
            </a>
        </div>

        <!-- Desktop View -->
        <div class="card" id="desktop-card">
            <h1><?= $settings['desktop_title'] ?? 'Get Our Mobile App' ?></h1>
            <p><?= $settings['desktop_desc'] ?? 'This content is only available on smartphone.' ?></p>
            <a class="btn" href="<?= $settings['mobile_redirect_link'] ?? '#' ?>"
                style="background: <?= $settings['desktop_btn_color'] ?? '#17A34A' ?>">
                <?= $settings['desktop_btn_text'] ?? 'Download from Google Play' ?>
            </a>
            <span><?= $settings['desktop_note'] ?? 'For the best experience, please use a desktop.' ?></span>
        </div>
    </div>

    <!-- script start -->
    <script>
        const videoShowStatus = "<?= $settings['video_show_status'] ?? 'not_show' ?>";
        console.log(videoShowStatus);

        document.getElementById('continue-btn').addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('welcome-card').style.display = 'none';

            const ua = navigator.userAgent;
            const isMobile = /Android.*Mobile|iPhone|iPod/i.test(ua);

            if (videoShowStatus === "is_show" && isMobile) {
                // 1. video_show_status = 'is_show'
                // 2. Device is mobile

                // Show and play the video
                const video = document.getElementById('intro-video');
                video.style.display = 'block';
                video.play();

                // After 3 seconds, hide video and show mobile card
                setTimeout(() => {
                    video.pause();
                    video.style.display = 'none';
                    document.getElementById('mobile-card').style.display = 'block';
                }, 3000);
            } else {
                if (isMobile) {
                    document.getElementById('mobile-card').style.display = 'block';
                } else {
                    document.getElementById('desktop-card').style.display = 'block';
                }
            }
        });
    </script>

    <!-- disable back-->
    <!-- <script type="text/javascript">
        function preventBack() {
            window.history.forward(); 
        }
        setTimeout("preventBack()", 0);
        window.onunload = function () { null };
    </script> -->

    <!-- <script>
        // disable F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+Shift+C, Ctrl+U
        document.addEventListener('keydown', function (e) {
            if (e.key === 'F12' ||
                (e.ctrlKey && e.shiftKey && e.key === 'I') ||
                (e.ctrlKey && e.shiftKey && e.key === 'J') ||
                (e.ctrlKey && e.shiftKey && e.key === 'C') ||
                (e.ctrlKey && e.key === 'u')) {
                e.preventDefault();
                return false;
            }
        }); 
        // right-click disable
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
            return false;
        }); 
    </script> -->

</body>
</html>