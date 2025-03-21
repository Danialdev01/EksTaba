<!-- Modal toggle -->
<button data-modal-target="new-kelas-modal" data-modal-toggle="new-kelas-modal" class="block text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dankbg-primary-600 dankhover:bg-primary-700 dankfocus:ring-primary-800" type="button">
    Kelas Baru
</button>

<!-- Main modal -->
<div id="new-kelas-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="text-left relative bg-white rounded-lg shadow-sm dankbg-secondary-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dankborder-secondary-600 border-secondary-200">
                <h3 class="text-xl font-semibold text-secondary-900 danktext-white">
                    Kelas Baru
                </h3>
                <button type="button" class="end-2.5 text-secondary-400 bg-transparent hover:bg-secondary-200 hover:text-secondary-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dankhover:bg-secondary-600 dankhover:text-white" data-modal-hide="new-kelas-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form class="space-y-4" method="post" action="<?php echo $location_index?>/backend/guru.php">

                    <input type="hidden" name="token" value="<?php echo $token?>">
                    <input type="hidden" name="id_guru" value="<?php echo $guru['id_guru']?>">
                    <div>
                        <label for="tajuk_kelas" class="block mb-2 text-sm font-medium text-secondary-900 danktext-white">Tajuk Kelas</label>
                        <input type="text" name="tajuk_kelas" id="tajuk_kelas" class="bg-secondary-50 border border-secondary-300 text-secondary-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dankbg-secondary-600 dankborder-secondary-500 dankplaceholder-secondary-400 danktext-white" required />
                    </div>
                    <div>
                        <label for="info_kelas" class="block mb-2 text-sm font-medium text-secondary-900 danktext-white">Info Kelas</label>
                        <input type="text" name="info_kelas" id="info_kelas" placeholder="" class="bg-secondary-50 border border-secondary-300 text-secondary-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dankbg-secondary-600 dankborder-secondary-500 dankplaceholder-secondary-400 danktext-white" required />
                    </div>
                    <button type="submit" name="new_kelas" class="w-full text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dankbg-primary-600 dankhover:bg-primary-700 dankfocus:ring-primary-800">Kelas Baru</button>
                    
                </form>
            </div>
        </div>
    </div>
</div> 
