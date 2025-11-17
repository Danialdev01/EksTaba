
<?php 
    
    if(!(isset($_GET['markah1']) && isset($_GET['markah2']) && isset($_GET['markah3']) && isset($_GET['markah4']))){
        header("Location:./");
    }

    $s = $_GET['markah1'] + $_GET['markah2'] + $_GET['markah3'] + $_GET['markah4'];
?>

<?php $location_index = ".."; include('../components/head.php');?>


<body>
    <main class="dankbg-plrimary-200">
        <?php $location_index = ".."; include('../components/nav.php');?>

        <section>

            <center>
                
                <br><br>
                <h3 class="text-3xl font-bold text-white">Markah Keseluruhan : <?php echo $s?></h3>
                <div class="form text-left">

                    <form class="max-w-sm mx-auto" action="../backend/ar.php" method="post">
                        <input type="hidden" name="token" value="<?php echo $token?>">
                        <input type="hidden" name="markah1" value="<?php echo $_GET['markah1']?>">
                        <input type="hidden" name="markah2" value="<?php echo $_GET['markah2']?>">
                        <input type="hidden" name="markah3" value="<?php echo $_GET['markah3']?>">
                        <input type="hidden" name="markah4" value="<?php echo $_GET['markah4']?>">
                        <br><br>

                        <div class="mb-5">
                            <label for="nama_murid" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" name="nama_murid" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required />
                        </div>


                        <button type="submit" name="new_markah" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan Markah</button>
                    </form>
                </div>



            </center>

        </section>

    </main>

    <?php $location_index = ".."; include('../components/footer.php')?>

</body>
</html>