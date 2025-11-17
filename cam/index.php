<!DOCTYPE html>
<html>
<head>
    <title>AR Card Game dengan Multiple Markers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- GUNAKAN VERSI INI - KOMBINASI YANG BETUL -->
    <!-- <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/AR-js-org/AR.js@3.3.0/aframe/build/aframe-ar.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aframe/1.2.0/aframe.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@ar-js-org/ar.js@3.3.0/aframe/build/aframe-ar.min.js"></script>
    
    <style>
        body {
            margin: 0;
            overflow: hidden;
            font-family: Arial, sans-serif;
            background: black;
        }
        .button-container {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            justify-content: space-around;
            width: 80%;
            z-index: 1000;
        }
        .button {
            display: none;
            background-color: #4CAF50;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            flex: 1;
            margin: 0 5px;
            font-size: 16px;
            z-index: 1001;
        }
        .button:hover {
            background-color: #45a049;
        }
        .marker-counter {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 24px;
            z-index: 1000;
            text-align: center;
        }
        #resetButton {
            background-color: #f44336;
        }
        #resetButton:hover {
            background-color: #da190b;
        }
        
        .loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 20px;
            z-index: 1000;
            background: rgba(0,0,0,0.8);
            padding: 20px;
            border-radius: 10px;
        }
        
        .debug-info {
            position: absolute;
            top: 80px;
            left: 10px;
            color: white;
            background: rgba(0,0,0,0.7);
            padding: 10px;
            border-radius: 5px;
            font-size: 12px;
            z-index: 1000;
            max-width: 300px;
        }
    </style>
</head>
<body>
    <div class="loading" id="loading">Loading AR Camera...</div>
    <div class="marker-counter" id="markerCounter">Soalan betul: 0</div>
    <div class="debug-info" id="debugInfo">
        Status: Initializing...<br>
        A-Frame: Loading...<br>
        AR.js: Loading...
    </div>

    <!-- Scene configuration yang betul -->
    <a-scene 
        embedded 
        arjs="sourceType: webcam; debugUIEnabled: false;"
        renderer="logarithmicDepthBuffer: true;"
        vr-mode-ui="enabled: false"
        stats>
        
        <!-- Marker 1 -->
        <a-marker id="marker1" type="pattern" url="../src/assets/marker/pattern/pattern-FL.patt" emitevents="true">
            <a-box position="0 0.25 0" width="1" height="0.5" depth="0.1" color="green"></a-box>
            <a-text value="Betul" color="white" align="center" position="0 0.8 0.1" scale="1.5 1.5 1.5"></a-text>
        </a-marker>

        <!-- Marker 2 -->
        <a-marker id="marker2" type="pattern" url="../src/assets/marker/pattern/pattern-PL.patt" emitevents="true">
            <a-box position="0 0.25 0" width="1" height="0.5" depth="0.1" color="green"></a-box>
            <a-text value="Betul" color="white" align="center" position="0 0.8 0.1" scale="1.5 1.5 1.5"></a-text>
        </a-marker>

        <!-- Marker 3 -->
        <a-marker id="marker3" type="pattern" url="../src/assets/marker/pattern/pattern-KH.patt" emitevents="true">
            <a-box position="0 0.25 0" width="1" height="0.5" depth="0.1" color="green"></a-box>
            <a-text value="Betul" color="white" align="center" position="0 0.8 0.1" scale="1.5 1.5 1.5"></a-text>
        </a-marker>

        <!-- Marker 4 -->
        <a-marker id="marker4" type="pattern" url="../src/assets/marker/pattern/pattern-TD.patt" emitevents="true">
            <a-box position="0 0.25 0" width="1" height="0.5" depth="0.1" color="green"></a-box>
            <a-text value="Betul" color="white" align="center" position="0 0.8 0.1" scale="1.5 1.5 1.5"></a-text>
        </a-marker>

        <a-entity camera></a-entity>
    </a-scene>

    <div class="button-container">
        <button id="actionButton" class="button">Submit Jawapan</button>
        <button id="resetButton" class="button">Mula semula</button>
    </div>

    <script>
        // Debug info
        const debugInfo = document.getElementById('debugInfo');
        function updateDebugInfo(message) {
            debugInfo.innerHTML += message + '<br>';
            console.log('DEBUG:', message);
        }

        updateDebugInfo('Script started...');

        // Check if A-Frame is loaded
        if (typeof AFRAME === 'undefined') {
            updateDebugInfo('ERROR: A-Frame not loaded');
        } else {
            updateDebugInfo('A-Frame loaded successfully');
        }

        // Check if AR.js is loaded
        if (typeof THREEx === 'undefined') {
            updateDebugInfo('ERROR: AR.js not loaded properly');
        } else {
            updateDebugInfo('AR.js loaded successfully');
        }

        // Initialize tracking
        let foundMarkers = {
            marker1: false,
            marker2: false, 
            marker3: false,
            marker4: false
        };
        
        let correctMarkersCountSum = 0;
        const markerCounter = document.getElementById('markerCounter');

        function updateCounter() {
            markerCounter.innerText = `Soalan betul: ${correctMarkersCountSum}`;
        }

        // Scene event listeners
        const scene = document.querySelector('a-scene');
        
        scene.addEventListener('loaded', function() {
            updateDebugInfo('Scene loaded successfully');
            document.getElementById('loading').style.display = 'none';
            
            // Initialize markers after scene is loaded
            initializeMarkers();
        });

        scene.addEventListener('arjs-mode-ready', function() {
            updateDebugInfo('AR.js mode ready');
        });

        function initializeMarkers() {
            updateDebugInfo('Initializing markers...');
            
            const markerIds = ['marker1', 'marker2', 'marker3', 'marker4'];
            
            markerIds.forEach(function(markerId) {
                const marker = document.getElementById(markerId);
                if (marker) {
                    updateDebugInfo(markerId + ' found in DOM');
                    
                    marker.addEventListener('markerFound', function() {
                        updateDebugInfo(markerId + ' detected!');
                        
                        if (!foundMarkers[markerId]) {
                            foundMarkers[markerId] = true;
                            correctMarkersCountSum++;
                            updateCounter();
                            sendPoints(markerId);
                        }
                        
                        document.getElementById('actionButton').style.display = 'block';
                        document.getElementById('resetButton').style.display = 'block';
                    });

                    marker.addEventListener('markerLost', function() {
                        updateDebugInfo(markerId + ' lost');
                    });
                } else {
                    updateDebugInfo('ERROR: ' + markerId + ' not found in DOM');
                }
            });
        }

        function sendPoints(markerId) {
            const formData = new FormData();
            formData.append('markerId', markerId);
            formData.append('points', '1');
            
            fetch('../backend/ar.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log('Success:', data);
                updateDebugInfo('Points sent for ' + markerId);
            })
            .catch((error) => {
                console.error('Error:', error);
                updateDebugInfo('Error sending points for ' + markerId);
            });
        }

        function submitMarks() {
            const formData = new FormData();
            formData.append('markah', correctMarkersCountSum);
            
            fetch('../backend/ar.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = 'hasil.php?markah=' + correctMarkersCountSum;
                } else {
                    console.error('Submission failed');
                    alert('Error submitting marks. Please try again.');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('Network error. Please check your connection.');
            });
        }

        // Button events
        const actionButton = document.getElementById('actionButton');
        const resetButton = document.getElementById('resetButton');

        actionButton.addEventListener('click', function() {
            if (confirm('Adakah anda pasti untuk menghantar jawapan?')) {
                submitMarks();
            }
        });

        resetButton.addEventListener('click', function() {
            if (confirm('Adakah anda pasti untuk mula semula?')) {
                foundMarkers = {
                    marker1: false,
                    marker2: false, 
                    marker3: false,
                    marker4: false
                };
                correctMarkersCountSum = 0;
                updateCounter();
                actionButton.style.display = 'none';
                resetButton.style.display = 'none';
                updateDebugInfo('Reset completed');
            }
        });

        // Fallback for errors
        window.addEventListener('error', function(e) {
            updateDebugInfo('Global error: ' + e.message);
            console.error('Global error:', e);
        });
    </script>
</body>
</html>