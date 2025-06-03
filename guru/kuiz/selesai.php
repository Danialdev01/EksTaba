<?php

    if(!isset($_GET['id_hasil'])){
        header("Location:../");
    }
    $_SESSION['index_answering'] = 0;
?>

<?php $location_index = "../.."; include('../../components/head.php');?>

<body>
    <main class="dankbg-plrimary-200">
        <?php $location_index = "../.."; include('../../components/guru/nav.php');?>

        <section>

            <?php 
                $murid_value = decryptUser($_SESSION['EksTabaUserHash'], $secret_key);
                $id_murid = $murid_value['id_user'];
                
                
                $id_hasil = validateInput($_GET['id_hasil']);
                $hasil_kuiz_sql = $connect->prepare("SELECT * FROM hasil_kuiz WHERE id_hasil_kuiz = ?");
                $hasil_kuiz_sql->execute([$id_hasil]);
                $hasil_kuiz = $hasil_kuiz_sql->fetch(PDO::FETCH_ASSOC);
                
                $murid_sql = $connect->prepare("SELECT * FROM murid WHERE id_murid = ?");
                $murid_sql->execute([$hasil_kuiz['id_murid']]);
                $murid = $murid_sql->fetch(PDO::FETCH_ASSOC);

                $kuiz_sql = $connect->prepare("SELECT * FROM kuiz WHERE id_kuiz = ?");
                $kuiz_sql->execute([$hasil_kuiz['id_kuiz']]);
                $kuiz = $kuiz_sql->fetch(PDO::FETCH_ASSOC);

            ?>

            <center>

                <div class="container pt-20">
                    
                    <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-secondary-900 md:text-5xl lg:text-6xl danktext-white"><?php echo htmlspecialchars($kuiz['nama_kuiz'])?></h1>

                    <form class="max-w-sm mx-auto text-left pt-5">
                        <?php 
                            $guru_sql = $connect->prepare("SELECT * FROM guru WHERE id_guru = ?");
                            $guru_sql->execute([$kuiz['id_guru']]);
                            $guru = $guru_sql->fetch(PDO::FETCH_ASSOC);
                        ?>
                      <div class="mb-5">
                        <label for="nama_guru" class="block mb-2 text-sm font-medium text-secondary-900 danktext-white">Nama Murid : </label>
                        <input type="text" id="nama_guru" name="nama_guru" disabled class="shadow-xs bg-secondary-50 border border-secondary-300 text-secondary-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dankbg-secondary-700 dankborder-secondary-600 dankplaceholder-secondary-400 danktext-white dankfocus:ring-primary-500 dankfocus:border-primary-500 dankshadow-xs-light" placeholder="guru" value="<?php echo htmlspecialchars(ucfirst($murid['nama_murid']))?>" />
                      </div>
                      <div class="mb-5">
                        <label for="date_hasil" class="block mb-2 text-sm font-medium text-secondary-900 danktext-white">Tarikh Hasil : </label>
                        <!-- <input type="text" id="tarikh_hasil" name="nama_guru" disabled class="shadow-xs bg-secondary-50 border border-secondary-300 text-secondary-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dankbg-secondary-700 dankborder-secondary-600 dankplaceholder-secondary-400 danktext-white dankfocus:ring-primary-500 dankfocus:border-primary-500 dankshadow-xs-light" placeholder="guru" value="<?php echo htmlspecialchars(ucfirst($murid['nama_murid']))?>" /> -->
                         <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-secondary-500 danktext-secondary-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input id="datepicker-format" value="<?php echo $hasil_kuiz['created_date_hasil_kuiz']?>" datepicker datepicker-format="dd / mm / yyyy" type="text" class="bg-secondary-50 border border-secondary-300 text-secondary-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full ps-10 p-2.5  dankbg-secondary-700 dankborder-secondary-600 dankplaceholder-secondary-400 danktext-white dankfocus:ring-primary-500 dankfocus:border-primary-500" placeholder="Select date" disabled>
                      </div>
                    </form>

                    <br><br>

                    <?php 

                        $bli_soalan = 0;
                        $betul = 0;

                    ?>
                    <h3 class="mb-4 text-2xl leading-none tracking-tight text-secondary-900 md:text-3xl lg:text-4xl danktext-white">Markah: <span class="font-extrabold"><?php echo round($_SESSION['peratus'])?> %</span></h3>
                    <div class="max-w-4xl justify-center soalan-kuiz-container pb-4">
                        <?php

                            $soalan_kuiz_sql = $connect->prepare("SELECT * FROM soalan WHERE id_kuiz = ?");
                            $soalan_kuiz_sql->execute([$kuiz['id_kuiz']]);

                            while($soalan_kuiz = $soalan_kuiz_sql->fetch(PDO::FETCH_ASSOC)){

                                $bli_soalan++;
                                ?>

                                    <div class="p-2">
                                        <div class="text-left max-w-lg p-6 bg-primary border border-secondary-200 rounded-lg shadow-sm dankbg-secondary-800 dankborder-secondary-700">
                                            <h5 class="mb-4 text-lg tracking-tight text-secondary-900 danktext-white"><?php echo $soalan_kuiz['teks_soalan']?></h5>

                                            <div class="jawapan pb-3">
                                                <?php 

                                                    $skema_jawapan_sql = $connect->prepare("SELECT * FROM skema_jawapan WHERE id_soalan = ?");
                                                    $skema_jawapan_sql->execute([$soalan_kuiz['id_soalan']]);
                                                    $skema_jawapan = $skema_jawapan_sql->fetch(PDO::FETCH_ASSOC);

                                                    $jawapan = json_decode($skema_jawapan['teks_jawapan'], true);

                                                ?>
                                                <div class="jawapan-betul pb-1">
                                                    <p class="text-white">Jawapan pilihan : 
                                                        <?php
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

                                                                ?>
                                                                    <span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dankbg-green-900 danktext-green-300"><?php echo $jawapan_jenis?></span>
                                                                <?php
                                                            }
                                                            else{
                                                                ?>
                                                                    <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dankbg-red-900 danktext-red-300"><?php echo $jawapan_jenis?></span>
                                                                <?php
                                                            }
                                                        ?>
                                                    </p>
                                                    </div>
                                                    <div class="jawapan-salah">
                                                        <p class="text-white">Skema Jawapan : 
                                                        <span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dankbg-green-900 danktext-green-300"><?php echo $jawapan['jawapan_betul']?></span>
                                                        <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dankbg-red-900 danktext-red-300"><?php echo $jawapan['jawapan_salah_1']?></span>
                                                        <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dankbg-red-900 danktext-red-300"><?php echo $jawapan['jawapan_salah_2']?></span>
                                                        <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dankbg-red-900 danktext-red-300"><?php echo $jawapan['jawapan_salah_3']?></span>
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- [{"id_soalan":1,"selected":"1","correct":1},{"id_soalan":2,"selected":"2","correct":0},{"id_soalan":3,"selected":"3","correct":2}] -->

                                <?php
                                
                            }

                        ?>

                    </div>
                </div>

                <a href="./">
                    <button class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dankbg-primary-600 dankhover:bg-primary-700 dankfocus:ring-primary-800">Kembali</button>
                </a>
                <br>
                <br>

                <?php 
                    if($_SESSION['peratus'] === NULL){
                        echo '<script>setTimeout(function(){ window.location.reload(); }, 100);</script>';
                    }
                    $_SESSION['peratus'] = ($betul / $bli_soalan) * 100;

                ?>
            </center>

        </section>

    </main>

    <?php $location_index = "../.."; include('../../components/footer.php')?>

</body>
</html>