<?php

    if(!isset($_GET['id_kuiz'])){

        header("Location:../");
    }

?>

<?php $location_index = "../.."; include('../../components/head.php');?>

<body>
    <main class="dark:bg-gray-900">
        <?php $location_index = "../.."; include('../../components/guru/nav.php');?>

        <section class="bg-white dark:bg-gray-900">

            <?php 
                require_once('../../backend/function/system.php');

                $guru_value = decryptUser($_SESSION['EksTabaUserHash'], $secret_key);
                $id_guru = $guru_value['id_user'];

                $guru_sql = $connect->prepare("SELECT * FROM guru WHERE id_guru = ?");
                $guru_sql->execute([$id_guru]);
                $guru = $guru_sql->fetch(PDO::FETCH_ASSOC);

                $id_kuiz = validateInput($_GET['id_kuiz']);
                $kuiz_sql = $connect->prepare("SELECT * FROM kuiz WHERE id_kuiz = ?");
                $kuiz_sql->execute([$id_kuiz]);
                $kuiz = $kuiz_sql->fetch(PDO::FETCH_ASSOC);

            ?>

            <center>

                <div class="pt-20 text-left kuiz-container">

                    <form class="max-w-md mx-auto">
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="nama_kuiz" id="nama_kuiz" value="<?php echo $kuiz['nama_kuiz'] ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="nama_kuiz" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Kuiz</label>
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="pengenalan_kuiz" id="pengenalan_kuiz" value="<?php echo $kuiz['pengenalan_kuiz']?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <label for="pengenalan_kuiz" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pengenalan Kuiz (Tema)</label>
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <select  disabled id="jenis_kuiz" name="jenis_kuiz" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="0">Pilih Jenis Kuiz</option>
                                <option <?php echo $kuiz['jenis_kuiz'] == '1' ? 'selected' : '1'; ?> >Objektif</option>
                                <option <?php echo $kuiz['jenis_kuiz'] == '2' ? 'selected' : '2'; ?> >Isi tempat kosong</option>
                            </select>
                        </div>

                        <div class="soalan-kuiz-container pb-4">
                            
                            <?php

                                $soalan_kuiz_sql = $connect->prepare("SELECT * FROM soalan WHERE id_kuiz = ?");
                                $soalan_kuiz_sql->execute([$id_kuiz]);

                                while($soalan_kuiz = $soalan_kuiz_sql->fetch(PDO::FETCH_ASSOC)){
                                    ?>

                                        <div class="p-2">
                                            <div class="max-w-lg p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                                                <h5 class="mb-4 text-lg tracking-tight text-gray-900 dark:text-white"><?php echo htmlspecialchars($soalan_kuiz['teks_soalan'])?></h5>

                                                <div class="jawapan pb-3">
                                                    <?php 

                                                        $skema_jawapan_sql = $connect->prepare("SELECT * FROM skema_jawapan WHERE id_soalan = ?");
                                                        $skema_jawapan_sql->execute([$soalan_kuiz['id_soalan']]);
                                                        $skema_jawapan = $skema_jawapan_sql->fetch(PDO::FETCH_ASSOC);

                                                        $jawapan = json_decode($skema_jawapan['teks_jawapan'], true);

                                                    ?>
                                                    <div class="jawapan-betul pb-1">
                                                        <p class="text-black dark:text-white">Jawapan betul : 
                                                            <span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300"><?php echo $jawapan['jawapan_betul']?></span>
                                                        </p>
                                                    </div>
                                                    <div class="jawapan-salah">
                                                        <p class="text-black dark:text-white">Jawapan salah : 
                                                            <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300"><?php echo $jawapan['jawapan_salah_1']?></span>
                                                            <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300"><?php echo $jawapan['jawapan_salah_2']?></span>
                                                            <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300"><?php echo $jawapan['jawapan_salah_3']?></span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <?php $id_kuiz = $soalan_kuiz['id_kuiz']; $location_index = "../.."; include('../../components/modals/kemaskini-soalan-modal.php')?>
                                                <!-- <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p> -->
                                            </div>
                                        </div>


                                    <?php
                                }

                            ?>

                        </div>

                        <center>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Kemaskini</button>
                        </center>
                    </form>
                    <br>

                </div>

            </center>

        </section>

    </main>

    <?php $location_index = "../.."; include('../../components/footer.php')?>

</body>
</html>