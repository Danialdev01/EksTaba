<!DOCTYPE html>
<html>
<head>
    <title>AR Card Game with Multiple Markers</title>
    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
    <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script>
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
    </style>
</head>
<body>
    <div class="marker-counter" id="markerCounter">Soalan betul: 0</div> 

    <a-scene 
        embedded 
        arjs="sourceType: webcam; debugUIEnabled: false;"
        renderer="logarithmicDepthBuffer: true;"
        vr-mode-ui="enabled: false">
        
        <!-- Marker 1 -->
        <a-marker id="marker1" type="pattern" url="../src/assets/marker/pattern/pattern-FL.patt" emitevents="true">
            <a-box position="0 0.25 0" rotation="0 0 0" width="1" height="0.5" depth="0.1" color="green"></a-box>
            <a-text 
                value="Betul" 
                color="white" 
                align="center" 
                position="0 0.8 0.1"
                scale="2 2 2">
            </a-text>
        </a-marker>

        <!-- Marker 2 -->
        <a-marker id="marker2" type="pattern" url="../src/assets/marker/pattern/pattern-PL.patt" emitevents="true">
            <a-box position="0 0.25 0" rotation="0 0 0" width="1" height="0.5" depth="0.1" color="green"></a-box>
            <a-text 
                value="Betul" 
                color="white" 
                align="center" 
                position="0 0.8 0.1"
                scale="2 2 2">
            </a-text>
        </a-marker>

        <!-- Marker 3 -->
        <a-marker id="marker3" type="pattern" url="../src/assets/marker/pattern/pattern-KH.patt" emitevents="true">
            <a-box position="0 0.25 0" rotation="0 0 0" width="1" height="0.5" depth="0.1" color="green"></a-box>
            <a-text 
                value="Betul" 
                color="white" 
                align="center" 
                position="0 0.8 0.1"
                scale="2 2 2">
            </a-text>
        </a-marker> 

        <!-- Marker 4 -->
        <a-marker id="marker4" type="pattern" url="../src/assets/marker/pattern/pattern-TD.patt" emitevents="true">
            <a-box position="0 0.25 0" rotation="0 0 0" width="1" height="0.5" depth="0.1" color="green"></a-box>
            <a-text 
                value="Betul" 
                color="white" 
                align="center" 
                position="0 0.8 0.1"
                scale="2 2 2">
            </a-text>
        </a-marker>

        <a-entity camera></a-entity>
    </a-scene>

    <div class="button-container">
        <button id="actionButton" class="button">Submit Jawapan</button>
        <button id="resetButton" class="button">Mula semula</button>
    </div>

    <script>
        // Initialize tracking for markers
        let foundMarkers = {
            marker1: false,
            marker2: false, 
            marker3: false,
            marker4: false
        };
        
        let correctMarkersCountSum = 0;
        const markerCounter = document.getElementById('markerCounter');

        // Function to update counter display
        function updateCounter() {
            markerCounter.innerText = `Soalan betul: ${correctMarkersCountSum}`;
        }

        // Function to send points to the backend
        function sendPoints(markerId) {
            fetch('../backend/ar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ markerId: markerId, points: 1 })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }

        // Function to submit final marks
        function submitMarks() {
            fetch('../backend/ar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `markah=${correctMarkersCountSum}`
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = 'hasil.php?markah=' + correctMarkersCountSum;
                } else {
                    console.error('Submission failed');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }

        // Button event listeners
        const actionButton = document.getElementById('actionButton');
        const resetButton = document.getElementById('resetButton');

        actionButton.addEventListener('click', function() {
            if (confirm('Adakah anda pasti untuk menghantar jawapan?')) {
                submitMarks();
            }
        });

        resetButton.addEventListener('click', function() {
            if (confirm('Adakah anda pasti untuk mula semula?')) {
                // Reset all counters and tracking
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

        // Marker event handlers
        function setupMarkerEvents(markerId) {
            const marker = document.getElementById(markerId);
            
            marker.addEventListener('markerFound', function() {
                console.log(`${markerId} found!`);
                
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
                console.log(`${markerId} lost!`);
                // Don't decrement counter when marker is lost
                // This prevents the count from going down when marker visibility is temporary
            });
        }

        // Initialize all markers
        setupMarkerEvents('marker1');
        setupMarkerEvents('marker2');
        setupMarkerEvents('marker3');
        setupMarkerEvents('marker4');

        // Initialize the scene
        document.querySelector('a-scene').addEventListener('loaded', function() {
            console.log('A-Frame scene loaded successfully');
        });
    </script>
</body>
</html>