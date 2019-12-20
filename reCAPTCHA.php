<?php
//anasfanani.com
//delete credit sama dengan tidak menghargai pembuat
session_start();
if(!isset($_SESSION['recaptcha'])){
    $site_key   = "6LeSwsgUAAAAAPUsd19xroUflV2gAPXeH-LZLaVQ"; // Setting Disini https://www.google.com/recaptcha/admin
    $secret_key = "6LeSwsgUAAAAAGYlGTx40Az_YeOYxeEc7VBpACLi"; // Setting Disini https://www.google.com/recaptcha/admin
    if(isset($_POST['g_recaptcha_response'])){
        $post_data = http_build_query(
            array(
                'secret' => $secret_key,
                'response' => $_POST['g_recaptcha_response'],
                'remoteip' => $_SERVER['REMOTE_ADDR']
            )
        );
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $post_data
            )
        );
        $context  = stream_context_create($opts);
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        $result = json_decode($response);
        if ($result->success) {
            $_SESSION['recaptcha'] = $result->success;
        }else{
            $_SESSION['recaptcha'] = $result->success;
        }
    }else{
        ?>
    <html>
        <head>
            <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $site_key;?>"></script>
            <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
            <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('<?php echo $site_key;?>', {action: 'homepage'}).then(function(token) {
                   $.post('',{g_recaptcha_response: token}, function(result) {
                        location.reload(); 
                   });
                });
            });
            </script>
            <style>
            body {
              position: absolute;
              left: 50%;
              top: 50%;
              z-index: 1;
              width: 150px;
              height: 150px;
              margin: -75px 0 0 -75px;
              border: 16px solid #f3f3f3;
              border-radius: 50%;
              border-top: 16px solid #3498db;
              width: 120px;
              height: 120px;
              -webkit-animation: spin 2s linear infinite;
              animation: spin 2s linear infinite;
            }
            
            /* Safari */
            @-webkit-keyframes spin {
              0% { -webkit-transform: rotate(0deg); }
              100% { -webkit-transform: rotate(360deg); }
            }
            
            @keyframes spin {
              0% { transform: rotate(0deg); }
              100% { transform: rotate(360deg); }
            }
            </style>
            <style type="text/css">
            .grecaptcha-badge { 
                visibility: hidden;
            }
            </style>
        </head>
        <body>
        <small style="visibility: hidden;">This site is protected by reCAPTCHA and the Google 
            <a href="https://policies.google.com/privacy">Privacy Policy</a> and
            <a href="https://policies.google.com/terms">Terms of Service</a> apply.
        </small>
        </body>
    </html>
        <?php
    }
}else{
    echo "Google Validation Success";
}
?>
