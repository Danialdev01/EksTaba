<!DOCTYPE html>
<html>
<head>
    <title>AR Card Game dengan Multiple Markers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- GUNAKAN VERSI INI - paling stabil -->
    <!-- <script src="https://aframe.io/releases/1.0.4/aframe.min.js"></script> -->
    <!-- <script src="https://raw.githack.com/AR-js-org/AR.js/3.3.0/aframe/build/aframe-ar.js"></script> -->

    <!-- Cuba kombinasi ini -->
<script src="https://cdn.jsdelivr.net/gh/aframevr/aframe@1.2.0/dist/aframe-master.min.js"></script>
<script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar-nft.js"></script>
    
    <style>
        body {
            margin: 0;
            overflow: hidden;
            font-family: Arial, sans-serif;
        }
        .button-container {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            justify-content: space-around;
            width: 80%;
            z-index: 10;
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
            z-index: 10;
            text-align: center;
        }
        #resetButton {
            background-color: #f44336;
        }
        #resetButton:hover {
            background-color: #da190b;
        }
        
        /* Loading indicator */
        .loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 20px;
            z-index: 100;
        }
    </style>
</head>
<body>
    <div class="loading" id="loading">Loading AR Camera...</div>
    <div class="marker-counter" id="markerCounter">Soalan betul: 0</div> 

    <!-- Scene configuration yang lebih simple -->
    <a-scene 
        embedded 
        arjs='sourceType: webcam; detectionMode: mono; maxDetectionRate: 30; canvasWidth: 640; canvasHeight: 480;'
        renderer="antialias: true; alpha: true"
        vr-mode-ui="enabled: false">
        
        <!-- Marker 1 -->
        <a-marker id="marker1" type="pattern" url="../src/assets/marker/pattern/pattern-FL.patt" emitevents="true" smooth="true" smoothCount="5" smoothTolerance="0.01" smoothThreshold="5">
            <a-box position="0 0.25 0" width="1" height="0.5" depth="0.1" color="green"></a-box>
            <a-text value="Betul" color="white" align="center" position="0 0.8 0.1" scale="1.5 1.5 1.5"></a-text>
        </a-marker>

        <!-- Marker 2 -->
        <a-marker id="marker2" type="pattern" url="../src/assets/marker/pattern/pattern-PL.patt" emitevents="true" smooth="true" smoothCount="5" smoothTolerance="0.01" smoothThreshold="5">
            <a-box position="0 0.25 0" width="1" height="0.5" depth="0.1" color="green"></a-box>
            <a-text value="Betul" color="white" align="center" position="0 0.8 0.1" scale="1.5 1.5 1.5"></a-text>
        </a-marker>

        <!-- Marker 3 -->
        <a-marker id="marker3" type="pattern" url="../src/assets/marker/pattern/pattern-KH.patt" emitevents="true" smooth="true" smoothCount="5" smoothTolerance="0.01" smoothThreshold="5">
            <a-box position="0 0.25 0" width="1" height="0.5" depth="0.1" color="green"></a-box>
            <a-text value="Betul" color="white" align="center" position="0 0.8 0.1" scale="1.5 1.5 1.5"></a-text>
        </a-marker>

        <!-- Marker 4 -->
        <a-marker id="marker4" type="pattern" url="../src/assets/marker/pattern/pattern-TD.patt" emitevents="true" smooth="true" smoothCount="5" smoothTolerance="0.01" smoothThreshold="5">
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
        // Tunggu scene load dulu
        document.querySelector('a-scene').addEventListener('loaded', function() {
            console.log('Scene loaded successfully');
            document.getElementById('loading').style.display = 'none';
        });

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

        function sendPoints(markerId) {
            // Gunakan FormData untuk lebih compatible
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
            })
            .catch((error) => {
                console.error('Error:', error);
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
            }
        });

        // Setup marker events dengan delay untuk pastikan scene ready
        setTimeout(function() {
            ['marker1', 'marker2', 'marker3', 'marker4'].forEach(function(markerId) {
                const marker = document.getElementById(markerId);
                if (marker) {
                    marker.addEventListener('markerFound', function() {
                        console.log(markerId + ' found!');
                        
                        if (!foundMarkers[markerId]) {
                            foundMarkers[markerId] = true;
                            correctMarkersCountSum++;
                            updateCounter();
                            sendPoints(markerId);
                        }
                        
                        actionButton.style.display = 'block';
                        resetButton.style.display = 'block';
                    });

                    marker.addEventListener('markerLost', function() {
                        console.log(markerId + ' lost!');
                    });
                }
            });
        }, 2000); // Delay 2 saat untuk pastikan semua loaded
    </script>
</body>
</html>