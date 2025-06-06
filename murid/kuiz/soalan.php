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

// markah 
// $_SESSION['markah'] = 0;

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

    // cari markah
    $cari_markah_sql = $connect->prepare("SELECT markah_murid FROM murid WHERE id_murid = :id_murid");
    $cari_markah_sql->execute([
        ":id_murid"=> $hasil_kuiz['id_murid']
    ]);
    $cari_markah = $cari_markah_sql->fetch(PDO::FETCH_ASSOC);

    $set_markah = 0;
    if($cari_markah['markah_murid'] + $_SESSION['markah'] >= 0){
        $set_markah = $cari_markah['markah_murid'] + $_SESSION['markah'] + 1;
    }

    // update markah
    $update_markah_sql = $connect->prepare("UPDATE murid SET markah_murid = :markah_murid WHERE id_murid = :id_murid");
    $update_markah_sql->execute([
        ":markah_murid" => $set_markah,
        ":id_murid" => $hasil_kuiz['id_murid']
    ]);

    echo '<script>setTimeout(function() {window.location.href = "./selesai.php?id_hasil='. $id_hasil .'"}, 0);</script>';
}
$_SESSION['start'] = false;

// echo "session markah";
// echo $_SESSION['markah'];
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

                    <div class="max-w-3xl flex items-center p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50" role="alert">
                        <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <!-- <span class="sr-only">Info</span> -->
                        <div>
                            <span class="font-medium"></span>Berdasarkan ayat dibawah, sila pilih tanda baca yang betul. 
                        </div>
                    </div>
                    <div class="danktext-white block max-w-sm p-6 bg-white border border-secondary-200 rounded-lg shadow-sm hover:bg-secondary-100 dankbg-secondary-800 dankborder-secondary-700 dankhover:bg-secondary-700">

                    <!-- add :  -->
                        <h2 class="danktext-white text-xl font-bold mb-4"><?php echo $currentQuestion['teks_soalan']; ?></h2>
                        <form method="POST" id="quiz-form">
                            <?php foreach ($currentQuestion['options'] as $index => $option): ?>
                                <button type="submit" name="answer" value="<?php echo $index; ?>" 
                                    class="w-full p-2 mb-2 text-left rounded-lg 
                                    <?php 
                                    if (isset($_SESSION['last_answer'])) {
                                        if ($_SESSION['last_answer'] == 'correct' && $index == $_SESSION['last_correct']) {
                                            echo 'correct';
                                            $_SESSION['markah']+= 1;
                                        } elseif ($_SESSION['last_answer'] == 'incorrect' && $index == $_SESSION['last_selected']) {
                                            echo 'incorrect';
                                            $_SESSION['markah']-= 1;
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