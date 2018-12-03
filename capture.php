<?php
session_start();
include_once 'login.php';
?> 

<!Doctype html>
<html>
<head>
<style>

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" >




window.onload=function(){

        var myOnlineCamera    = document.getElementById('myOnlineCamera'),
        video                 = myOnlineCamera.querySelectorAll('video')[0],
        canvas                = myOnlineCamera.querySelectorAll('canvas'),[0]
        button                =  document.getElementById('submitButton'),
        context               = canvas.getContext('2d');

        video.style.visibility = "hidden";
        canvas.style.visibility = "hidden";

        var height;
        var width;

        if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: { width: 1280, height: 720} }).then(stream => {
               
                var settings= stream.getVideoTracks()[0].getSettings();
                height= settings.height;
                width= settings.width;
                video.style.height = height;
                canvas.height = height;
                video.style.width = width;
                canvas.width = width;

                video.srcObject = stream;


                video.onloadedmetadata = function(e) {
                    video.play();
                    //alert(this.videoWidth+" "+this.videoHeight);
                    button.addEventListener("click", function() {
                        context.drawImage(video, 0, 0, width, height);
                        
                        var dataURL = canvas.toDataURL("image/png");
                        document.getElementById('hidden_data').value = dataURL;
                        var fd = new FormData(document.forms["form1"]);
 
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'upload_data.php', true);
        
                        xhr.upload.onprogress = function(e) {
                            if (e.lengthComputable) {
                                var percentComplete = (e.loaded / e.total) * 100;
                                console.log(percentComplete + '% uploaded');
                                alert('Succesfully uploaded');
                            }
                        };
        
                        xhr.onload = function() {
        
                        };
                        xhr.send(fd);
                     
                    });
                };
            }).catch((err)=>{
                alert(err);
            });
        }
        else{
            alert("Media devices does not exist");
        }

}

</script>
</head>
<body>

    <form action="upload_data.php" method="post" name="form1" >
        <input type="button" value="Capture and Upload" name="submit" id="submitButton">
        <input type="hidden" id='hidden_data' name="hidden_data">
    </form>
    <div id="myOnlineCamera">
        <canvas id="canvas"></canvas>
        <video  ></video>
    </div>

</body>
</html>

