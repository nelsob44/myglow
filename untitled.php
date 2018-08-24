<?php

?>
<html>
<head>
    <style type="text/css">
        video {
            width: 50%;
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
<body>
  <h1>

      Multi-user (many-to-many) video streaming + text chat + file sharing using mesh networking model.
    </p>
  </h1>

    <input id="txt-roomid" placeholder="Unique Room ID">

    <button id="btn-open-room">Open Room</button>
    <button id="btn-join-room">Join Room</button><hr>


    <br><br>
    <div id="chat-container">
        <div id="file-container"></div><br>
        <div class="chat-output"></div>
    </div>


    <div id="remote-videos-container"><div id="local-videos-container"></div></div>

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

</body>
</html>
