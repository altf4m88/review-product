<?php
@session_start();
@session_destroy();
echo "
    <script>
    alert('Auf wiedersehn !');
    document.location.href='index.php'
    </script>
"
?>