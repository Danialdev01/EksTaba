<?php $location_index = "../.."; include('../../components/head.php');?>

<body>
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
                
                <div class="murid-container max-w-4xl p-5 pt-20">
                    <h2 class="text-4xl font-extrabold dark:text-white">Markah Tertinggi</h2>
                    <br>
                    <br><br>
                    <table id="search-table" class="">
                        <thead>
                            <tr>
                                <th>
                                    <span class="flex items-center">
                                        No
                                    </span>
                                </th>
                                <th>
                                    <span class="flex items-center">
                                        Nama
                                    </span>
                                </th>
                                <th>
                                    <span class="flex items-center">
                                        Markah
                                    </span>
                                </th>
                                <th>
                                    <span class="flex items-center">
                                        Bil Kuiz 
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i = 1;$murid = $murid_sql->fetch(PDO::FETCH_ASSOC);$i++){?>
                                <tr>
                                    <td><?php echo $i?></td>
                                    <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white"><?php echo htmlspecialchars($murid['nama_murid'])?></td>
                                    <td><?php echo $murid['markah_murid']?></td>

                                    <?php 
                                        $hasil_kuiz_sql = $connect->prepare("SELECT * FROM hasil_kuiz WHERE id_murid = ?");
                                        $hasil_kuiz_sql->execute([$murid['id_murid']]);

                                        if($hasil_kuiz_sql->rowCount() > 0){

                                            $bil_hasil = 0;
                                            while($hasil_kuiz = $hasil_kuiz_sql->fetch(PDO::FETCH_ASSOC)){
                                                $bil_hasil++;
                                            }
                                        }
                                        else{
                                            $bil_hasil = 0;
                                        }

                                    ?>
                                    <td><?php echo $bil_hasil ?></td>
                                </tr>
                            <?php };?>
                        </tbody>
                    </table>
                </div>

            </center>

        </section>

    </main>

    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                sortable: false
            });
        }
    </script>

    <?php $location_index = "../.."; include('../../components/footer.php')?>

</body>
</html>