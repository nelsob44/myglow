<?php

?>
<html>
<head>
    <style type="text/css">
        video {
            width: 40%;
            border-radius: 15px;
        }
        #remote-videos-container {
          width: 80%;
        }
        #local-videos-container {
          width: 30%;
          position: inherit;
          top: 1px;
          left: 1px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

    <script src="https://rtcmulticonnection.herokuapp.com/dist/RTCMultiConnection.min.js"></script>
    <script src="https://rtcmulticonnection.herokuapp.com/socket.io/socket.io.js"></script>
</head>
<?php include("includes/header.php"); ?>
<body>
  <div class="video_chat_container">
      <div class="function_description" id="function_description"><br><h5><i>Multi-user video streaming (calls)</i></h5>
      <small>To make conference calls, simply copy the unique id in the box, click on 'open room', text the unique id to the user you want to join your conference call, and let them paste the same unique id in their box and click on 'join room'. Add as much users to your conference call following same procedure.</small>
      <hr>
      </div>
      <div class="chat_controls" id="chat_controls">
        <input id="txt-roomid" class="txt-roomid" placeholder="Unique Room ID">

        <button id="btn-open-room" class="chat_controls_button">Open Room</button>
        <button id="btn-join-room" class="chat_controls_button">Join Room</button>
        </div>
        <div id="remote-videos-container"><div id="local-videos-container"></div></div>
  </div>
    <script>
        var connection = new RTCMultiConnection();

        // this line is VERY_important
        connection.socketURL = 'https://rtcmulticonnection.herokuapp.com:443/';
        connection.socketMessageEvent = 'audio-video-file-chat-demo';
        connection.enableFileSharing = true; // by default, it is "false".

        // all below lines are optional; however recommended.

        connection.session = {
            audio: true,
            video: true,
            data: true
        };

        connection.sdpConstraints.mandatory = {
            OfferToReceiveAudio: true,
            OfferToReceiveVideo: true,
            OfferToReceiveData: true
        };


        var localVideosContainer = document.getElementById('local-videos-container');
        var remoteVideosContainer = document.getElementById('remote-videos-container');

        connection.onstream = function(event) {
            var video = event.mediaElement;

            if(event.type === 'local') {
                localVideosContainer.appendChild(video);

            }

            if(event.type === 'remote') {
                remoteVideosContainer.appendChild(video);

            }
        };

        var predefinedRoomId = document.getElementById('txt-roomid');

        predefinedRoomId.value = connection.token();

        document.getElementById('btn-open-room').onclick = function() {
            this.disabled = true;

            connection.open( predefinedRoomId.value );
            document.getElementById("function_description").innerHTML = "<h5><i>Multi-user video streaming</i><br><small>You are now streaming....</small>";
        };

        document.getElementById('btn-join-room').onclick = function() {
            this.disabled = true;
            connection.join( predefinedRoomId.value );
        };

        document.getElementById('share-file').onclick = function() {
            var fileSelector = new FileSelector();
            fileSelector.selectSingleFile(function(file) {
                connection.send(file);
            });
        };


    </script>

<div class="right_wrap">
        <div class="slideshow">
            <div>
             <img src="assets/images/adverts/barclaycard_advert.jpg" style="border-radius: 9px; width: 100%; height:100%;">
           </div>
           <div>
             <img src="assets/images/adverts/jobs_advert.jpg" style="border-radius: 9px; width: 100%; height:100%;">
           </div>
            <div>
             <img src="assets/images/adverts/kodak_advert.jpg" style="border-radius: 9px; width: 100%; height:100%;">
           </div>
           <div>
             <img src="assets/images/adverts/lexus_advert.jpg" style="border-radius: 9px; width: 100%; height:100%;">
           </div>
            <div>
             <img src="assets/images/adverts/truck_advert.jpg" style="border-radius: 9px; width: 100%; height:100%;">
           </div>
            <div>
             <img src="assets/images/adverts/tv_advert.jpg" style="border-radius: 9px; width: 100%; height:100%;">
           </div>
            
        
        </div>
    
        <div class="online_users">
            <b><h6 id='online_heading' style="text-align:center;">Friends Online</h6></b><hr>
           <?php
                $online_obj = new Online($con, $userLoggedIn);
                $online_obj->ShowOnlineUsers($con, $userLoggedIn);
            ?>
        </div>
        <div class="rss_newsfeed">
            <!-- start feedwind code --> <script type="text/javascript" src="https://feed.mikle.com/js/fw-loader.js" data-fw-param="83144/"></script> <!-- end feedwind code -->
        
        </div>
        
    
        <script>
                $(".slideshow > div:gt(0)").hide();

                    setInterval(function() {
                      $('.slideshow > div:first')
                        .fadeOut(1000)
                        .next()
                        .fadeIn(1000)
                        .end()
                        .appendTo('.slideshow');
                    }, 5000);
            
            </script>
</div>

</body>
</html>
