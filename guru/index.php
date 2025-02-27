<?php $location_index = ".."; include('../components/head.php');?>

<body>
    <main class="dark:bg-gray-900">
        <?php $location_index = ".."; include('../components/guru/nav.php');?>

        <section class="bg-white dark:bg-gray-900">

            <?php 
                $guru_value = decryptUser($_SESSION['EksTabaUserHash'], $secret_key);
                $id_guru = $guru_value['id_user'];

                $guru_sql = $connect->prepare("SELECT * FROM guru WHERE id_guru = ?");
                $guru_sql->execute([$id_guru]);
                $guru = $guru_sql->fetch(PDO::FETCH_ASSOC);
            ?>

            <center>
                <h1 class="dark:text-white text-black text-2xl pt-10">Hi <?php echo htmlspecialchars(ucfirst($guru['nama_guru']))?></h1>

                <?php 
                    $kuiz_sql = $connect->prepare("SELECT * FROM kuiz WHERE id_guru = ?");
                    $kuiz_sql->execute([$id_guru]);
                ?>

                <?php $location_index = ".."; include('../components/guru/kuiz-table.php')?>

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

    <?php $location_index = ".."; include('../components/footer.php')?>

</body>
</html>