<?php

    if(!isset($_GET['id_hasil'])){
        header("Location:../");
    }

?>

<?php $location_index = "../.."; include('../../components/head.php');?>

<body>
    <main class="dark:bg-gray-900">
        <?php $location_index = "../.."; include('../../components/murid/nav.php');?>

        <section class="bg-white dark:bg-gray-900">

            <?php 
                $murid_value = decryptUser($_SESSION['EksTabaUserHash'], $secret_key);
                $id_murid = $murid_value['id_user'];
                
                $murid_sql = $connect->prepare("SELECT * FROM murid WHERE id_murid = ?");
                $murid_sql->execute([$id_murid]);
                $murid = $murid_sql->fetch(PDO::FETCH_ASSOC);
                
                $id_hasil = validateInput($_GET['id_hasil']);
                $hasil_kuiz_sql = $connect->prepare("SELECT * FROM hasil_kuiz WHERE id_hasil_kuiz = ?");
                $hasil_kuiz_sql->execute([$id_hasil]);
                $hasil_kuiz = $hasil_kuiz_sql->fetch(PDO::FETCH_ASSOC);

                $kuiz_sql = $connect->prepare("SELECT * FROM kuiz WHERE id_kuiz = ?");
                $kuiz_sql->execute([$hasil_kuiz['id_kuiz']]);
                $kuiz = $kuiz_sql->fetch(PDO::FETCH_ASSOC);

            ?>

            <center>

                <div class="container pt-20">
                    <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white"><?php echo htmlspecialchars($kuiz['nama_kuiz'])?></h1>

                    <form class="max-w-sm mx-auto text-left pt-5">
                        <?php 
                            $guru_sql = $connect->prepare("SELECT * FROM guru WHERE id_guru = ?");
                            $guru_sql->execute([$kuiz['id_guru']]);
                            $guru = $guru_sql->fetch(PDO::FETCH_ASSOC);
                        ?>
                      <div class="mb-5">
                        <label for="nama_guru" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Murid : </label>
                        <input type="text" id="nama_guru" name="nama_guru" disabled class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light" placeholder="guru" value="<?php echo htmlspecialchars(ucfirst($murid['nama_murid']))?>" />
                      </div>
                      <div class="mb-5">
                        <label for="date_hasil" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tarikh Hasil : </label>
                        <!-- <input type="text" id="tarikh_hasil" name="nama_guru" disabled class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light" placeholder="guru" value="<?php echo htmlspecialchars(ucfirst($murid['nama_murid']))?>" /> -->
                         <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input id="datepicker-format" value="<?php echo $hasil_kuiz['created_date_hasil_kuiz']?>" datepicker datepicker-format="dd / mm / yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                      </div>
                    </form>

                    <br><br>

                    <h3 class="mb-4 text-2xl leading-none tracking-tight text-gray-900 md:text-3xl lg:text-4xl dark:text-white">Markah: <span class="font-extrabold">33%</span></h3>
                    <div class="max-w-4xl justify-center soalan-kuiz-container pb-4">
                        <?php

                            $soalan_kuiz_sql = $connect->prepare("SELECT * FROM soalan WHERE id_kuiz = ?");
                            $soalan_kuiz_sql->execute([$kuiz['id_kuiz']]);

                            while($soalan_kuiz = $soalan_kuiz_sql->fetch(PDO::FETCH_ASSOC)){
                                ?>

                                    <div class="p-2">
                                        <div class="text-left max-w-lg p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                                            <h5 class="mb-4 text-lg tracking-tight text-gray-900 dark:text-white"><?php echo htmlspecialchars($soalan_kuiz['teks_soalan'])?></h5>

                                            <div class="jawapan pb-3">
                                                <?php 

                                                    $skema_jawapan_sql = $connect->prepare("SELECT * FROM skema_jawapan WHERE id_soalan = ?");
                                                    $skema_jawapan_sql->execute([$soalan_kuiz['id_soalan']]);
                                                    $skema_jawapan = $skema_jawapan_sql->fetch(PDO::FETCH_ASSOC);

                                                    $jawapan = json_decode($skema_jawapan['teks_jawapan'], true);

                                                ?>
                                                <div class="jawapan-betul pb-1">
                                                    <p class="text-black dark:text-white">Jawapan pilihan : 
                                                        </p>
                                                    </div>
                                                    <div class="jawapan-salah">
                                                        <p class="text-black dark:text-white">Skema Jawapan : 
                                                        <span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300"><?php echo $jawapan['jawapan_betul']?></span>
                                                        <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300"><?php echo $jawapan['jawapan_salah_1']?></span>
                                                        <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300"><?php echo $jawapan['jawapan_salah_2']?></span>
                                                        <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300"><?php echo $jawapan['jawapan_salah_3']?></span>
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                <?php
                            }

                        ?>

                    </div>
                </div>

            </center>

        </section>

    </main>

    <?php $location_index = "../.."; include('../../components/footer.php')?>

</body>
</html>