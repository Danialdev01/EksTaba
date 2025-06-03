<?php

    if(!isset($_GET['kod_kuiz'])){
        header("Location:../");
    }

    ?>

<?php $location_index = "../.."; include('../../components/head.php');?>

<?php 
$_SESSION['current_question_index'] = 0;
$_SESSION['start'] = true;
$_SESSION['answers_data'] = NULL;
$_SESSION['questions'] = NULL;
$_SESSION['index_answering'] = 0;
$_SESSION['markah'] = 0;
?>

<body>
    <main class="dankbg-plrimary-200">
        <?php $location_index = "../.."; include('../../components/murid/nav.php');?>

        <section>

            <?php 
                $murid_value = decryptUser($_SESSION['EksTabaUserHash'], $secret_key);
                $id_murid = $murid_value['id_user'];

                $murid_sql = $connect->prepare("SELECT * FROM murid WHERE id_murid = ?");
                $murid_sql->execute([$id_murid]);
                $murid = $murid_sql->fetch(PDO::FETCH_ASSOC);

                $kod_kuiz = validateInput($_GET['kod_kuiz']);

                $kuiz_sql = $connect->prepare("SELECT * FROM kuiz WHERE kod_kuiz = ?");
                $kuiz_sql->execute([$kod_kuiz]);
                $kuiz = $kuiz_sql->fetch(PDO::FETCH_ASSOC);

                if($kuiz['status_kuiz'] != 1){
                    echo '<script>setTimeout(function() {window.location.href = "./"}, 0);</script>';
                }

            ?>

            <center>

                <div class="container pt-20">
                    <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-secondary-900 md:text-5xl lg:text-6xl danktext-white"><?php echo htmlspecialchars($kuiz['nama_kuiz'])?></h1>

                    <form class="max-w-sm mx-auto text-left pt-5">
                      <div class="mb-5">

                        <?php 
                            $guru_sql = $connect->prepare("SELECT * FROM guru WHERE id_guru = ?");
                            $guru_sql->execute([$kuiz['id_guru']]);
                            $guru = $guru_sql->fetch(PDO::FETCH_ASSOC);
                        ?>

                        <label for="nama_guru" class="block mb-2 text-sm font-medium text-secondary-900 danktext-white">Nama Guru: </label>
                        <input type="text" id="nama_guru" name="nama_guru" disabled class="shadow-xs bg-secondary-50 border border-secondary-300 text-secondary-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dankbg-secondary-700 dankborder-secondary-600 dankplaceholder-secondary-400 danktext-white dankfocus:ring-primary-500 dankfocus:border-primary-500 dankshadow-xs-light" placeholder="guru" value="<?php echo htmlspecialchars(ucfirst($guru['nama_guru']))?>" />
                      </div>
                    </form>

                    <br><br>
                    <form action="../../backend/kuiz.php" method="post">

                        <input type="hidden" name="token" value="<?php echo $token?>">
                        <input type="hidden" name="id_kuiz" value="<?php echo $kuiz['id_kuiz']?>">
                        <input type="hidden" name="id_murid" value="<?php echo $murid['id_murid']?>">

                        <button type="submit" name="enter_kuiz" class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dankfocus:ring-primary-900">
                            Sedia
                            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </button>

                    </form>

                </div>

            </center>

        </section>

    </main>

    <?php $location_index = "../.."; include('../../components/footer.php')?>

</body>
</html>