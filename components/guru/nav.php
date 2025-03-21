<?php

    include("$location_index/backend/function/system.php");
    include("$location_index/backend/function/user.php");
    include("$location_index/backend/models/guru.php");

    $verify = verifySessionGuru($secret_key, $connect);

    $verify = json_decode($verify, true);
    
    if(!isset($log_location)){
        
        if($verify['status'] != "success"){
           echo '<script>setTimeout(function() {window.location.href = "'. $location_index.'/guru/login.php"}, 0);</script>';
        } 

        // FIXME betulkan cara taknak bagi show dashboard 
        // alert_message("error", "User Not Logged In");
    }

?>

<nav class="bg-secondary-800 dankbg-secondary-800 danktext-white antialiased">
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0 py-4">
        <div class="flex items-center justify-between">

        <div class="flex items-center space-x-8">
            <div class="shrink-0">
            <a href="<?php echo $location_index?>/guru/" title="" class="">
                <img class="block w-auto h-10" src="<?php echo $location_index?>/src/assets/images/logo-banner.png" alt="">
            </a>
            </div>

            <ul class="hidden lg:flex items-center justify-start gap-6 md:gap-8 py-3 sm:justify-center">
            <li>
                <a href="<?php echo $location_index?>/guru/" title="" class="flex text-sm font-medium text-secondary-900 hover:text-primary-700 danktext-white -500">
                Dashboard
                </a>
            </li>
            <li class="shrink-0">
                <a href="<?php echo $location_index?>/guru/kelas/" title="" class="flex text-sm font-medium text-secondary-900 hover:text-primary-700 danktext-white -500">
                Kelas
                </a>
            </li>
            <li class="shrink-0">
                <a href="<?php echo $location_index?>/guru/kuiz/" title="" class="flex text-sm font-medium text-secondary-900 hover:text-primary-700 danktext-white -500">
                Kuiz
                </a>
            </li>
            <li class="shrink-0">
                <a href="<?php echo $location_index?>/guru/nota/" title="" class="flex text-sm font-medium text-secondary-900 hover:text-primary-700 danktext-white -500">
                Nota
                </a>
            </li>
            <!-- <li class="shrink-0">
                <a href="<?php echo $location_index?>/user/reports" title="" class="text-sm font-medium text-secondary-900 hover:text-primary-700 danktext-white -500">
                Reports
                </a>
            </li> -->
            </ul>
        </div>

        <div class="flex items-center lg:space-x-2">

            <!-- <button id="myCartDropdownButton1" data-dropdown-toggle="myCartDropdown1" type="button" class="inline-flex items-center rounded-lg justify-center p-2 hover:bg-secondary-100 dankhover:bg-secondary-700 text-sm font-medium leading-none text-secondary-900 danktext-white">
            <span class="sr-only">
                Cart
            </span>
            <svg class="w-5 h-5 lg:me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
            </svg> 
            <span class="hidden sm:flex">My Cart</span>
            <svg class="hidden sm:flex w-4 h-4 text-secondary-900 danktext-white ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
            </svg>              
            </button> -->

            <!-- <div class="grid grid-cols-2">
                <div>
                <a href="#" class="truncate text-sm font-semibold leading-none text-secondary-900 danktext-white hover:underline">Sony Playstation 5</a>
                <p class="mt-0.5 truncate text-sm font-normal text-secondary-500 danktext-secondary-400">$799</p>
                </div>
        
                <div class="flex items-center justify-end gap-6">
                <p class="text-sm font-normal leading-none text-secondary-500 danktext-secondary-400">Qty: 1</p>
        
                <button data-tooltip-target="tooltipRemoveItem4b" type="button" class="text-red-600 hover:text-red-700 danktext-red-500 dankhover:text-red-600">
                    <span class="sr-only"> Remove </span>
                    <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm7.7-3.7a1 1 0 0 0-1.4 1.4l2.3 2.3-2.3 2.3a1 1 0 1 0 1.4 1.4l2.3-2.3 2.3 2.3a1 1 0 0 0 1.4-1.4L13.4 12l2.3-2.3a1 1 0 0 0-1.4-1.4L12 10.6 9.7 8.3Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div id="tooltipRemoveItem4b" role="tooltip" class="tooltip invisible absolute z-10 inline-block rounded-lg bg-secondary-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dankbg-secondary-700">
                    Remove item
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
                </div>
            </div> -->
        
            <!-- <div class="grid grid-cols-2">
                <div>
                <a href="#" class="truncate text-sm font-semibold leading-none text-secondary-900 danktext-white hover:underline">Apple iMac 20"</a>
                <p class="mt-0.5 truncate text-sm font-normal text-secondary-500 danktext-secondary-400">$8,997</p>
                </div>
        
                <div class="flex items-center justify-end gap-6">
                <p class="text-sm font-normal leading-none text-secondary-500 danktext-secondary-400">Qty: 3</p>
        
                <button data-tooltip-target="tooltipRemoveItem5b" type="button" class="text-red-600 hover:text-red-700 danktext-red-500 dankhover:text-red-600">
                    <span class="sr-only"> Remove </span>
                    <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm7.7-3.7a1 1 0 0 0-1.4 1.4l2.3 2.3-2.3 2.3a1 1 0 1 0 1.4 1.4l2.3-2.3 2.3 2.3a1 1 0 0 0 1.4-1.4L13.4 12l2.3-2.3a1 1 0 0 0-1.4-1.4L12 10.6 9.7 8.3Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div id="tooltipRemoveItem5b" role="tooltip" class="tooltip invisible absolute z-10 inline-block rounded-lg bg-secondary-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dankbg-secondary-700">
                    Remove item
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
                </div>
            </div> -->
        
            <!-- <a href="#" title="" class="mb-2 me-2 inline-flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dankbg-primary-600 dankhover:bg-primary-700 dankfocus:ring-primary-800" role="button"> Proceed to Checkout </a>
            </div> -->

            <button id="userDropdownButton1" data-dropdown-toggle="userDropdown1" type="button" class="inline-flex items-center rounded-lg justify-center p-2 hover:bg-secondary-100 hover:bg-secondary-100 hover:text-primary-400 dankhover:bg-secondary-700 text-sm font-medium leading-none text-secondary-900 danktext-white">
            <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
            </svg>              
            Account
            <svg class="w-4 h-4 text-secondary-900 danktext-white ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
            </svg> 
            </button>

            <div id="userDropdown1" class="hidden z-10 w-56 divide-y divide-secondary-100 overflow-hidden overflow-y-auto rounded-lg bg-white antialiased shadow dankdivide-secondary-600 dankbg-secondary-700">
            <ul class="p-2 text-start text-sm font-medium text-secondary-900 danktext-white">
                <li><a href="<?php echo $location_index?>/guru/account/" title="" class="inline-flex text-primary-400 hover:bg-primary-400 hover:text-white w-full items-center gap-2 rounded-md px-3 py-2 text-sm  dankhover:bg-secondary-600"> My Account </a></li>
                <!-- <li><a href="#" title="" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-secondary-100 dankhover:bg-secondary-600"> My Orders </a></li> -->
                <!-- <li><a href="#" title="" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-secondary-100 dankhover:bg-secondary-600"> Settings </a></li> -->
                <!-- <li><a href="#" title="" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-secondary-100 dankhover:bg-secondary-600"> Favourites </a></li> -->
                <!-- <li><a href="#" title="" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-secondary-100 dankhover:bg-secondary-600"> Delivery Addresses </a></li> -->
                <!-- <li><a href="#" title="" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-secondary-100 dankhover:bg-secondary-600"> Billing Data </a></li> -->
            </ul>
        
            <div class="p-2 text-sm font-medium text-secondary-900 danktext-white">
                <form action="<?php echo $location_index?>/backend/murid.php" method="post">
                    <input type="hidden" name="token" value="<?php echo $token?>">

                    <input type="hidden" name="user_value_hash" value="<?php echo $_SESSION['EksTabaUserHash']?>" >

                    <button type="submit" name="signout" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-primary-400 hover:text-white text-primary-400 dankhover:bg-secondary-600">Sign Out</button>
                </form>
                <!-- <a href="#" title="" > Sign Out </a> -->
            </div>
            </div>

            <button type="button" data-collapse-toggle="ecommerce-navbar-menu-1" aria-controls="ecommerce-navbar-menu-1" aria-expanded="false" class="inline-flex lg:hidden items-center justify-center hover:bg-secondary-100 rounded-md dankhover:bg-secondary-700 p-2 text-secondary-900 danktext-white">
            <span class="sr-only">
                Open Menu
            </span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/>
            </svg>                
            </button>
        </div>
        </div>

        <div id="ecommerce-navbar-menu-1" class="bg-secondary-50 dankbg-secondary-700 dankborder-secondary-600 border border-secondary-200 rounded-lg py-3 hidden px-4 mt-4">
        <ul class="text-secondary-900 danktext-white text-sm font-medium danktext-white space-y-3">
            <li>
            <a href="<?php echo $location_index?>/user/" class="hover:text-primary-700 -500">Dashboard</a>
            </li>
            <li>
            <a href="<?php echo $location_index?>/ingredients" class="hover:text-primary-700 -500">Ingredients</a>
            </li>
            <li>
            <a href="<?php echo $location_index?>/user/orderings" class="hover:text-primary-700 -500">Orderings</a>
            </li>
            <!-- <li>
            <a href="<?php echo $location_index?>/user/reports" class="hover:text-primary-700 -500">Reports</a>
            </li> -->
        </ul>
        </div>
    </div>
</nav>

<?php include "$location_index/components/alert.php";?>