<?php 

    if(!isset($_GET['id_kelas'])){
        header("Location:./");
    }

?>

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
                    include('../../backend/function/system.php');

                    $id_kelas = validateInput($_GET['id_kelas']);

                    $kelas_sql = $connect->prepare("SELECT * FROM kelas WHERE id_kelas = ?");
                    $kelas_sql->execute([$id_kelas]);
                ?>

                

                
            </center>

        </section>

    </main>

    <script>
        if (document.getElementById("default-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#default-table", {
                searchable: false,
                perPageSelect: false
            });
        }
    </script>

    <?php $location_index = "../.."; include('../../components/footer.php')?>

</body>
</html>