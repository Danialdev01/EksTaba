<table id="pagination-table" class="">
    <thead>
        <tr>
            <th>
                <span class="flex items-center">
                    Nama Kuiz
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Tarikh Mula
                </span>
            </th>
            <th data-type="date" data-format="Month YYYY">
                <span class="flex items-center">
                    Nama Pencipta
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Lihat
                </span>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php 
            
            $selesai_kuiz_sql = $connect->prepare("SELECT * FROM hasil_kuiz WHERE id_murid = :id_murid AND status_hasil_murid = 1");
            $selesai_kuiz_sql->execute([
                ":id_murid" => $id_murid
            ]);

            while($selesai_kuiz = $selesai_kuiz_sql->fetch(PDO::FETCH_ASSOC)){

                $kuiz_sql = $connect->prepare("SELECT * FROM kuiz WHERE id_kuiz = :id_kuiz");
                $kuiz_sql->execute([":id_kuiz" => $selesai_kuiz['id_kuiz']]);
                $kuiz = $kuiz_sql->fetch(PDO::FETCH_ASSOC);

                $guru_sql = $connect->prepare("SELECT * FROM guru WHERE id_guru = :id_guru");
                $guru_sql->execute([
                    ":id_guru" => $kuiz['id_guru']
                ]);
                $guru = $guru_sql->fetch(PDO::FETCH_ASSOC);

                ?>
                <tr>
                    <td class="font-medium text-white whitespace-nowrap"><?php echo $kuiz['nama_kuiz'] ?></td>
                    <td class="text-white"><?php echo $selesai_kuiz['created_date_hasil_murid']?></td>
                    <td class="text-white"><?php echo $guru['nama_guru'] ?></td>
                    <td>
                        <a href="<?php echo $location_index?>/murid/kuiz/selesai.php?id_hasil=<?php echo $selesai_kuiz['id_hasil_kuiz']?>">
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
    if (document.getElementById("pagination-table") && typeof simpleDatatables.DataTable !== 'undefined') {
        const dataTable = new simpleDatatables.DataTable("#pagination-table", {
            paging: true,
            perPage: 10,
            perPageSelect: [5, 10, 15, 20, 25],
            sortable: false
        });
    }
</script>
