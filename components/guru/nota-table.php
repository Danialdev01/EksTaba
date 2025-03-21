<div class="nota-table max-w-4xl p-4 pt-10">

    <table id="default-table" class="rounded-lg text-black">
        <thead>
            <tr>
                <th>
                    <span class="flex items-center">
                        Tajuk Nota 
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg>
                    </span>
                </th>
                <th data-type="date" data-format="YYYY/DD/MM">
                    <span class="flex items-center">
                        Tarikh Cipta
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
            <?php while($nota = $nota_sql->fetch(PDO::FETCH_ASSOC)){?>
                <tr class="bg-primary-400">
                    <td class="font-medium text-secondary-900 whitespace-nowrap danktext-white"><?php echo htmlspecialchars($nota['tajuk_nota'])?></td>
                    <td class="text-white"><?php echo htmlspecialchars($nota['created_date_nota']) ?></td>

                    <td>
                        <a href="<?php echo $location_index?>/guru/nota/lihat-nota.php?id_nota=<?php echo $nota['id_nota']?>">
                            <button class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dankbg-primary-600 dankhover:bg-primary-700 dankfocus:ring-primary-800">Lihat</button>
                        </a>
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>

</div>

<div class="new-kuiz">

    <a href="<?php echo $location_index ?>/guru/nota/new-nota.php">
        <button class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dankbg-primary-600 dankhover:bg-primary-700 focus:outline-none dankfocus:ring-primary-800">Nota Baru</button>
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