<?php

?>
<!-- Modal toggle -->
<button data-modal-target="kuiz-modal-<?php echo $id_kuiz ?>" data-modal-toggle="kuiz-modal-<?php echo $id_kuiz?>" class="block text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dankbg-primary-600 dankhover:bg-primary-700 dankfocus:ring-primary-800" type="button">
  Kemaskini Soalan
</button>

<!-- Main modal -->
<div id="kuiz-modal-<?php echo $id_kuiz?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="px-4 pb-4 relative bg-primary-400 rounded-lg shadow-sm dankbg-secondary-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dankborder-secondary-600 border-secondary-200">
                <h3 class="text-lg font-semibold text-secondary-900 danktext-white">
                    Kemaskini Soalan
                </h3>
                <button type="button" class="text-secondary-400 bg-transparent hover:bg-secondary-200 hover:text-secondary-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dankhover:bg-secondary-600 dankhover:text-white" data-modal-toggle="kuiz-modal-<?php echo $id_kuiz?>">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5" method="post" action="<?php $location_index?>/backend/kuiz.php">
                <input type="hidden" name="token" value="<?php $token?>">
                <input type="hidden" name="id_soalan" value="<?php $soalan_kuiz['id_soalan']?>">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2 pt-2">
                        <label for="teks_soalan" class="block mb-2 text-sm font-medium text-secondary-900 danktext-white">Ayat Soalan</label>
                        <textarea id="teks_soalan" rows="4" class="block p-2.5 w-full text-sm text-black bg-secondary-50 rounded-lg border border-secondary-300 focus:ring-primary-500 focus:border-primary-500 dankbg-secondary-600 dankborder-secondary-500 dankplaceholder-secondary-400 danktext-white dankfocus:ring-primary-500 dankfocus:border-primary-500" placeholder="Ayat Soalan"><?php echo $soalan_kuiz['teks_soalan']?></textarea>                    
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="markah_soalan" class="block mb-2 text-sm font-medium text-secondary-900 danktext-white">Markah Soalan</label>
                        <div class="relative flex items-center max-w-[8rem]">
                            <button type="button" id="decrement-button" data-input-counter-decrement="markah_soalan" class="bg-primary-400 dankbg-secondary-700 dankhover:bg-secondary-600 dankborder-secondary-600 hover:bg-secondary-200 border border-secondary-300 rounded-s-lg p-3 h-11 focus:ring-secondary-100 dankfocus:ring-secondary-700 focus:ring-2 focus:outline-none">
                                <svg class="w-3 h-3 text-secondary-900 danktext-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                </svg>
                            </button>
                            <input type="text" name="markah_soalan" id="markah_soalan" value="<?php echo $soalan_kuiz['markah_soalan']?>" data-input-counter data-input-counter-min="1" data-input-counter-max="15" aria-describedby="helper-text-explanation" class="bg-secondary-50 border-x-0 border-secondary-300 h-11 text-center text-secondary-900 text-sm focus:ring-primary-500 focus:border-primary-500 block w-full py-2.5 dankbg-secondary-700 dankborder-secondary-600 dankplaceholder-secondary-400 danktext-white dankfocus:ring-primary-500 dankfocus:border-primary-500" placeholder="999" required />
                            <button type="button" id="increment-button" data-input-counter-increment="markah_soalan" class="bg-primary-400 dankbg-secondary-700 dankhover:bg-secondary-600 dankborder-secondary-600 hover:bg-secondary-200 border border-secondary-300 rounded-e-lg p-3 h-11 focus:ring-secondary-100 dankfocus:ring-secondary-700 focus:ring-2 focus:outline-none">
                                <svg class="w-3 h-3 text-secondary-900 danktext-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                  
                </div>
                <button type="submit" name="kemaskini_soalan" class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dankbg-primary-600 dankhover:bg-primary-700 dankfocus:ring-primary-800">
                    Kemaskini
                </button>
            </form>
        </div>
    </div>
</div> 
