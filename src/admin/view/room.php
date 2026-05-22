<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>National Online Hospital - Meeting Room</title>
    <link rel="icon" type="image/x-icon" href="/my/ABUAD-Online-Hospital/public/img/fljn.jpeg">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #1a1a2e;
            color: #fff;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #header {
            background: #16213e;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        #header h4 {
            color: #0f9b8e;
            font-size: 1rem;
        }

        #header span {
            font-size: 0.85rem;
            color: #aaa;
        }

        #videos {
            flex: 1;
            display: flex;
            gap: 10px;
            padding: 15px;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
        }

        video {
            background: #000;
            border-radius: 10px;
            width: 45%;
            max-height: 45vh;
            object-fit: cover;
        }

        #localVideo {
            border: 2px solid #0f9b8e;
        }

        #remoteVideo {
            border: 2px solid #444;
        }

        #controls {
            background: #16213e;
            padding: 15px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .ctrl-btn {
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: 0.2s;
        }

        #btnMute {
            background: #0f9b8e;
            color: #fff;
        }

        #btnCam {
            background: #0f9b8e;
            color: #fff;
        }

        #btnHangup {
            background: #e74c3c;
            color: #fff;
        }

        .ctrl-btn:hover {
            opacity: 0.8;
            transform: scale(1.05);
        }

        #status {
            text-align: center;
            padding: 8px;
            font-size: 0.85rem;
            color: #aaa;
            background: #0d0d1a;
        }

        #waitMsg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #aaa;
            display: none;
        }

        #waitMsg i {
            font-size: 3rem;
            display: block;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div id="header">
        <h4>🏥 National Online Hospital — Meeting Room</h4>
        <span id="roomLabel">Room: <?= htmlspecialchars($_GET['room'] ?? 'unknown') ?></span>
    </div>

    <div id="videos">
        <video id="localVideo" autoplay muted playsinline></video>
        <video id="remoteVideo" autoplay playsinline></video>
    </div>

    <div id="status">Connecting...</div>

    <div id="controls">
        <button class="ctrl-btn" id="btnMute" title="Mute">🎤</button>
        <button class="ctrl-btn" id="btnCam" title="Camera">📷</button>
        <button class="ctrl-btn" id="btnHangup" title="End Call" onclick="hangup()">📵</button>
    </div>

    <script>
        const roomId = <?= json_encode($_GET['room'] ?? '') ?>;
        const signalingUrl = 'wss://socketsbay.com/wss/v2/1/demo/'; // free public signaling for demo

        let localStream, peerConnection, ws;
        let muted = false,
            camOff = false;

        const config = {
            iceServers: [{
                urls: 'stun:stun.l.google.com:19302'
            }]
        };

        async function init() {
            try {
                localStream = await navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: true
                });
                document.getElementById('localVideo').srcObject = localStream;
                connectSignaling();
            } catch (e) {
                setStatus('Camera/mic access denied: ' + e.message);
            }
        }

        function connectSignaling() {
            ws = new WebSocket(signalingUrl);

            ws.onopen = () => {
                setStatus('Connected to signaling. Waiting for other participant...');
                ws.send(JSON.stringify({
                    type: 'join',
                    room: roomId
                }));
            };

            ws.onmessage = async (e) => {
                const data = JSON.parse(e.data);
                if (data.room !== roomId) return;

                if (data.type === 'join') {
                    // Someone joined — create offer
                    await createPeer(true);
                } else if (data.type === 'offer') {
                    await createPeer(false);
                    await peerConnection.setRemoteDescription(new RTCSessionDescription(data.sdp));
                    const answer = await peerConnection.createAnswer();
                    await peerConnection.setLocalDescription(answer);
                    ws.send(JSON.stringify({
                        type: 'answer',
                        sdp: answer,
                        room: roomId
                    }));
                } else if (data.type === 'answer') {
                    await peerConnection.setRemoteDescription(new RTCSessionDescription(data.sdp));
                } else if (data.type === 'ice') {
                    if (data.candidate) peerConnection.addIceCandidate(new RTCIceCandidate(data.candidate));
                }
            };

            ws.onerror = () => setStatus('Signaling error. Try refreshing.');
            ws.onclose = () => setStatus('Disconnected from signaling.');
        }

        async function createPeer(isInitiator) {
            peerConnection = new RTCPeerConnection(config);

            localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));

            peerConnection.ontrack = (e) => {
                document.getElementById('remoteVideo').srcObject = e.streams[0];
                setStatus('Connected — In call');
            };

            peerConnection.onicecandidate = (e) => {
                if (e.candidate) ws.send(JSON.stringify({
                    type: 'ice',
                    candidate: e.candidate,
                    room: roomId
                }));
            };

            if (isInitiator) {
                const offer = await peerConnection.createOffer();
                await peerConnection.setLocalDescription(offer);
                ws.send(JSON.stringify({
                    type: 'offer',
                    sdp: offer,
                    room: roomId
                }));
                setStatus('Offer sent. Waiting for other participant...');
            }
        }

        function hangup() {
            if (peerConnection) peerConnection.close();
            if (localStream) localStream.getTracks().forEach(t => t.stop());
            if (ws) ws.close();
            setStatus('Call ended.');
            document.getElementById('remoteVideo').srcObject = null;
            document.getElementById('localVideo').srcObject = null;
            window.close();
        }

        document.getElementById('btnMute').onclick = () => {
            muted = !muted;
            localStream.getAudioTracks().forEach(t => t.enabled = !muted);
            document.getElementById('btnMute').textContent = muted ? '🔇' : '🎤';
        };

        document.getElementById('btnCam').onclick = () => {
            camOff = !camOff;
            localStream.getVideoTracks().forEach(t => t.enabled = !camOff);
            document.getElementById('btnCam').textContent = camOff ? '🚫' : '📷';
        };

        function setStatus(msg) {
            document.getElementById('status').textContent = msg;
        }

        init();
    </script>
</body>

</html>