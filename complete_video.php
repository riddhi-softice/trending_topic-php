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
        #mobile-card, #desktop-card, #intro-video {
            display: none;
        }
        #intro-video {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .video-wrapper {
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- Welcome Screen -->
        <div class="card" id="welcome-card">
            <h1>Welcome</h1>
            <!-- <b> questions</b> -->
            <p>Do you want to view the content?</p>
            <a class="btn" href="#"  id="continue-btn">Continue</a>  
        </div>

        <!-- Video Screen -->
        <!-- <div class="card video-wrapper" id="video-screen"> -->
            <video id="intro-video" src="assets/4.mp4" controls autoplay></video>
        <!-- </div> -->

        <!-- Mobile View -->
        <div class="card" id="mobile-card">
            <h1>Get Our Mobile App</h1>
            <p>This content is only available on smartphones. Tablets and desktop devices are not supported.</p>
            <a class="btn" href="https://play.google.com/store/apps/details?id=com.photolocationstamp.gpsmapgeotagongalleryphotos">
                Download from Google Play</a>
            <span>For the best experience, please use a smartphone</span>
        </div>

        <!-- Desktop View -->
        <div class="card" id="desktop-card">
            <h1>Get Our Desktop App</h1>
            <p>This content is only available on desktop and tablets devices. Smartphone is not supported.</p>
            <a class="btn" href="https://play.google.com/store/apps/details?id=com.photolocationstamp.gpsmapgeotagongalleryphotos">
                Download from Google Play</a>
            <span>For the best experience, please use a desktop and tablets devices.</span>
        </div>
    </div>

    <?php
        // Load DB config
        $config = require 'config/connection.php';
        // print_r($config);

        // Connect using MySQLi
        $conn = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get video_show_status from database
        $videoStatus = 'not_show'; // default fallback
        $sql = "SELECT setting_value FROM common_setting WHERE setting_key = 'video_show_status' LIMIT  1";
        $result = $conn->query($sql);

        if ($result && $row = $result->fetch_assoc()) {
            $videoStatus = $row['setting_value'];
        }
        $conn->close();
    ?>

    <!-- script start -->
    <script>
        const videoShowStatus = "<?= $videoStatus ?>"; // will be 'is_show' or 'not_show'
        console.log(videoShowStatus);
        
        document.getElementById('continue-btn').addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('welcome-card').style.display = 'none';

            const ua = navigator.userAgent;
            const isMobile = /Android.*Mobile|iPhone|iPod/i.test(ua);

            if (videoShowStatus === "is_show") {
                // document.getElementById('video-screen').style.display = 'block';
                document.getElementById('intro-video').style.display = 'block';
                document.getElementById('intro-video').play();
            } else {
                if (isMobile) {
                    document.getElementById('mobile-card').style.display = 'block';
                } else {
                    document.getElementById('desktop-card').style.display = 'block';
                }
            }
        });

        document.getElementById('intro-video').addEventListener('ended', function () {
            // document.getElementById('video-screen').style.display = 'none';
            document.getElementById('intro-video').style.display = 'none';

            const ua = navigator.userAgent;
            const isMobile = /Android.*Mobile|iPhone|iPod/i.test(ua);

            if (isMobile) {
                document.getElementById('mobile-card').style.display = 'block';
            } else {
                document.getElementById('desktop-card').style.display = 'block';
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