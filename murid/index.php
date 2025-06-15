<?php $location_index = ".."; include('../components/head.php');?>

<body>
    <main class="dankbg-plrimary-200">
        <?php $location_index = ".."; include('../components/murid/nav.php');?>
        
        <section>
            
            <?php 

                $murid_value = decryptUser($_SESSION['EksTabaUserHash'], $secret_key);
                $id_murid = $murid_value['id_user'];

                $check_murid_info_sql = $connect->prepare("SELECT info_murid FROM murid WHERE id_murid = :id_murid");
                $check_murid_info_sql->execute([
                    ":id_murid" => $id_murid
                ]);
                $check_murid_info = $check_murid_info_sql->fetchColumn();

                if($check_murid_info == null || trim($check_murid_info) === ''){
                    echo '<script>setTimeout(function() {window.location.href = "'. $location_index.'/murid/account/guru.php"}, 0);</script>';
                }

                
                $murid_value = decryptUser($_SESSION['EksTabaUserHash'], $secret_key);
                $id_murid = $murid_value['id_user'];

                $murid_sql = $connect->prepare("SELECT * FROM murid WHERE id_murid = ?");
                $murid_sql->execute([$id_murid]);
                $murid = $murid_sql->fetch(PDO::FETCH_ASSOC);
            ?>

            <center>
                <h1 class="font-bold text-white text-3xl pt-10">Hi <?php echo htmlspecialchars(ucfirst($murid['nama_murid']))?></h1>

                <form method="get" action="./kuiz/enter.php" class="max-w-md mx-auto pt-10 danktext-white p-4">   
                    <label for="default-search" class="mb-2 text-sm font-medium  sr-only text-white">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-secondary-500 danktext-secondary-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="text" name="kod_kuiz" id="default-search" class="block w-full p-4 ps-10 text-sm text-secondary-900 border border-secondary-300 rounded-lg bg-secondary-50 focus:ring-primary-500 focus:border-primary-500 dankbg-secondary-700 dankborder-secondary-600 dankplaceholder-secondary-400 danktext-white dankfocus:ring-primary-500 dankfocus:border-primary-500" placeholder="Masukkan Kod Kuiz..." required />
                        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dankbg-primary-600 dankhover:bg-primary-700 dankfocus:ring-primary-800">Masuk</button>
                    </div>
                </form>

                <div class="max-w-4xl">
                    <br><br>
                    <?php $location_index = ".."; include('../components/murid/kuiz-selesai.php')?>
                    <br><br>
                </div>

            </center>

        </section>

    </main>

    <?php $location_index = ".."; include('../components/footer.php')?>

</body>
</html>