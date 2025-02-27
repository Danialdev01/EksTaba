<?php 

if(!isset($_GET['id_hasil'])){
    header("Location:../");
}

?>
<?php $location_index = "../.."; include('../../components/head.php');?>

<?php

// Sample questions and answers
$questions = [
    [
        'id_soalan' => 1,
        'teks_soalan' => 'Antara contoh teknologi hijau ialah panel solar(_) kereta elektrik dan tenaga nuklear',
        'options' => ['.', ',', '?', '!'],
        'correct' => 1 // Index of the correct answer
    ],
    [
        'id_soalan' => 2,
        'teks_soalan' => 'Teknologi hijau memperluas peluang kita untuk hidup lebih lestari dan mengurangkan bebanan alam sekitar(_)',
        'options' => ['.', '?', '!', ','],
        'correct' => 0
    ],
    [
        'id_soalan' => 3,
        'teks_soalan' => 'Adakah teknologi hijau baik untuk alam sekitar (_)',
        'options' => ['.', '!', '?', ','],
        'correct' => 2
    ]
];

// Get the current question index
$currentQuestionIndex = isset($_SESSION['current_question_index']) ? $_SESSION['current_question_index'] : 0;

if(!isset($_SESSION['current_question_index'])){
    $_SESSION['current_question_index'] = 0;
}

// Check if the user submitted an answer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedOption = $_POST['answer'];
    $correctOption = $questions[$currentQuestionIndex]['correct'];

    // Store the result in the session
    $_SESSION['last_answer'] = ($selectedOption == $correctOption) ? 'correct' : 'incorrect';
    $_SESSION['last_selected'] = $selectedOption;
    $_SESSION['last_correct'] = $correctOption;

    $_SESSION['answers_data'][$currentQuestionIndex] = [
        "id_soalan" => $questions[$currentQuestionIndex]['id_soalan'],
        "selected" => $selectedOption,
        "correct" => $correctOption
    ];

    // Move to the next question
    $_SESSION['current_question_index'] = ($currentQuestionIndex + 1) % count($questions);
}

// Get the current question
$currentQuestion = $questions[$currentQuestionIndex];

// echo count($questions);

if(!(count($questions) <= ($_SESSION['current_question_index'] + 2)) && $_SESSION['start'] == false){
    $complete_answer = $_SESSION['answers_data'];
    
    // FIXME validate
    $id_hasil = $_GET['id_hasil'];

    $hasil_kuiz_sql = $connect->prepare("SELECT * FROM hasil_kuiz WHERE id_hasil_kuiz = ?");
    $hasil_kuiz_sql->execute([$id_hasil]);
    $hasil_kuiz = $hasil_kuiz_sql->fetch(PDO::FETCH_ASSOC);
    
    // add
    $markah_hasil_murid = json_encode($complete_answer);
    $update_hasil_sql = $connect->prepare("UPDATE hasil_kuiz SET markah_hasil_murid = ? WHERE id_hasil_kuiz = ?");
    $update_hasil_sql->execute([
        $markah_hasil_murid,
        $id_hasil
    ]);

    echo '<script>setTimeout(function() {window.location.href = "./selesai.php?id_hasil='. $id_hasil .'"}, 0);</script>';
}
$_SESSION['start'] = false;

// echo $_SESSION['current_question_index'];
?>
<body>
    <style>
        .correct { background-color: #4CAF50; }
        .incorrect { background-color: #F44336; }
    </style>
    <main class="dark:bg-gray-900">
        <?php $location_index = "../.."; include('../../components/murid/nav.php');?>

        <section class="bg-white dark:bg-gray-900">

            <?php 
                $murid_value = decryptUser($_SESSION['EksTabaUserHash'], $secret_key);
                $id_murid = $murid_value['id_user'];

                $murid_sql = $connect->prepare("SELECT * FROM murid WHERE id_murid = ? ORDER BY markah_murid DESC");
                $murid_sql->execute([$id_murid]);

            ?>

            <center>
                
                <div class="pt-20">

                    <div class="dark:text-white block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                        <h2 class="dark:text-white text-xl font-bold mb-4"><?php echo $currentQuestion['teks_soalan']; ?></h2>
                        <form method="POST" id="quiz-form">
                            <?php foreach ($currentQuestion['options'] as $index => $option): ?>
                                <button type="submit" name="answer" value="<?php echo $index; ?>" 
                                    class="w-full p-2 mb-2 text-left rounded-lg 
                                    <?php 
                                    if (isset($_SESSION['last_answer'])) {
                                        if ($_SESSION['last_answer'] == 'correct' && $index == $_SESSION['last_correct']) {
                                            echo 'correct';
                                        } elseif ($_SESSION['last_answer'] == 'incorrect' && $index == $_SESSION['last_selected']) {
                                            echo 'incorrect';
                                        }
                                    } else {
                                        echo 'bg-blue-500 text-white';
                                    }
                                    ?>" id="option-<?php echo $index; ?>">
                                    <?php echo $option; ?>
                                </button>
                            <?php endforeach; ?>
                        </form>
                        <?php if (isset($_SESSION['last_answer'])): ?>
                            <p class="mt-4 text-center text-gray-600">
                                <?php echo $_SESSION['last_answer'] == 'correct' ? 'Correct!' : 'Wrong!'; ?>
                            </p>
                            <script>
                                // Wait for 5 seconds before redirecting
                                setTimeout(function() {
                                    // Clear button backgrounds
                                    const buttons = document.querySelectorAll('button');
                                    buttons.forEach(button => {
                                        button.classList.remove('correct', 'incorrect');
                                    });
                                    // Redirect to the same page to load the next question
                                    window.location.href = 'soalan.php?id_hasil=<?php echo $_GET['id_hasil']?>';
                                }, 1000);
                            </script>
                        <?php endif; ?>
                    </div>
                </div>
            </center>

        </section>

    </main>

    <?php $location_index = "../.."; include('../../components/footer.php')?>

</body>
</html>

<?php
// Clear session variables after displaying the result
if (isset($_SESSION['last_answer'])) {
    unset($_SESSION['last_answer']);
    unset($_SESSION['last_selected']);
    unset($_SESSION['last_correct']);
}
?>