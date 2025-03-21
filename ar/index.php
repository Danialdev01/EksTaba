<!DOCTYPE html>
<html>
<head>
    <title>AR Card Game with Multiple Markers</title>
    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
    <script src="https://cdn.rawgit.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script>
    <style>
        body {
            margin: 0;
            overflow: hidden;
        }
        .button-container {
            position: absolute;
            bottom: 20px; /* Space from the bottom */
            left: 50%;
            transform: translateX(-50%);
            display: flex; /* Use flexbox for layout */
            justify-content: space-around; /* Space buttons evenly */
            width: 80%; /* Width of the button container */
            z-index: 10; /* Ensure buttons are on top */
        }
        .button {
            display: none; /* Initially hidden */
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            flex: 1; /* Allow buttons to grow equally */
            margin: 0 5px; /* Space between buttons */
        }
        .marker-counter {
            position: absolute;
            top: 20px; /* Space from the top */
            left: 50%;
            transform: translateX(-50%);
            color: white; /* Text color */
            font-weight: bold; /* Bold text */
            font-size: 24px; /* Font size */
            z-index: 10; /* Ensure it's on top */
        }
    </style>
</head>
<body>
    <div class="marker-counter" id="markerCounter">Soalan betul: 0</div>

    <a-scene embedded arjs>
        <!-- Marker 1 -->
        <a-marker id="marker1" type="pattern" url="../src/assets/marker/pattern/pattern-FL.patt">
            <a-entity geometry="primitive: box; depth: 0.1; height: 0.5; width: 1" 
                      material="color: green;" 
                      position="0 1 0">
            </a-entity>
            <a-entity text="value: betul; color: white; align: center;" 
                      position="0 1 -3.1">
            </a-entity>
        </a-marker>

        <!-- Marker 2 -->
        <a-marker id="marker2" type="pattern" url="../src/assets/marker/pattern/pattern-LS.patt">
            <a-entity geometry="primitive: box; depth: 0.1; height: 0.5; width: 1" 
                      material="color: green;" 
                      position="0 1 0">
            </a-entity>
            <a-entity text="value: betul; color: white; align: center;" 
                      position="0 1 -3.1">
            </a-entity>
        </a-marker>

        <!-- Marker 3 -->
        <a-marker id="marker3" type="pattern" url="../src/assets/marker/pattern/pattern-KH.patt">
            <a-entity geometry="primitive: box; depth: 0.1; height: 0.5; width: 1" 
                      material="color: green;" 
                      position="0 1 0">
            </a-entity>
            <a-entity text="value: betul; color: white; align: center;" 
                      position="0 1 -3.1">
            </a-entity>
        </a-marker>

        <!-- Marker 4 -->
        <a-marker id="marker4" type="pattern" url="../src/assets/marker/pattern/pattern-TD.patt">
            <a-entity geometry="primitive: box; depth: 0.1; height: 0.5; width: 1" 
                      material="color: green;" 
                      position="0 1 0">
            </a-entity>
            <a-entity text="value: betul; color: white; align: center;" 
                      position="0 1 -3.1">
            </a-entity>
        </a-marker>

        <a-entity camera></a-entity>
    </a-scene>

    <div class="button-container">
        <a href="">
            <button id="actionButton1" class="button">Kenalpasti penggunaan tanda titik</button>
        </a>
        <button id="actionButton2" class="button">Kenalpasti penggunaan tanda soal</button>
        <button id="actionButton3" class="button">Kenalpasti penggunaan tanda koma</button>
        <button id="actionButton4" class="button">Kenalpasti penggunaan tanda seru</button>
    </div>

    <script>
        let correctMarkersCount = 0; // Counter for correct markers
        const markerCounter = document.getElementById('markerCounter');

        // Function to send points to the backend
        function sendPoints(markerId) {
            fetch('../backend/ar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ markerId: markerId, points: 1 }) // Send the marker ID and points to add
            })
            .then(response => response.json())
            .then(data =>{
                console.log('Success:', data);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }

        // Action button
        const actionButton1 = document.querySelector('#actionButton1');
        const actionButton2 = document.querySelector('#actionButton2');
        const actionButton3 = document.querySelector('#actionButton3');
        const actionButton4 = document.querySelector('#actionButton4');

        //@ Marker 1
        const marker1 = document.querySelector('#marker1');
        marker1.addEventListener('markerFound', function() {
            console.log('Marker 1 found!');
            actionButton1.style.display = 'block'; // Show button when marker is found
            correctMarkersCount++; // Increment counter
            markerCounter.innerText = `Correct Markers: ${correctMarkersCount}`; // Update display
            sendPoints('marker1');
        });

        marker1.addEventListener('markerLost', function() {
            actionButton1.style.display = 'none'; // Hide button when marker is lost
            correctMarkersCount--; // Decrement counter
            markerCounter.innerText = `Correct Markers: ${correctMarkersCount}`; // Update display
            console.log('Marker 1 lost!');
        });

        //@ Marker 2
        const marker2 = document.querySelector('#marker2');
        marker2.addEventListener('markerFound', function() {
            actionButton2.style.display = 'block'; // Show button when marker is found
            console.log('Marker 2 found!');
            correctMarkersCount++; // Increment counter
            markerCounter.innerText = `Correct Markers: ${correctMarkersCount}`; // Update display
            sendPoints('marker2');
        });

        marker2.addEventListener('markerLost', function() {
            actionButton2.style.display = 'none'; // Hide button when marker is lost
            correctMarkersCount--; // Decrement counter
            markerCounter.innerText = `Correct Markers: ${correctMarkersCount}`; // Update display
            console.log('Marker 2 lost!');
        });

        //@ Marker 3
        const marker3 = document.querySelector('#marker3');
        marker3.addEventListener('markerFound', function() {
            actionButton3.style.display = 'block'; // Show button when marker is found
            console.log('Marker 3 found!');
            correctMarkersCount++; // Increment counter
            markerCounter.innerText = `Soalan betul: ${correctMarkersCount}`; // Update display
            sendPoints('marker3');
        });

        marker3.addEventListener('markerLost', function() {
            actionButton3.style.display = 'none'; // Hide button when marker is lost
            correctMarkersCount--; // Decrement counter
            markerCounter.innerText = `Soalan betul: ${correctMarkersCount}`; // Update display
            console.log('Marker 3 lost!');
        });

        //@ Marker 4
        const marker4 = document.querySelector('#marker4');
        marker4.addEventListener('markerFound', function() {
            actionButton4.style.display = 'block'; // Show button when marker is found
            console.log('Marker 4 found!');
            correctMarkersCount++; // Increment counter
            markerCounter.innerText = `Soalan betul: ${correctMarkersCount}`; // Update display
            sendPoints('marker4');
        });

        marker4.addEventListener('markerLost', function() {
            actionButton4.style.display = 'none'; // Hide button when marker is lost
            correctMarkersCount--; // Decrement counter
            markerCounter.innerText = `Soaaln betul: ${correctMarkersCount}`; // Update display
            console.log('Marker 4 lost!');
        });
    </script>
</body>
</html>