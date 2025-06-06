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

            <div class="new-kuiz pt-20">

                <form class="max-w-sm mx-auto" method="post" action="../../backend/kuiz.php">

                    <input type="hidden" name="token" value="<?php echo $token?>">
                    <input type="hidden" name="id_guru" value="<?php echo $guru['id_guru']; ?>">
                    <input type="hidden" name="tarikh_tamat_kuiz" value="NULL">

                    <div class="max-w-sm mx-auto">

                        <div class="mb-5">
                            <label for="nama_kuiz" class="block mb-2 text-sm font-medium text-secondary-900 danktext-white">Nama Kuiz</label>
                            <input type="text" name="nama_kuiz" class="shadow-xs bg-secondary-50 border border-secondary-300 text-secondary-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dankbg-secondary-700 dankborder-secondary-600 dankplaceholder-secondary-400 danktext-white dankfocus:ring-primary-500 dankfocus:border-primary-500 dankshadow-xs-light" required />
                        </div>

                        <div class="mb-5">
                            <label for="pengenalan_kuiz" class="block mb-2 text-sm font-medium text-secondary-900 danktext-white">Pengenalan tentang Kuiz (Tema)</label>
                            <input type="text" name="pengenalan_kuiz" class="shadow-xs bg-secondary-50 border border-secondary-300 text-secondary-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dankbg-secondary-700 dankborder-secondary-600 dankplaceholder-secondary-400 danktext-white dankfocus:ring-primary-500 dankfocus:border-primary-500 dankshadow-xs-light" required />
                        </div>

                        <div class="mb-5">
                            <select id="jenis_kuiz" name="jenis_kuiz" class="bg-secondary-50 border border-secondary-300 text-secondary-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dankbg-secondary-700 dankborder-secondary-600 dankplaceholder-secondary-400 danktext-white dankfocus:ring-primary-500 dankfocus:border-primary-500">
                                <option selected value="0">Pilih Jenis Kuiz</option>
                                <option value="1">Objektif</option>
                                <option value="2">Isi Tempat Kosong</option>
                            </select>
                        </div>

                        <input type="hidden" name="id_kelas" value="0">
                        <!-- <div class="mb-5">
                            <select id="id_kelas" name="id_kelas" class="bg-secondary-50 border border-secondary-300 text-secondary-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dankbg-secondary-700 dankborder-secondary-600 dankplaceholder-secondary-400 danktext-white dankfocus:ring-primary-500 dankfocus:border-primary-500">
                                <option selected value="-1">Pilih Kelas Yang Terlibat</option>
                                <option value="0">Tiada</option>
                                
                                <?php
                                    $kelas_guru_sql = $connect->prepare("SELECT * FROM kelas WHERE id_guru = ?");
                                    $kelas_guru_sql->execute([$id_guru]);
                                ?>

                                <?php while($kelas_guru = $kelas_guru_sql->fetch(PDO::FETCH_ASSOC)){?>

                                    <option value="<?php echo $kelas_guru['id_kelas']?>"><?php echo htmlspecialchars($kelas_guru['tajuk_kelas'])?></option>


                                <?php }?>
                            </select>
                        </div> -->

                        <div class="mb-5">

                            <label for="quantity-input" class="block mb-2 text-sm font-medium text-secondary-900 danktext-white">Pilih Bilangan Soalan :</label>
                            <div class="relative flex items-center max-w-[8rem]">
                                <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input" class="bg-secondary-100 dankbg-secondary-700 dankhover:bg-secondary-600 dankborder-secondary-600 hover:bg-secondary-200 border border-secondary-300 rounded-s-lg p-3 h-11 focus:ring-secondary-100 dankfocus:ring-secondary-700 focus:ring-2 focus:outline-none">
                                    <svg class="w-3 h-3 text-secondary-900 danktext-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                    </svg>
                                </button>
                                <input type="text" name="bil_soalan_kuiz" id="quantity-input" value="3" data-input-counter data-input-counter-min="1" data-input-counter-max="15" aria-describedby="helper-text-explanation" class="bg-secondary-50 border-x-0 border-secondary-300 h-11 text-center text-secondary-900 text-sm focus:ring-primary-500 focus:border-primary-500 block w-full py-2.5 dankbg-secondary-700 dankborder-secondary-600 dankplaceholder-secondary-400 danktext-white dankfocus:ring-primary-500 dankfocus:border-primary-500" placeholder="999" required />
                                <button type="button" id="increment-button" data-input-counter-increment="quantity-input" class="bg-secondary-100 dankbg-secondary-700 dankhover:bg-secondary-600 dankborder-secondary-600 hover:bg-secondary-200 border border-secondary-300 rounded-e-lg p-3 h-11 focus:ring-secondary-100 dankfocus:ring-secondary-700 focus:ring-2 focus:outline-none">
                                    <svg class="w-3 h-3 text-secondary-900 danktext-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                                    </svg>
                                </button>
                            </div>
                            <!-- <p id="helper-text-explanation" class="mt-2 text-sm text-secondary-500 danktext-secondary-400">Please select a 5 digit number from 0 to 9.</p> -->
                        </div>
                        

                        <button type="submit" name="new_kuiz" class="flex justify-center block text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dankbg-primary-600 dankhover:bg-primary-700 dankfocus:ring-primary-800">
                            <!-- <svg class="me-1 -ms-1 w-5 h-" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg> -->
                            Hasilkan Kuiz
                        </button>

                    </div>

                </form>
            </div>

        </section>

    </main>

    <?php $location_index = "../.."; include('../../components/footer.php')?>

</body>
</html>