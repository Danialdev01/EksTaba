<!-- Modal toggle -->
<button data-modal-target="login-modal" data-modal-toggle="login-modal" class="block text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dankbg-primary-600 dankhover:bg-primary-700 dankfocus:ring-primary-800" type="button">
  Log Masuk
</button>

<!-- Main modal -->
<div id="login-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-primary-400 rounded-lg shadow dankborder md:mt-0 sm:max-w-md xl:p-0 dankbg-secondary-800 dankborder-secondary-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight md:text-2xl text-white">
                        Log Masuk
                    </h1>
                    <form class="space-y-4 md:space-y-6" method="post" action="<?php echo $location_index?>/backend/murid.php">
                        <input type="hidden" name="token" value="<?php echo $token?>">
                        <div>
                            <label for="email_murid" class="block mb-2 text-sm font-medium text-white">E-mel anda</label>
                            <input type="email" name="email_murid" id="email_murid" class="bg-secondary-50 border border-secondary-300 text-secondary-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dankbg-secondary-700 dankborder-secondary-600 dankplaceholder-secondary-400 danktext-white dankfocus:ring-primary-500 dankfocus:border-primary-500" placeholder="nama@domain.com" required="">
                        </div>
                        <input type="hidden" name="katalaluan_murid" value="default">
                        <!-- <div>
                            <label for="katalaluan_murid" class="block mb-2 text-sm font-medium text-white">Katalaluan</label>
                            <input type="password" name="katalaluan_murid" id="password" placeholder="••••••••" class="bg-secondary-50 border border-secondary-300 text-secondary-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dankbg-secondary-700 dankborder-secondary-600 dankplaceholder-secondary-400 danktext-white dankfocus:ring-primary-500 dankfocus:border-primary-500" required="">
                        </div> -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <!-- <div class="flex items-center h-5">
                                    <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-secondary-300 rounded bg-secondary-50 focus:ring-3 focus:ring-primary-300 dankbg-secondary-700 dankborder-secondary-600 dankfocus:ring-primary-600 dankring-offset-secondary-800" required="">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="remember" class="text-secondary-500 danktext-secondary-300"></label>
                                </div> -->
                            </div>
                            <!-- <a href="#" class="text-sm font-medium text-primary-600 hover:underline -500">Lupa katalaluan ?</a> -->
                        </div>

                        <button name="login" type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-2 py-2.5 text-center dankbg-primary-600 dankhover:bg-primary-700 dankfocus:ring-primary-800">Log Masuk</button>

                    </form>

                    <center>

                        <span><p class="text-white pb-3">atau</p></span>
                        <a href="<?php echo $google_login_url?>">
                            <button type="button" class="text-secondary-900 bg-white hover:bg-white border border-secondary-200 focus:ring-4 focus:outline-none focus:ring-secondary-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dankfocus:ring-secondary-600 dankbg-secondary-800 dankborder-secondary-700 danktext-white dankhover:bg-secondary-700 me-2 mb-2">
                                <svg class="w-5 h-5 mr-2" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_13183_10121)"><path d="M20.3081 10.2303C20.3081 9.55056 20.253 8.86711 20.1354 8.19836H10.7031V12.0492H16.1046C15.8804 13.2911 15.1602 14.3898 14.1057 15.0879V17.5866H17.3282C19.2205 15.8449 20.3081 13.2728 20.3081 10.2303Z" fill="#3F83F8"></path><path d="M10.7019 20.0006C13.3989 20.0006 15.6734 19.1151 17.3306 17.5865L14.1081 15.0879C13.2115 15.6979 12.0541 16.0433 10.7056 16.0433C8.09669 16.0433 5.88468 14.2832 5.091 11.9169H1.76562V14.4927C3.46322 17.8695 6.92087 20.0006 10.7019 20.0006V20.0006Z" fill="#34A853"></path><path d="M5.08857 11.9169C4.66969 10.6749 4.66969 9.33008 5.08857 8.08811V5.51233H1.76688C0.348541 8.33798 0.348541 11.667 1.76688 14.4927L5.08857 11.9169V11.9169Z" fill="#FBBC04"></path><path d="M10.7019 3.95805C12.1276 3.936 13.5055 4.47247 14.538 5.45722L17.393 2.60218C15.5852 0.904587 13.1858 -0.0287217 10.7019 0.000673888C6.92087 0.000673888 3.46322 2.13185 1.76562 5.51234L5.08732 8.08813C5.87733 5.71811 8.09302 3.95805 10.7019 3.95805V3.95805Z" fill="#EA4335"></path></g><defs><clipPath id="clip0_13183_10121"><rect width="20" height="20" fill="white" transform="translate(0.5)"></rect></clipPath></defs>
                                </svg>
                                <span class="text-black">
                                    Log masuk Google
                                </span>
                            </button>
                        </a>
                    </center>

                    <p class="pt-3 text-sm font-md text-white">
                        Belum mempunyai akaun ? <a href="<?php echo $location_index?>/signup.php" class="font-medium text-white hover:underline -200">Daftar Masuk</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div> 
