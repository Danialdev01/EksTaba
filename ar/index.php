<!DOCTYPE html>
<html>
<head>
    <title>AR Card Game with Multiple Markers</title>
    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
    <script src="https://cdn.rawgit.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script>
</head>
<body style="margin: 0; overflow: hidden;">
    <a-scene embedded arjs>
        <!-- Marker 1 -->
        <a-marker id="marker1" type="pattern" url="../src/assets/marker/pattern/pattern-FL.patt">
            <a-entity geometry="primitive: box" material="color: red;"></a-entity>
        </a-marker>

        <!-- Marker 2 -->
        <a-marker id="marker2" type="pattern" url="../src/assets/marker/pattern/pattern-LS.patt">
            <a-entity geometry="primitive: sphere" material="color: blue;"></a-entity>
        </a-marker>

        <!-- Marker 3 -->
        <a-marker id="marker3" type="pattern" url="../src/assets/marker/pattern/pattern-KH.patt">
            <a-entity geometry="primitive: sphere" material="color: blue;"></a-entity>
        </a-marker>

        <a-marker id="marker4" type="pattern" url="../src/assets/marker/pattern/pattern-PL.patt">
            <a-entity geometry="primitive: sphere" material="color: blue;"></a-entity>
        </a-marker>

        <a-marker id="marker4" type="pattern" url="../src/assets/marker/pattern/pattern-TD.patt">
            <a-entity geometry="primitive: sphere" material="color: blue;"></a-entity>
        </a-marker>

        <!-- Marker 3 -->
        <!-- <a-marker id="marker3" type="pattern" url="../src/assets/marker/pattern/pattern-SL.patt">
            <a-entity geometry="primitive: cylinder" material="color: green;"></a-entity>
        </a-marker>  -->

        <a-entity camera></a-entity>
    </a-scene>

    <script>
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
            .then(data => {
                console.log('Success:', data);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }

        // Marker 1
        const marker1 = document.querySelector('#marker1');
        marker1.addEventListener('markerFound', function() {
            console.log('Marker 1 found!');
            sendPoints('marker1');
        });

        marker1.addEventListener('markerLost', function() {
            console.log('Marker 1 lost!');
        });

        // Marker 2
        const marker2 = document.querySelector('#marker2');
        marker2.addEventListener('markerFound', function() {
            console.log('Marker 2 found!');
            sendPoints('marker2');
        });

        marker2.addEventListener('markerLost', function() {
            console.log('Marker 2 lost!');
        });

        // Marker 3
        const marker3 = document.querySelector('#marker3');
        marker3.addEventListener('markerFound', function() {
            console.log('Marker 3 found!');
            sendPoints('marker3');
        });

        marker3.addEventListener('markerLost', function() {
            console.log('Marker 3 lost!');
        });
    </script>
</body>
</html>