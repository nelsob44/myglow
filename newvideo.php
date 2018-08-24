<?php

?>
<html>
<head>
    <style type="text/css">
        video {
            width: 40%;
            border-radius: 15px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    
    <script src="https://rtcmulticonnection.herokuapp.com/dist/RTCMultiConnection.min.js"></script>
    <script src="https://rtcmulticonnection.herokuapp.com/socket.io/socket.io.js"></script>
</head>
<body>
    
    <input id="txt-roomid" placeholder="Unique Room ID">

    <button id="btn-open-room">Open Room</button>
    <button id="btn-join-room">Join Room</button><hr>
    <input type="text" id="input-text-chat" placeholder="Enter Text Chat" disabled>
    <button id="share-file" disabled>Share File</button>
    <br><br>
    <button id="btn-leave-room" disabled>Leave /or close the room</button>

    <div id="room-urls" style="text-align: center;display: none;background: #F1EDED;margin: 15px -10px;border: 1px solid rgb(189, 189, 189);border-left: 0;border-right: 0;"></div>

    <div id="chat-container">
        <div id="file-container"></div>
        <div class="chat-output"></div>
    </div>
    
    
    <div id="local-videos-container"></div><hr>
    <div id="remote-videos-container"></div>
    
    <script>
        
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
        
        document.getElementById('btn-leave-room').onclick = function() {
            this.disabled = true;
            if (connection.isInitiator) {
                // use this method if you did NOT set "autoCloseEntireSession===true"
                // for more info: https://github.com/muaz-khan/RTCMultiConnection#closeentiresession
                connection.closeEntireSession(function() {
                    document.querySelector('h1').innerHTML = 'Entire session has been closed.';
                });
            } else {
                connection.leave();
            }
        };

    
        
        // ......................................................
        // ................FileSharing/TextChat Code.............
        // ......................................................
        document.getElementById('share-file').onclick = function() {
            var fileSelector = new FileSelector();
            fileSelector.selectSingleFile(function(file) {
                connection.send(file);
            });
        };
        document.getElementById('input-text-chat').onkeyup = function(e) {
            if (e.keyCode != 13) return;
            // removing trailing/leading whitespace
            this.value = this.value.replace(/^\s+|\s+$/g, '');
            if (!this.value.length) return;
            connection.send(this.value);
            appendDIV(this.value);
            this.value = '';
        };
        var chatContainer = document.querySelector('.chat-output');
        function appendDIV(event) {
            var div = document.createElement('div');
            div.innerHTML = event.data || event;
            chatContainer.insertBefore(div, chatContainer.firstChild);
            div.tabIndex = 0;
            div.focus();
            document.getElementById('input-text-chat').focus();
        }

        var connection = new RTCMultiConnection();

        // this line is VERY_important
        connection.socketURL = 'https://rtcmulticonnection.herokuapp.com:443/';
        connection.socketMessageEvent = 'audio-video-file-chat-demo';
        connection.enableFileSharing = true; // by default, it is "false".

        // all below lines are optional; however recommended.

        connection.session = {
            audio: true,
            video: true,
            /*data: true*/
            
        };

        connection.sdpConstraints.mandatory = {
            OfferToReceiveAudio: true,
            OfferToReceiveVideo: true
        };
        
        
        var localVideosContainer = document.getElementById('local-videos-container');
        var remoteVideosContainer = document.getElementById('remote-videos-container');

        connection.onstream = function(event) {
            var video = event.mediaElement;
            video.controls = true;
            
            if(event.type === 'local') {
                localVideosContainer.appendChild(video);
            
            }
            
            if(event.type === 'remote') {
                remoteVideosContainer.appendChild(video);
            
            }
        };
        
        /*connection.onmessage = appendDIV;
        connection.filesContainer = document.getElementById('file-container');
        connection.onopen = function() {
            document.getElementById('share-file').disabled = false;
            document.getElementById('input-text-chat').disabled = false;
            document.getElementById('btn-leave-room').disabled = false;
            document.querySelector('h1').innerHTML = 'You are connected with: ' + connection.getAllParticipants().join(', ');*/

          /*connection.onclose = function() {
                if (connection.getAllParticipants().length) {
                    document.querySelector('h1').innerHTML = 'You are still connected with: ' + connection.getAllParticipants().join(', ');
                } else {
                    document.querySelector('h1').innerHTML = 'Seems session has been closed or all participants left.';
                }
            };*/ 

    /*connection.onEntireSessionClosed = function(event) {
        document.getElementById('share-file').disabled = true;
        document.getElementById('input-text-chat').disabled = true;
        document.getElementById('btn-leave-room').disabled = true;
        document.getElementById('open-or-join-room').disabled = false;
        document.getElementById('open-room').disabled = false;
        document.getElementById('join-room').disabled = false;
        document.getElementById('room-id').disabled = false;
        connection.attachStreams.forEach(function(stream) {
            stream.stop();
        });
        // don't display alert for moderator
        if (connection.userid === event.userid) return;
        document.querySelector('h1').innerHTML = 'Entire session has been closed by the moderator: ' + event.userid;
    };
    connection.onUserIdAlreadyTaken = function(useridAlreadyTaken, yourNewUserId) {
        // seems room is already opened
        connection.join(useridAlreadyTaken);
    };*/
            
    /*function disableInputButtons() {
        
        document.getElementById('open-room').disabled = true;
        document.getElementById('join-room').disabled = true;
        document.getElementById('txt-roomid').disabled = true;
    }*/
    
    /*function showRoomURL(predefinedRoomId) {
        var roomHashURL = '#' + predefinedRoomId;
        var roomQueryStringURL = '?predefinedRoomId=' + predefinedRoomId;
        var html = '<h2>Unique URL for your room:</h2><br>';
        html += 'Hash URL: <a href="' + roomHashURL + '" target="_blank">' + roomHashURL + '</a>';
        html += '<br>';
        html += 'QueryString URL: <a href="' + roomQueryStringURL + '" target="_blank">' + roomQueryStringURL + '</a>';
        var roomURLsDiv = document.getElementById('room-urls');
        roomURLsDiv.innerHTML = html;
        roomURLsDiv.style.display = 'block';
    };*/
            
    /*(function() {
        var params = {},
            r = /([^&=]+)=?([^&]*)/g;
        function d(s) {
            return decodeURIComponent(s.replace(/\+/g, ' '));
        }
        var match, search = window.location.search;
        while (match = r.exec(search.substring(1)))
            params[d(match[1])] = d(match[2]);
        window.params = params;
    })();
    var predefinedRoomId = '';
    if (localStorage.getItem(connection.socketMessageEvent)) {
        predefinedRoomId = localStorage.getItem(connection.socketMessageEvent);
    } else {
        predefinedRoomId = connection.token();
    }
    document.getElementById('txt-roomid').value = predefinedRoomId;
    document.getElementById('txt-roomid').onkeyup = function() {
        localStorage.setItem(connection.socketMessageEvent, this.value);
    };
    var hashString = location.hash.replace('#', '');
    if (hashString.length && hashString.indexOf('comment-') == 0) {
        hashString = '';
    }
    var predefinedRoomId = params.predefinedRoomId;
    if (!predefinedRoomId && hashString.length) {
        predefinedRoomId = hashString;
    }
    
    if (predefinedRoomId && predefinedRoomId.length) {
        document.getElementById('txt-roomid').value = predefinedRoomId;
        localStorage.setItem(connection.socketMessageEvent, predefinedRoomId);
        // auto-join-room
        (function reCheckRoomPresence() {
            connection.checkPresence(predefinedRoomId, function(isRoomExists) {
                if (isRoomExists) {
                    connection.join(predefinedRoomId);
                    return;
                }
                setTimeout(reCheckRoomPresence, 5000);
            });
        })();
        disableInputButtons();
    }*/
       
    </script>
    
</body>
</html>