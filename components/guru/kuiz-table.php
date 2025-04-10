<div class="kelas-table max-w-4xl p-4 pt-10">

    <table id="default-table" class="rounded-lg text-black">
        <thead>
            <tr>
                <th>
                    <span class="flex items-center">
                        Kod Kuiz
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg>
                    </span>
                </th>
                <th data-type="date" data-format="YYYY/DD/MM">
                    <span class="flex items-center">
                        Tarikh Hasil
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg>
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Bil Jawapan
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg>
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Lihat
                        <!-- <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg> -->
                    </span>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php while($kuiz = $kuiz_sql->fetch(PDO::FETCH_ASSOC)){?>
                <tr class="bg-primary-400">
                    <td class="font-medium text-secondary-900 whitespace-nowrap danktext-white"><?php echo htmlspecialchars(strtoupper($kuiz['kod_kuiz']))?></td>
                    <td class="text-white"><?php echo htmlspecialchars($kuiz['created_date_kuiz']) ?></td>

                    <?php 

                        $bil_murid_menjawab_sql = $connect->prepare("SELECT * FROM hasil_kuiz WHERE id_kuiz = ?");
                        $bil_murid_menjawab_sql->execute([$kuiz['id_kuiz']]);

                        $i = 0;
                        while($bil_murid_menjawab = $bil_murid_menjawab_sql->fetch(PDO::FETCH_ASSOC)){
                            $i++;
                        }
                        
                    ?>
                    <td class="text-white"><?php echo $i?></td>
                    <td>
                        <a href="<?php echo $location_index?>/guru/kuiz/lihat-kuiz.php?id_kuiz=<?php echo $kuiz['id_kuiz']?>">
                            <button class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dankbg-primary-600 dankhover:bg-primary-700 dankfocus:ring-primary-800">Lihat</button>
                        </a>
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>

</div>

<div class="new-kuiz">

    <a href="<?php echo $location_index ?>/guru/kuiz/new-kuiz.php">
        <button class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dankbg-primary-600 dankhover:bg-primary-700 focus:outline-none dankfocus:ring-primary-800">Kuiz Baru</button>
    </a>

</div>

<script>
    if (document.getElementById("default-table") && typeof simpleDatatables.DataTable !== 'undefined') {
        const dataTable = new simpleDatatables.DataTable("#default-table", {
            searchable: false,
            perPageSelect: false
        });
    }
</script>