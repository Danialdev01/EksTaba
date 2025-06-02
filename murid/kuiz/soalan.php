<?php 

if(!isset($_GET['id_hasil'])){
    header("Location:../");
}

?>
<?php $location_index = "../.."; include('../../components/head.php');?>

<?php

$questions = $_SESSION['questions'];

// var_dump($questions);

// Get the current question index
$currentQuestionIndex = isset($_SESSION['current_question_index']) ? $_SESSION['current_question_index'] : 0;

if(!isset($_SESSION['current_question_index'])){
    $_SESSION['current_question_index'] = 0;
}

// echo $correctOption = $questions[$currentQuestionIndex]['correct'];
// Check if the user submitted an answer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedOption = $_POST['answer'];
    $correctOption = $questions[$currentQuestionIndex]['correct'];
    $_SESSION['index_answering']++;

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

// echo $_SESSION['index_answering'];
// echo "<br>";
// echo count($questions);

if((count($questions) <= $_SESSION['index_answering']) && $_SESSION['start'] == false){
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

    // echo "bertukar";
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
    <main class="dankbg-plrimary-200">
        <?php $location_index = "../.."; include('../../components/murid/nav.php');?>

        <section>

            <?php 
                $murid_value = decryptUser($_SESSION['EksTabaUserHash'], $secret_key);
                $id_murid = $murid_value['id_user'];

                $murid_sql = $connect->prepare("SELECT * FROM murid WHERE id_murid = ? ORDER BY markah_murid DESC");
                $murid_sql->execute([$id_murid]);

            ?>

            <center>
                
                <div class="pt-20">

                    <div class="danktext-white block max-w-sm p-6 bg-white border border-secondary-200 rounded-lg shadow-sm hover:bg-secondary-100 dankbg-secondary-800 dankborder-secondary-700 dankhover:bg-secondary-700">
                        <h2 class="danktext-white text-xl font-bold mb-4"><?php echo $currentQuestion['teks_soalan']; ?></h2>
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
                                        echo 'bg-primary-500 text-white';
                                    }
                                    ?>" id="option-<?php echo $index; ?>">
                                    <?php echo $option; ?>
                                </button>
                            <?php endforeach; ?>
                        </form>
                        <?php if (isset($_SESSION['last_answer'])): ?>
                            <p class="mt-4 text-center text-secondary-600">
                                <?php echo $_SESSION['last_answer'] == 'correct' ? 'Betul !' : 'Salah !'; ?>
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
    $_SESSION['peratus'] = null;
}
?>