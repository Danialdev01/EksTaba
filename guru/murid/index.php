<?php $location_index = "../.."; include('../../components/head.php');?>

<body>
    <main class="dankbg-plrimary-200">
        <?php $location_index = "../.."; include('../../components/guru/nav.php');?>

        <section>

            <?php 
                $guru_value = decryptUser($_SESSION['EksTabaUserHash'], $secret_key);
                $id_guru = $guru_value['id_user'];

                $guru_sql = $connect->prepare("SELECT * FROM guru WHERE id_guru = ?");
                $guru_sql->execute([$id_guru]);
                $guru = $guru_sql->fetch(PDO::FETCH_ASSOC);
            ?>

            <center>
                <?php 

                    $_SESSION['peratus'] = NULL;
                    $kuiz_sql = $connect->prepare("SELECT * FROM kuiz WHERE id_guru = ? AND status_kuiz = 1");
                    $kuiz_sql->execute([$id_guru]);
                ?>

                <?php include('../../components/guru/murid-guru-table.php')?>

            </center>

        </section>

    </main>

    <?php $location_index = "../.."; include('../../components/footer.php')?>

</body>
</html>