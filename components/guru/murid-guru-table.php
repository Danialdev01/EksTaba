<div class="kelas-table max-w-4xl p-4 pt-10">

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
                        Markah
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg>
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Tarikh
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg>
                    </span>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php 
            
                $murid_guru_sql = $connect->prepare("SELECT * FROM murid WHERE status_murid = 1");
                $murid_guru_sql->execute();

                while($murid_guru = $murid_guru_sql->fetch(PDO::FETCH_ASSOC)){

                    if($murid_guru['info_murid'] != NULL){

                        $nilai_murid_guru = json_decode($murid_guru['info_murid'], true);
                        
                        
                        if($nilai_murid_guru['id_guru'] == $id_guru){
                            ?>
                            <tr>
                                <td class="font-medium text-secondary-900 whitespace-nowrap danktext-white"><?php echo htmlspecialchars(strtoupper($murid_guru['nama_murid']))?></td>
                                <td class="text-white"><?php echo 1 ?></td>
                                <td class="text-white"><?php echo htmlspecialchars($murid_guru['created_date_murid']) ?></td>
            
                            </tr>
                            <?php
                        }
                    }
                    
                } 
            ?>
        </tbody>
    </table>

</div>

<script>
    if (document.getElementById("default-table") && typeof simpleDatatables.DataTable !== 'undefined') {
        const dataTable = new simpleDatatables.DataTable("#default-table", {
            searchable: false,
            perPageSelect: false
        });
    }
</script>