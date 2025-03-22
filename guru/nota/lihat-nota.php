<?php

    if(!isset($_GET['id_nota'])){

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

                $id_nota = validateInput($_GET['id_nota']);
                $nota_sql = $connect->prepare("SELECT * FROM nota WHERE id_nota = ?");
                $nota_sql->execute([$id_nota]);
                $nota = $nota_sql->fetch(PDO::FETCH_ASSOC);

            ?>

            <center>

                <div class="pt-20 text-left kuiz-container">

                    <form class="max-w-md mx-auto">
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="tajuk_nota" id="tajuk_nota" value="<?php echo $nota['tajuk_nota'] ?>" class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-secondary-300 appearance-none danktext-white dankborder-secondary-600 dankfocus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-600 peer" placeholder=" " required />
                            <label for="tajuk_nota" class="peer-focus:font-medium absolute text-sm text-white danktext-secondary-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-primary-600 peer-focus:-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tajuk Nota</label>
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="teks_nota" id="teks_nota" value="<?php echo $nota['teks_nota']?>" class="block py-2.5 px-0 w-full text-sm text-secondary-900 bg-transparent border-0 border-b-2 border-secondary-300 appearance-none danktext-white dankborder-secondary-600 dankfocus:border-primary-500 focus:outline-none focus:ring-0 focus:border-primary-600 peer" placeholder=" " required />
                            <label for="teks_nota" class="peer-focus:font-medium absolute text-sm text-white danktext-secondary-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-primary-600 peer-focus:-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pengenalan Kuiz (Tema)</label>
                        </div>


                        <?php 

                            if($nota['gambar_nota'] != NULL){
                                ?>

                                <img src="../../src/uploads/nota/gambar/<?php echo $nota['gambar_nota'] ?>" alt="Gambar Nota">

                                <?php
                            }

                            if($nota['audio_nota'] != NULL){
                                ?>

                                <script type="module" src="https://cdn.jsdelivr.net/npm/player.style/tailwind-audio/+esm"></script>

                                <media-theme-tailwind-audio>
                                <audio
                                    slot="media"
                                    src="https://stream.mux.com/fXNzVtmtWuyz00xnSrJg4OJH6PyNo6D02UzmgeKGkP5YQ/low.mp4"
                                    playsinline
                                    crossorigin
                                ></audio>
                                </media-theme-tailwind-audio>


                                <?php
                            }

                        ?>
                        <center>
                            <button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dankbg-primary-600 dankhover:bg-primary-700 dankfocus:ring-primary-800">Kemaskini Nota</button>
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