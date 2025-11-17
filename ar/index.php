<!DOCTYPE html>
<html>
<head>
    <title>AR Card Game with Multiple Markers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
    <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script>

    <!-- Alternative AR.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@ar-js-org/ar.js@3.3.0/aframe/build/aframe-ar.min.js"></script>

    <!-- Or -->
    <script src="https://unpkg.com/@ar-js-org/ar.js@3.3.0/aframe/build/aframe-ar.min.js"></script>

    <script src="../src/assets/js/aframe.min.js"></script>
    <script src="../src/assets/js/aframe-ar.js"></script>
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
            background-color: rgba(0,0,0,0.7);
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 24px;
            z-index: 10;
            text-align: center;
        }
        .loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 24px;
            z-index: 100;
        }
    </style>
</head>
<body>
    <div class="loading" id="loading">Loading AR Experience...</div>
    <div class="marker-counter" id="markerCounter">Soalan betul: 0</div> 

    <a-scene 
        embedded 
        arjs="sourceType: webcam; debugUIEnabled: false;"
        renderer="logarithmicDepthBuffer: true;"
        vr-mode-ui="enabled: false"
    >
        <!-- Marker 1 -->
        <a-marker id="marker1" type="pattern" url="../src/assets/marker/pattern/pattern-FL.patt" emitevents="true">
            <a-box position="0 0.5 0" rotation="0 45 0" color="#4CC3D9" scale="0.5 0.5 0.5"></a-box>
            <a-text 
                value="Betul" 
                color="white" 
                align="center" 
                position="0 1 0"
                scale="2 2 2">
            </a-text>
        </a-marker>

        <!-- Marker 2 -->
        <a-marker id="marker2" type="pattern" url="../src/assets/marker/pattern/pattern-PL.patt" emitevents="true">
            <a-box position="0 0.5 0" rotation="0 45 0" color="#4CC3D9" scale="0.5 0.5 0.5"></a-box>
            <a-text 
                value="Betul" 
                color="white" 
                align="center" 
                position="0 1 0"
                scale="2 2 2">
            </a-text>
        </a-marker>

        <!-- Marker 3 -->
        <a-marker id="marker3" type="pattern" url="../src/assets/marker/pattern/pattern-KH.patt" emitevents="true">
            <a-box position="0 0.5 0" rotation="0 45 0" color="#4CC3D9" scale="0.5 0.5 0.5"></a-box>
            <a-text 
                value="Betul" 
                color="white" 
                align="center" 
                position="0 1 0"
                scale="2 2 2">
            </a-text>
        </a-marker>

        <!-- Marker 4 -->
        <a-marker id="marker4" type="pattern" url="../src/assets/marker/pattern/pattern-TD.patt" emitevents="true">
            <a-box position="0 0.5 0" rotation="0 45 0" color="#4CC3D9" scale="0.5 0.5 0.5"></a-box>
            <a-text 
                value="Betul" 
                color="white" 
                align="center" 
                position="0 1 0"
                scale="2 2 2">
            </a-text>
        </a-marker>

        <!-- Camera -->
        <a-entity camera></a-entity>
    </a-scene>

    <div class="button-container">
        <button id="actionButton" class="button">Submit Jawapan</button>
        <button id="resetButton" class="button">Mula semula</button>
    </div>

    <script>
        // Wait for A-Frame to load
        window.addEventListener('load', function() {
            const loading = document.getElementById('loading');
            if (loading) {
                loading.style.display = 'none';
            }
            initializeApp();
        });

        function initializeApp() {
            let foundMarkers = new Set(); // Track which markers have been found
            let correctMarkersCountSum = 0;
            const markerCounter = document.getElementById('markerCounter');
            const actionButton = document.getElementById('actionButton');
            const resetButton = document.getElementById('resetButton');

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
                const totalMarks = foundMarkers.size;
                fetch('../backend/ar.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `markah=${totalMarks}`
                })
                .then(response => {
                    if (response.ok) {
                        window.location.href = 'hasil.php?markah=' + totalMarks;
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

            // Action button event listener
            actionButton.addEventListener('click', function() {
                if (confirm('Adakah anda pasti untuk menghantar jawapan?')) {
                    submitMarks();
                }
            });

            // Reset button event listener
            resetButton.addEventListener('click', function() {
                if (confirm('Adakah anda pasti untuk mula semula?')) {
                    foundMarkers.clear();
                    correctMarkersCountSum = 0;
                    markerCounter.innerText = `Soalan betul: ${correctMarkersCountSum}`;
                    actionButton.style.display = 'none';
                    resetButton.style.display = 'none';
                    console.log('Game reset');
                }
            });

            // Helper function to handle marker found
            function handleMarkerFound(markerId) {
                if (!foundMarkers.has(markerId)) {
                    foundMarkers.add(markerId);
                    correctMarkersCountSum = foundMarkers.size;
                    markerCounter.innerText = `Soalan betul: ${correctMarkersCountSum}`;
                    
                    // Show buttons when at least one marker is found
                    actionButton.style.display = 'block';
                    resetButton.style.display = 'block';
                    
                    sendPoints(markerId);
                    console.log(`Marker ${markerId} found! Total: ${correctMarkersCountSum}`);
                }
            }

            // Marker event listeners
            const markers = ['marker1', 'marker2', 'marker3', 'marker4'];
            
            markers.forEach(markerId => {
                const marker = document.getElementById(markerId);
                if (marker) {
                    marker.addEventListener('markerFound', function() {
                        handleMarkerFound(markerId);
                    });

                    marker.addEventListener('markerLost', function() {
                        console.log(`Marker ${markerId} lost`);
                        // Note: We don't remove from foundMarkers when marker is lost
                        // This maintains the count even if marker temporarily disappears
                    });
                } else {
                    console.warn(`Marker ${markerId} not found in DOM`);
                }
            });

            console.log('AR application initialized');
        }

        // Error handling for A-Frame scene
        document.querySelector('a-scene').addEventListener('loaded', function() {
            console.log('A-Frame scene loaded successfully');
        });

        document.querySelector('a-scene').addEventListener('error', function(e) {
            console.error('A-Frame scene error:', e);
        });
    </script>
</body>
</html>