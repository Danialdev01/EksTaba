<!DOCTYPE html>
<html>
<head>
    <title>AR Card Game with Multiple Markers</title>
    <meta http-equiv="Content-Security-Policy" content="default-src 'self' https://aframe.io https://cdn.rawgit.com data: blob: 'unsafe-inline' 'unsafe-eval'">
    <!-- <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script> -->
    <!-- <script src="https://cdn.rawgit.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script> -->
    <script src="../ar.js"></script>
    <script src="../aframe.js"></script>
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
        <button id="actionButton" class="button">Submit Jawapan</button>

        <button id="resetButton" class="button">Mula semula</button>
    </div>

    <script>
        let correctMarkersCount1 = 0; // Counter for correct markers
        let correctMarkersCount2 = 0; // Counter for correct markers
        let correctMarkersCount3 = 0; // Counter for correct markers
        let correctMarkersCount4 = 0; // Counter for correct markers
        let correctMarkersCountSum = 0; // Counter for correct markers
        const markerCounter = document.getElementById('markerCounter');

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
            .then(data =>{
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
                body: `markah=${correctMarkersCount1 + correctMarkersCount2 + correctMarkersCount3 + correctMarkersCount4}`
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = 'hasil.php?markah1=' + correctMarkersCount1 + '&markah2=' + correctMarkersCount2 + '&markah3=' + correctMarkersCount3 + '&markah4=' + correctMarkersCount4;
                } else {
                    console.error('Submission failed');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }

        // Action button
        const actionButton = document.querySelector('#actionButton');
        const resetButton = document.querySelector('#resetButton');

        actionButton.addEventListener('click', function() {
            if (confirm('Adakah anda pasti untuk menghantar jawapan?')) {
                submitMarks();
            }
        });

        //@ Marker 1
        const marker1 = document.querySelector('#marker1');
        marker1.addEventListener('markerFound', function() {
            console.log('Marker 1 found!');
            actionButton.style.display = 'block'; // Show button when marker is found
            resetButton.style.display = 'block'; // Show button when marker is found
            correctMarkersCount1++; // Increment counter
            correctMarkersCountSum++; // Increment counter
            markerCounter.innerText = `Correct Markers: ${correctMarkersCountSum}`; // Update display
            sendPoints('marker1');
        });

        marker1.addEventListener('markerLost', function() {
            // actionButton1.style.display = 'none'; // Hide button when marker is lost
            // correctMarkersCount--; // Decrement countera
            markerCounter.innerText = `Correct Markers: ${correctMarkersCount}`; // Update display
            console.log('Marker 1 lost!');
        });

        //@ Marker 2
        const marker2 = document.querySelector('#marker2');
        marker2.addEventListener('markerFound', function() {
            actionButton.style.display = 'block'; // Show button when marker is found
            resetButton.style.display = 'block'; // Show button when marker is found
            console.log('Marker 2 found!');
            correctMarkersCount2++; // Increment counter
            correctMarkersCountSum++; // Increment counter
            markerCounter.innerText = `Correct Markers: ${correctMarkersCountSum}`; // Update display
            sendPoints('marker2');
        });

        marker2.addEventListener('markerLost', function() {
            correctMarkersCount--; // Decrement counter
            markerCounter.innerText = `Correct Markers: ${correctMarkersCountSum}`; // Update display
            console.log('Marker 2 lost!');
        });

        //@ Marker 3
        const marker3 = document.querySelector('#marker3');
        marker3.addEventListener('markerFound', function() {
            actionButton.style.display = 'block'; // Show button when marker is found
            resetButton.style.display = 'block'; // Show button when marker is found
            console.log('Marker 3 found!');
            correctMarkersCount3++; // Increment counter
            correctMarkersCountSum++; // Increment counter
            markerCounter.innerText = `Soalan betul: ${correctMarkersCountSum}`; // Update display
            sendPoints('marker3');
        });

        marker3.addEventListener('markerLost', function() {
            // actionButton.style.display = 'block'; // Show button when marker is found
            correctMarkersCount--; // Decrement counter
            markerCounter.innerText = `Soalan betul: ${correctMarkersCount}`; // Update display
            console.log('Marker 3 lost!');
        });

        //@ Marker 4
        const marker4 = document.querySelector('#marker4');
        marker4.addEventListener('markerFound', function() {
            actionButton.style.display = 'block'; // Show button when marker is found
            resetButton.style.display = 'block'; // Show button when marker is found
            console.log('Marker 4 found!');
            correctMarkersCount4++; // Increment counter
            correctMarkersCountSum++; // Increment counter
            markerCounter.innerText = `Soalan betul: ${correctMarkersCountSum}`; // Update display
            sendPoints('marker4');
        });

        marker4.addEventListener('markerLost', function() {
            // actionButton4.style.display = 'none'; // Hide button when marker is lost
            correctMarkersCount--; // Decrement counter
            markerCounter.innerText = `Soaaln betul: ${correctMarkersCount}`; // Update display
            console.log('Marker 4 lost!');
        });
        
    </script>
</body>
</html>