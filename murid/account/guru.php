<?php $location_index = "../.."; include('../../components/head.php');?>

<body>
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
                <!-- Modal toggle -->
                <br><br>
                <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                Pilih Guru Pembimbing
                </button>
            </center>    

            <!-- Main modal -->
            <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Sign in to our platform
                            </h3>
                            <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5">
                            <form class="space-y-4" action="../../backend/murid.php" method="post">
                                <input type="hidden" name="token" value="<?php echo $token?>">
                                <input type="hidden" name="id_murid" value="<?php echo $id_murid?>">
                                <div class="mb-5">
                                    <select id="id_guru" name="id_guru" class="bg-secondary-50 border border-secondary-300 text-secondary-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dankbg-secondary-700 dankborder-secondary-600 dankplaceholder-secondary-400 danktext-white dankfocus:ring-primary-500 dankfocus:border-primary-500">
                                        <option selected value="0">Pilih Nama Guru</option>
                                        <?php 
                                            $guru_sql = $connect->prepare("SELECT nama_guru, id_guru FROM guru WHERE status_guru = 1");
                                            $guru_sql->execute();

                                            while($guru = $guru_sql->fetch(PDO::FETCH_ASSOC)){
                                                ?>
                                                <option value="<?php echo $guru['id_guru']?>"><?php echo $guru['nama_guru']?></option>
                                                <?php
                                            }

                                        ?>
                                    </select>
                                </div>
                                <button type="submit" name="pilih_guru" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Pilih Guru</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div> 


            <!-- <br><br>
            <center>
                <div class="max-w-4xl">
                    <?php $location_index = "../.."; include('../../components/murid/kuiz-selesai.php')?>
                </div>
            </center> -->
            <br>
        </section>

    </main>

    <?php $location_index = "../.."; include('../../components/footer.php')?>

</body>
</html>