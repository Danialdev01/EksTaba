<?php $location_index = "../.."; include('../../components/head.php');?>

<body>
    <style>
        .murid-container {
            max-width: 4xl;
            padding: 1.25rem;
            padding-top: 5rem;
            background: linear-gradient(160deg, #ffecd2 0%, #fcb69f 100%);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .murid-container h2.text-4xl {
            color: #ff6b6b;
            text-shadow: 2px 2px 0 #fff, 4px 4px 0 rgba(0,0,0,0.1);
            transform: rotate(-2deg);
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0) rotate(-2deg); }
            50% { transform: translateY(-10px) rotate(2deg); }
        }

        .murid-container h3 {
            color: #2d3436;
            background: rgba(255,255,255,0.9);
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin: 1.5rem 0;
        }

        .murid-container > div {
            margin: 2rem 0;
            padding: 1.5rem;
            border-radius: 15px;
            /* background: rgba(255,255,255,0.8); */
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .murid-container > div:hover {
            transform: translateY(-5px) rotate(1deg);
        }

        .murid-container span {
            display: block;
            font-size: 4rem;
            text-align: center;
            margin: 1rem 0;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        .murid-container li {
            padding: 0.8rem;
            margin: 0.5rem 0;
            background: white;
            border-radius: 8px;
            position: relative;
            transition: all 0.3s ease;
        }

        .murid-container li:hover {
            transform: translateX(10px);
            box-shadow: 2px 2px 0 rgba(0,0,0,0.1);
        }

        .murid-container li::before {
            content: "✨";
            margin-right: 0.5rem;
        }

        /* Unique colors for each section */
        .huruf_besar { border: 4px solid #ff7675; }
        .huruf_besar span { color: #ff7675; }

        .noktah_tiktik { border: 4px solid #fdcb6e; }
        .noktah_tiktik span { color: #fdcb6e; }

        .koma { border: 4px solid #6c5ce7; }
        .koma span { color: #6c5ce7; }

        .tanda_soal { border: 4px solid #00b894; }
        .tanda_soal span { color: #00b894; }

        .tanda_seru { border: 4px solid #d63031; }
        .tanda_seru span { color: #d63031; }

        .pengikat_kata { border: 4px solid #e84393; }
        .pengikat_kata span { color: #e84393; }

        .tanda_sempang { border: 4px solid #00cec9; }
        .tanda_sempang span { color: #00cec9; }

        .titik_bertin { border: 4px solid #fd79a8; }
        .titik_bertin span { color: #fd79a8; }

        .koma_bertitik { border: 4px solid #a55eea; }
        .koma_bertitik span { color: #a55eea; }

        .tanda_penyigkat { border: 4px solid #fed330; }
        .tanda_penyigkat span { color: #fed330; }

        .tanda_kurung { border: 4px solid #26de81; }
        .tanda_kurung span { color: #26de81; }

        .tanda_garis_miring { border: 4px solid #45aaf2; }
        .tanda_garis_miring span { color: #45aaf2; }

        </style>


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
                
                <br><br>
                <div class="murid-container max-w-4xl p-5 pt-20 text-left">
                    <h2 class="text-4xl font-extrabold text-white">Nota Tanda Baca</h2>
                    <br>
                    
                    <h3>Tanda baca ialah simbol atau tanda yang digunakan untuk memberi isyarat kepada pembaca supaya melakukan sesuatu semasa bacaan.</h3>
                    <h3>Ia diletakkan di tempat-tempat tertentu dalam ayat berdasarkan tujuan dan kesesuaiannya.</h3>

                    <div class="huruf_besar">
                        <h3>Huruf besar</h3>
                        <span>Aa</span>
                        <ul>
                            <li>Ditulis pada awal perkataan di dalam ayat.</li>
                            <li>Ditulis pada huruf pertama bagi kata nama khas.</li>
                        </ul>
                    </div>

                    <div class="noktah_tiktik">
                        <h3>Noktah / Titik</h3>
                        <span>.</span>
                        <ul>
                            <li>DItulis pada akhir ayat.</li>
                            <li>Digunakan untuk singkatan nama.</li>
                        </ul>
                    </div>

                    <div class="koma">
                        <h3>Koma</h3>
                        <span>,</span>
                        <ul>
                            <li>Digunakan unntuk mengasingkan kata yang berturut-turut dalam satu ayat.</li>
                            <li>Untuk menyambung ayat.</li>
                            <li>Tempat berhenti sebentar.</li>
                            <li>Terletak di belakang kata seru.</li>
                        </ul>
                    </div>

                    <div class="tanda_soal">
                        <h3>Tanda Soal</h3>
                        <span>?</span>
                        <ul>
                            <li>Digunakan dalam ayat tanya.</li>
                            <li>Ditulis pada akhir ayat tanya.</li>
                        </ul>
                    </div>

                    <div class="tanda_seru">
                        <h3>Tanda Seru</h3>
                        <span>!</span>
                        <ul>
                            <li>Digunakan dalam ayat seru.</li>
                            <li>DItulis pada akhir ayat seru.</li>
                        </ul>
                    </div>

                    <div class="pengikat_kata">
                        <h3>Pengikat Kata</h3>
                        <span>""</span>
                        <ul>
                            <li>Digunakan untuk mengapit petikan lansung dan ayat cakap ajuk.</li>
                            <li>Digunakan pada judul karya.</li>
                        </ul>
                    </div>

                    <div class="tanda_sempang">
                        <h3>Tanda Sempang</h3>
                        <span>-</span>
                        <ul>
                            <li>Digunakan dalam kata Ganda.</li>
                            <li>Untuk penggunaan ke- dengan angka dan angka dengan -an.</li>
                        </ul>
                    </div>

                    <div class="titik_bertin">
                        <h3>Titik bertindih</h3>
                        <span>:</span>
                        <ul>
                            <li>Untuk memberikan penjelasan.</li>
                            <li>Ditulis pada akhir pernyataan yang diikuti oleh rangkaian.</li>
                        </ul>
                    </div>

                    <div class="koma_bertitik">
                        <h3>Koma Bertitik</h3>
                        <span>;</span>
                        <ul>
                            <li>Digunakan untuk memisahkan bahagian-bahagian ayat yang sejenis.</li>
                            <li>Juga untuk memisahkan bahagian ayat yang menggunakan kata hubung. (tetap, dan, lalu, namun)</li>
                            <li>Terletak pada bari pertama pantun 2 kerat dan baris kedua pantun 4 kerat.</li>
                        </ul>
                    </div>

                    <div class="tanda_penyigkat">
                        <h3>Tanda Penyingkat</h3>
                        <span>'</span>
                        <ul>
                            <li>Menunjukkan terdapat bahagian kata atau nombor yang hilang.</li>
                        </ul>
                    </div>

                    <div class="tanda_kurung">
                        <h3>Tanda Kurung</h3>
                        <span>( )</span>
                        <ul>
                            <li>Mengapit singkatan atau keterangan untuk memberikan penjelasan tambahan.</li>
                            <li>Mengapit angka atau abjad yang menunjukkan bilangan. (i) (ii) / (a) (b)</li>
                        </ul>
                    </div>

                    <div class="tanda_garis_miring">
                        <h3>Tanda Garis Miring</h3>
                        <span>/</span>
                        <ul>
                            <li>Digunakan untuk rujukan surat rasmi.</li>
                            <li>Digunakan juga sebagai pengganti kata bagi dan, atau, per dan nombor alamat.</li>
                        </ul>
                    </div>
                </div>

            </center>

        </section>

    </main>

    <?php $location_index = "../.."; include('../../components/footer.php')?>

</body>
</html>