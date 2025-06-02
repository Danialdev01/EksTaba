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
            <?php 
            
                $ar_hasil_sql = $connect->prepare("SELECT * FROM ar WHERE status_ar = 1");
                $ar_hasil_sql->execute();

                while($ar = $ar_hasil_sql->fetch(PDO::FETCH_ASSOC)){?>
                <tr>
                    <td class="font-medium text-secondary-900 whitespace-nowrap danktext-white"><?php echo htmlspecialchars(strtoupper($ar['nama_murid']))?></td>
                    <td class="text-white"><?php echo $ar['markah1'] + $ar['markah2'] + $ar['markah3'] + $ar['markah4'] ?></td>
                    <td class="text-white"><?php echo htmlspecialchars($ar['tarikh_ar']) ?></td>
                    <td>
                        <!-- Modal toggle -->
                        <button data-modal-target="authentication-modal-<?php echo $ar['id_ar']?>" data-modal-toggle="authentication-modal-<?php echo $ar['id_ar']?>" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                            Lihat
                        </button>

                        <!-- Main modal -->
                        <div id="authentication-modal-<?php echo $ar['id_ar']?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Markah Murid
                                        </h3>
                                        <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-4 md:p-5">
                                        <form class="space-y-4" action="#">
                                            <div>
                                                <label for="nama_murid" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama murid</label>
                                                <input disabled type="text" name="nama_murid" id="nama_murid" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="<?php echo $ar['nama_murid']?>" required />
                                            </div>
                                            <div>
                                                <label for="markah1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Markah "."</label>
                                                <input disabled type="text" name="markah_murid" id="markah_murid" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="<?php echo $ar['markah1']?>" required />
                                            </div>
                                             <div>
                                                <label for="markah1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Markah "!"</label>
                                                <input disabled type="text" name="markah_murid" id="markah_murid" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="<?php echo $ar['markah2']?>" required />
                                            </div>
                                             <div>
                                                <label for="markah1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Markah ","</label>
                                                <input disabled type="text" name="markah_murid" id="markah_murid" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="<?php echo $ar['markah3']?>" required />
                                            </div>
                                             <div>
                                                <label for="markah1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Markah "?"</label>
                                                <input disabled type="text" name="markah_murid" id="markah_murid" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="<?php echo $ar['markah4']?>" required />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> 

                    </td>

                </tr>
            <?php }?>
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