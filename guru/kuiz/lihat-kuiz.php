<?php

    if(!isset($_GET['id_kuiz'])){

        header("Location:../");
    }

?>

<?php $location_index = "../.."; include('../../components/head.php');?>

<body>
    <main class="dankbg-plrimary-200">
        <?php $location_index = "../.."; include('../../components/guru/nav.php');?>

        <section>

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

                <div class="pt-20 text-left kuiz-container lg:flex p-10 lg:p-0">

                    <div class="w-full lg:p-10">
                    <!-- <form method="post" action="../../backend/kuiz.php"> -->
                        <div class="container">
                            <center>
                                <div class="form-content text-left">
                                    <h4 class="text-2xl font-bold dark:text-white">Infomasi kuiz</h4>
                                    <br><br>

                                    <input type="hidden" name="token" value="<?php echo $token?>">
                                    <div class="relative z-0 w-full mb-5 group">
                                        <input type="text" name="nama_kuiz" id="nama_kuiz" value="<?php echo $kuiz['nama_kuiz'] ?>" class="block py-2.5 px-0 w-full text-sm text-secondary-900 bg-transparent border-0 border-b-2 border-secondary-300 appearance-none danktext-white dankborder-secondary-600 dankfocus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-600 peer" placeholder=" " required />
                                        <label for="nama_kuiz" class="peer-focus:font-medium absolute text-sm text-white danktext-secondary-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-primary-600 peer-focus:-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Kuiz</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-5 group">
                                        <input type="text" name="kod_kuiz" id="kod_kuiz" value="<?php echo strtoupper($kuiz['kod_kuiz'])?>" class="block py-2.5 px-0 w-full text-sm text-secondary-900 bg-transparent border-0 border-b-2 border-secondary-300 appearance-none danktext-white dankborder-secondary-600 dankfocus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-600 peer" placeholder=" " required />
                                        <label for="kod_kuiz" class="peer-focus:font-medium absolute text-sm text-white danktext-secondary-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-primary-600 peer-focus:-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Kod Kuiz</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-5 group">
                                        <input type="text" name="pengenalan_kuiz" id="pengenalan_kuiz" value="<?php echo $kuiz['pengenalan_kuiz']?>" class="block py-2.5 px-0 w-full text-sm text-secondary-900 bg-transparent border-0 border-b-2 border-secondary-300 appearance-none danktext-white dankborder-secondary-600 dankfocus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-600 peer" placeholder=" " required />
                                        <label for="pengenalan_kuiz" class="peer-focus:font-medium absolute text-sm text-white danktext-secondary-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-primary-600 peer-focus:-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pengenalan Kuiz (Tema)</label>
                                    </div>
            
                                    <div class="relative z-0 w-full mb-5 group">
                                        <select  disabled id="jenis_kuiz" name="jenis_kuiz" class="bg-secondary-50 border border-secondary-300 text-black text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dankbg-secondary-700 dankborder-secondary-600 dankplaceholder-secondary-400 danktext-white dankfocus:ring-primary-500 dankfocus:border-primary-500">
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
                                                        <div class="max-w-lg p-6 bg-primary-400 border border-secondary-200 rounded-lg shadow-sm dankbg-secondary-800 dankborder-secondary-700">
                                                            <h5 class="mb-4 text-lg tracking-tight text-white danktext-white"><?php echo $soalan_kuiz['teks_soalan']?></h5>
            
                                                            <div class="jawapan pb-3">
                                                                <?php 
            
                                                                    $skema_jawapan_sql = $connect->prepare("SELECT * FROM skema_jawapan WHERE id_soalan = ?");
                                                                    $skema_jawapan_sql->execute([$soalan_kuiz['id_soalan']]);
                                                                    $skema_jawapan = $skema_jawapan_sql->fetch(PDO::FETCH_ASSOC);
            
                                                                    $jawapan = json_decode($skema_jawapan['teks_jawapan'], true);
            
                                                                ?>
                                                                
                                                                <div class="jawapan-betul pb-1">
                                                                    <p class="text-white danktext-white">Jawapan betul : 
                                                                        <span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dankbg-green-900 danktext-green-300"><?php echo $jawapan_betul = $jawapan['jawapan_betul']?></span>
                                                                    </p>
                                                                </div>
                                                                <div class="jawapan-salah">
                                                                    <p class="text-white danktext-white">Jawapan salah : 
                                                                        <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dankbg-red-900 danktext-red-300"><?php echo $jawapan['jawapan_salah_1']?></span>
                                                                        <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dankbg-red-900 danktext-red-300"><?php echo $jawapan['jawapan_salah_2']?></span>
                                                                        <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dankbg-red-900 danktext-red-300"><?php echo $jawapan['jawapan_salah_3']?></span>
                                                                    </p>
                                                                </div>
                                                            </div>
            
                                                            <?php $id_soalan = $soalan_kuiz['id_soalan']; $jawapan_betul = $jawapan_betul; $location_index = "../.."; include('../../components/modals/kemaskini-soalan-modal.php')?>
                                                            <!-- <p class="mb-3 font-normal text-secondary-700 danktext-secondary-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p> -->
                                                        </div>
                                                    </div>
            
            
                                                <?php
                                            }
            
                                        ?>
            
                                        <center>
                                            <a href="../">
                                                <button type="submit" name="kemaskini_kuiz" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dankbg-primary-600 dankhover:bg-primary-700 dankfocus:ring-primary-800">Simpan</button>
                                            </a>
                                        </center>
                                    </div>
                                </div>
                            </center>
                        </div>
                        
                        <br>
                    <!-- </form> -->
                        <form action="../../backend/kuiz.php" method="post">
                            <center>
                                <input type="hidden" name="token" value="<?php echo $token?>">
                                <input type="hidden" name="id_kuiz" value="<?php echo $id_kuiz?>">
                                <button name="hapus_kuiz"  class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dankbg-primary-600 dankhover:bg-primary-700 dankfocus:ring-primary-800">Padam kuiz</button>
                            </center>
                        </form>
                    </div>
                    
                    <div class="chart w-full p-10">

                        
                        <h4 class="text-2xl font-bold text-white">Statistik murid</h4>

                        
                        <table id="default-table">
                            <thead>
                                <tr>
                                    <th>
                                        <span class="flex items-center">
                                            Nama murid
                                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                            </svg>
                                        </span>
                                    </th>
                                    <th data-type="date" data-format="YYYY/DD/MM">
                                        <span class="flex items-center">
                                            Tarikh 
                                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                            </svg>
                                        </span>
                                    </th>
                                    <th>
                                        <span class="flex items-center">
                                            Markah
                                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewbox="0 0 24 24">
                                                <path stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                            </svg>
                                        </span>
                                    </th>
                                    <th>
                                        <span class="flex items-center">
                                            Lihat
                                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewbox="0 0 24 24">
                                                <path stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                            </svg>
                                        </span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    
                                    $hasil_kuiz_sql = $connect->prepare("SELECT * FROM hasil_kuiz WHERE id_kuiz = :id_kuiz");
                                    $hasil_kuiz_sql->execute([
                                        ":id_kuiz" => $id_kuiz
                                    ]);

                                    while($hasil_kuiz = $hasil_kuiz_sql->fetch(PDO::FETCH_ASSOC)){

                                        $hasil_murid_sql = $connect->prepare("SELECT * FROM murid WHERE id_murid = :id_murid");
                                        $hasil_murid_sql->execute([
                                            ":id_murid" => $hasil_kuiz['id_murid']
                                        ]);
                                        $hasil_murid = $hasil_murid_sql->fetch(PDO::FETCH_ASSOC);

                                        ?>

                                        <tr>
                                            <td class="font-medium whitespace-nowrap text-white"><?php echo $hasil_murid['nama_murid']?></td>
                                            <td class="text-white"><?php echo $hasil_kuiz['created_date_hasil_murid']?></td>

                                            <?php 

                                                $bli_soalan = 0;
                                                $betul = 0;
                                                $soalan_kuiz_sql = $connect->prepare("SELECT * FROM soalan WHERE id_kuiz = ?");
                                                $soalan_kuiz_sql->execute([$kuiz['id_kuiz']]);
                                                while($soalan_kuiz = $soalan_kuiz_sql->fetch(PDO::FETCH_ASSOC)){
                                                    
                                                    $bli_soalan++;

                                                    $skema_jawapan_sql = $connect->prepare("SELECT * FROM skema_jawapan WHERE id_soalan = ?");
                                                    $skema_jawapan_sql->execute([$soalan_kuiz['id_soalan']]);
                                                    $skema_jawapan = $skema_jawapan_sql->fetch(PDO::FETCH_ASSOC);

                                                    $jawapan = json_decode($skema_jawapan['teks_jawapan'], true);

                                                    $hasil_murid = json_decode($hasil_kuiz['markah_hasil_murid'], true);
                                                    // var_dump($hasil_murid);
                                                    $jawapan_jenis = "Tidak dijawab";

                                                    // Check if $hasil_murid is an array and if the index exists
                                                    if(is_array($hasil_murid) && isset($hasil_murid[$bli_soalan - 1])) {
                                                        if(isset($hasil_murid[$bli_soalan - 1]['selected'])) {
                                                            $selected = $hasil_murid[$bli_soalan - 1]['selected'];
                                                            
                                                            if($selected == 0){$jawapan_jenis = ".";}
                                                            elseif($selected == 1){$jawapan_jenis = "?";}
                                                            elseif($selected == 2){$jawapan_jenis = "!";}
                                                            elseif($selected == 3){$jawapan_jenis = ",";}
                                                            else{$jawapan_jenis = "salah";}
                                                        }
                                                    }

                                                    if($jawapan_jenis == $jawapan['jawapan_betul']){
                                                        $betul++;
                                                    }
                                                }

                                            ?>
                                            <td class="text-white"><?php echo round(($betul / $bli_soalan) * 100);?>%</td>
                                            <td>
                                                <a href="./selesai.php?id_hasil=<?php echo $hasil_kuiz['id_hasil_kuiz']?>">
                                                    <button class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dankbg-primary-600 dankhover:bg-primary-700 dankfocus:ring-primary-800">Lihat</button>
                                                </a>
                                            </td>
                                        </tr>

                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>

                        <script>

                            if (document.getElementById("default-table") && typeof simpleDatatables.DataTable !== 'undefined') {
                                const dataTable = new simpleDatatables.DataTable("#default-table", {
                                    searchable: false,
                                    perPageSelect: false
                                });
                            }

                        </script>

                    </div>

                </div>



            </center>

        </section>

    </main>

    <?php $location_index = "../.."; include('../../components/footer.php')?>

</body>
</html>