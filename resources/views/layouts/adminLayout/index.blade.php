<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ env('APP_NAME', 'Laravel') }} </title>
      @vite(['resources/css/app.css', 'resources/js/app.js'])
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="{{ asset('/1.png') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
        <link href="{{ asset('/admin/assets/css/ccs2.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/admin/assets/css/perfect-scrollbar.min.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/admin/assets/css/style.css') }}">
        <link defer="" rel="stylesheet" type="text/css" media="screen" href="{{ asset('/admin/assets/css/animate.css') }}">
        <script src="{{ asset('/admin/assets/js/perfect-scrollbar.min.js') }}"></script>
        <script defer="" src="{{ asset('/admin/assets/js/popper.min.js') }}"></script>
        <script defer="" src="{{ asset('/admin/assets/js/tippy-bundle.umd.min.js') }}"></script>
        <script defer="" src="{{ asset('/admin/assets/js/sweetalert.min.js') }}"></script>
        <script src="{{ asset('/admin/assets/js/axios.min.js') }}"></script>
          <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('/design/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/design/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Select2 Bootstrap4 Theme -->
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />

     <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('design/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('design/plugins/toastr/toastr.min.css') }}">
        <!-- jQuery (required) -->
<script src="{{ asset('/admin/assets/js/jquery-3.6.0.min.js') }}"></script>


<!-- Select2 Bootstrap 4 theme (optional if you're using bootstrap4) -->
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
    </head>

    <body x-data="main" class="relative overflow-x-hidden font-nunito text-sm font-normal antialiased" :class="[ $store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme === 'dark' || $store.app.isDarkMode ?  'dark' : '', $store.app.menu, $store.app.layout,$store.app.rtlClass]">
        <!-- sidebar menu overlay -->
        <div x-cloak="" class="fixed inset-0 z-50 bg-[black]/60 lg:hidden" :class="{'hidden' : !$store.app.sidebar}" @click="$store.app.toggleSidebar()"></div>

       

        <!-- scroll to top button -->
        <div class="fixed bottom-6 z-50 ltr:right-6 rtl:left-6" x-data="scrollToTop">
            <template x-if="showTopButton">
                <button type="button" class="btn btn-outline-primary animate-pulse rounded-full bg-[#fafafa] p-2 dark:bg-[#060818] dark:hover:bg-primary" @click="goToTop">
                    <svg width="24" height="24" class="h-4 w-4" viewbox="0 0 24 24" fill="none" xmlns="">
                        <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd" d="M12 20.75C12.4142 20.75 12.75 20.4142 12.75 20L12.75 10.75L11.25 10.75L11.25 20C11.25 20.4142 11.5858 20.75 12 20.75Z" fill="currentColor"></path>
                        <path d="M6.00002 10.75C5.69667 10.75 5.4232 10.5673 5.30711 10.287C5.19103 10.0068 5.25519 9.68417 5.46969 9.46967L11.4697 3.46967C11.6103 3.32902 11.8011 3.25 12 3.25C12.1989 3.25 12.3897 3.32902 12.5304 3.46967L18.5304 9.46967C18.7449 9.68417 18.809 10.0068 18.6929 10.287C18.5768 10.5673 18.3034 10.75 18 10.75L6.00002 10.75Z" fill="currentColor"></path>
                    </svg>
                </button>
            </template>
        </div>

        <!-- start theme customizer section -->
        <div x-data="customizer">
            <div class="fixed inset-0 z-[51] hidden bg-[black]/60 px-4 transition-[display]" :class="{'!block': showCustomizer}" @click="showCustomizer = false"></div>

            <nav class="fixed bottom-0 top-0 z-[51] w-full max-w-[400px] bg-white p-4 shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] transition-[right] duration-300 ltr:-right-[400px] rtl:-left-[400px] dark:bg-[#0e1726]" :class="{'ltr:!right-0 rtl:!left-0' : showCustomizer}">
                <a href="javascript:;" class="absolute bottom-0 top-0 my-auto flex h-10 w-12 cursor-pointer items-center justify-center bg-primary text-white ltr:-left-12 ltr:rounded-bl-full ltr:rounded-tl-full rtl:-right-12 rtl:rounded-br-full rtl:rounded-tr-full" @click="showCustomizer = !showCustomizer">
                    <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-[spin_3s_linear_infinite]">
                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5"></circle>
                        <path opacity="0.5" d="M13.7654 2.15224C13.3978 2 12.9319 2 12 2C11.0681 2 10.6022 2 10.2346 2.15224C9.74457 2.35523 9.35522 2.74458 9.15223 3.23463C9.05957 3.45834 9.0233 3.7185 9.00911 4.09799C8.98826 4.65568 8.70226 5.17189 8.21894 5.45093C7.73564 5.72996 7.14559 5.71954 6.65219 5.45876C6.31645 5.2813 6.07301 5.18262 5.83294 5.15102C5.30704 5.08178 4.77518 5.22429 4.35436 5.5472C4.03874 5.78938 3.80577 6.1929 3.33983 6.99993C2.87389 7.80697 2.64092 8.21048 2.58899 8.60491C2.51976 9.1308 2.66227 9.66266 2.98518 10.0835C3.13256 10.2756 3.3397 10.437 3.66119 10.639C4.1338 10.936 4.43789 11.4419 4.43786 12C4.43783 12.5581 4.13375 13.0639 3.66118 13.3608C3.33965 13.5629 3.13248 13.7244 2.98508 13.9165C2.66217 14.3373 2.51966 14.8691 2.5889 15.395C2.64082 15.7894 2.87379 16.193 3.33973 17C3.80568 17.807 4.03865 18.2106 4.35426 18.4527C4.77508 18.7756 5.30694 18.9181 5.83284 18.8489C6.07289 18.8173 6.31632 18.7186 6.65204 18.5412C7.14547 18.2804 7.73556 18.27 8.2189 18.549C8.70224 18.8281 8.98826 19.3443 9.00911 19.9021C9.02331 20.2815 9.05957 20.5417 9.15223 20.7654C9.35522 21.2554 9.74457 21.6448 10.2346 21.8478C10.6022 22 11.0681 22 12 22C12.9319 22 13.3978 22 13.7654 21.8478C14.2554 21.6448 14.6448 21.2554 14.8477 20.7654C14.9404 20.5417 14.9767 20.2815 14.9909 19.902C15.0117 19.3443 15.2977 18.8281 15.781 18.549C16.2643 18.2699 16.8544 18.2804 17.3479 18.5412C17.6836 18.7186 17.927 18.8172 18.167 18.8488C18.6929 18.9181 19.2248 18.7756 19.6456 18.4527C19.9612 18.2105 20.1942 17.807 20.6601 16.9999C21.1261 16.1929 21.3591 15.7894 21.411 15.395C21.4802 14.8691 21.3377 14.3372 21.0148 13.9164C20.8674 13.7243 20.6602 13.5628 20.3387 13.3608C19.8662 13.0639 19.5621 12.558 19.5621 11.9999C19.5621 11.4418 19.8662 10.9361 20.3387 10.6392C20.6603 10.4371 20.8675 10.2757 21.0149 10.0835C21.3378 9.66273 21.4803 9.13087 21.4111 8.60497C21.3592 8.21055 21.1262 7.80703 20.6602 7C20.1943 6.19297 19.9613 5.78945 19.6457 5.54727C19.2249 5.22436 18.693 5.08185 18.1671 5.15109C17.9271 5.18269 17.6837 5.28136 17.3479 5.4588C16.8545 5.71959 16.2644 5.73002 15.7811 5.45096C15.2977 5.17191 15.0117 4.65566 14.9909 4.09794C14.9767 3.71848 14.9404 3.45833 14.8477 3.23463C14.6448 2.74458 14.2554 2.35523 13.7654 2.15224Z" stroke="currentColor" stroke-width="1.5"></path>
                    </svg>
                </a>
                <div class="perfect-scrollbar h-full overflow-y-auto overflow-x-hidden">
                    <div class="relative pb-5 text-center">
                        <a href="javascript:;" class="absolute top-0 opacity-30 hover:opacity-100 ltr:right-0 rtl:left-0 dark:text-white" @click="showCustomizer = false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </a>
                        <h4 class="mb-1 dark:text-white">TEMPLATE CUSTOMIZER</h4>
                        <p class="text-white-dark">Set preferences that will be cookied for your live preview demonstration.</p>
                    </div>
                    <div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                        <h5 class="mb-1 text-base leading-none dark:text-white">Color Scheme</h5>
                        <p class="text-xs text-white-dark">Overall light or dark presentation.</p>
                        <div class="mt-3 grid grid-cols-3 gap-2">
                            <button type="button" class="btn" :class="[$store.app.theme === 'light' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleTheme('light')">
                                <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 ltr:mr-2 rtl:ml-2">
                                    <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5"></circle>
                                    <path d="M12 2V4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path d="M12 20V22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path d="M4 12L2 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path d="M22 12L20 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path opacity="0.5" d="M19.7778 4.22266L17.5558 6.25424" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path opacity="0.5" d="M4.22217 4.22266L6.44418 6.25424" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path opacity="0.5" d="M6.44434 17.5557L4.22211 19.7779" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path opacity="0.5" d="M19.7778 19.7773L17.5558 17.5551" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg>
                                Light
                            </button>
                            <button type="button" class="btn" :class="[$store.app.theme === 'dark' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleTheme('dark')">
                                <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 ltr:mr-2 rtl:ml-2">
                                    <path d="M21.0672 11.8568L20.4253 11.469L21.0672 11.8568ZM12.1432 2.93276L11.7553 2.29085V2.29085L12.1432 2.93276ZM21.25 12C21.25 17.1086 17.1086 21.25 12 21.25V22.75C17.9371 22.75 22.75 17.9371 22.75 12H21.25ZM12 21.25C6.89137 21.25 2.75 17.1086 2.75 12H1.25C1.25 17.9371 6.06294 22.75 12 22.75V21.25ZM2.75 12C2.75 6.89137 6.89137 2.75 12 2.75V1.25C6.06294 1.25 1.25 6.06294 1.25 12H2.75ZM15.5 14.25C12.3244 14.25 9.75 11.6756 9.75 8.5H8.25C8.25 12.5041 11.4959 15.75 15.5 15.75V14.25ZM20.4253 11.469C19.4172 13.1373 17.5882 14.25 15.5 14.25V15.75C18.1349 15.75 20.4407 14.3439 21.7092 12.2447L20.4253 11.469ZM9.75 8.5C9.75 6.41182 10.8627 4.5828 12.531 3.57467L11.7553 2.29085C9.65609 3.5593 8.25 5.86509 8.25 8.5H9.75ZM12 2.75C11.9115 2.75 11.8077 2.71008 11.7324 2.63168C11.6686 2.56527 11.6538 2.50244 11.6503 2.47703C11.6461 2.44587 11.6482 2.35557 11.7553 2.29085L12.531 3.57467C13.0342 3.27065 13.196 2.71398 13.1368 2.27627C13.0754 1.82126 12.7166 1.25 12 1.25V2.75ZM21.7092 12.2447C21.6444 12.3518 21.5541 12.3539 21.523 12.3497C21.4976 12.3462 21.4347 12.3314 21.3683 12.2676C21.2899 12.1923 21.25 12.0885 21.25 12H22.75C22.75 11.2834 22.1787 10.9246 21.7237 10.8632C21.286 10.804 20.7293 10.9658 20.4253 11.469L21.7092 12.2447Z" fill="currentColor"></path>
                                </svg>
                                Dark
                            </button>
                            <button type="button" class="btn" :class="[$store.app.theme === 'system' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleTheme('system')">
                                <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 ltr:mr-2 rtl:ml-2">
                                    <path d="M3 9C3 6.17157 3 4.75736 3.87868 3.87868C4.75736 3 6.17157 3 9 3H15C17.8284 3 19.2426 3 20.1213 3.87868C21 4.75736 21 6.17157 21 9V14C21 15.8856 21 16.8284 20.4142 17.4142C19.8284 18 18.8856 18 17 18H7C5.11438 18 4.17157 18 3.58579 17.4142C3 16.8284 3 15.8856 3 14V9Z" stroke="currentColor" stroke-width="1.5"></path>
                                    <path opacity="0.5" d="M22 21H2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path opacity="0.5" d="M15 15H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg>
                                System
                            </button>
                        </div>
                    </div>

                    <div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                        <h5 class="mb-1 text-base leading-none dark:text-white">Navigation Position</h5>
                        <p class="text-xs text-white-dark">Select the primary navigation paradigm for your app.</p>
                        <div class="mt-3 grid grid-cols-3 gap-2">
                            <button type="button" class="btn" :class="[$store.app.menu === 'horizontal' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleMenu('horizontal')">
                                Horizontal
                            </button>
                            <button type="button" class="btn" :class="[$store.app.menu === 'vertical' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleMenu('vertical')">
                                Vertical
                            </button>
                            <button type="button" class="btn" :class="[$store.app.menu === 'collapsible-vertical' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleMenu('collapsible-vertical')">
                                Collapsible
                            </button>
                        </div>
                        <div class="mt-5 text-primary">
                            <label class="mb-0 inline-flex">
                                <input x-model="$store.app.semidark" type="checkbox" :value="true" class="form-checkbox" @change="$store.app.toggleSemidark()">
                                <span>Semi Dark (Sidebar & Header)</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                        <h5 class="mb-1 text-base leading-none dark:text-white">Layout Style</h5>
                        <p class="text-xs text-white-dark">Select the primary layout style for your app.</p>
                        <div class="mt-3 flex gap-2">
                            <button type="button" class="btn flex-auto" :class="[$store.app.layout === 'boxed-layout' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleLayout('boxed-layout')">
                                Box
                            </button>
                            <button type="button" class="btn flex-auto" :class="[$store.app.layout === 'full' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleLayout('full')">
                                Full
                            </button>
                        </div>
                    </div>
                    <div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                        <h5 class="mb-1 text-base leading-none dark:text-white">Direction</h5>
                        <p class="text-xs text-white-dark">Select the direction for your app.</p>
                        <div class="mt-3 flex gap-2">
                            <button type="button" class="btn flex-auto" :class="[$store.app.rtlClass === 'ltr' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleRTL('ltr')">
                                LTR
                            </button>
                            <button type="button" class="btn flex-auto" :class="[$store.app.rtlClass === 'rtl' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleRTL('rtl')">
                                RTL
                            </button>
                        </div>
                    </div>

                    <div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                        <h5 class="mb-1 text-base leading-none dark:text-white">Navbar Type</h5>
                        <p class="text-xs text-white-dark">Sticky or Floating.</p>
                        <div class="mt-3 flex items-center gap-3 text-primary">
                            <label class="mb-0 inline-flex">
                                <input x-model="$store.app.navbar" type="radio" value="navbar-sticky" class="form-radio" @change="$store.app.toggleNavbar()">
                                <span>Sticky</span>
                            </label>
                            <label class="mb-0 inline-flex">
                                <input x-model="$store.app.navbar" type="radio" value="navbar-floating" class="form-radio" @change="$store.app.toggleNavbar()">
                                <span>Floating</span>
                            </label>
                            <label class="mb-0 inline-flex">
                                <input x-model="$store.app.navbar" type="radio" value="navbar-static" class="form-radio" @change="$store.app.toggleNavbar()">
                                <span>Static</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                        <h5 class="mb-1 text-base leading-none dark:text-white">Router Transition</h5>
                        <p class="text-xs text-white-dark">Animation of main content.</p>
                        <div class="mt-3">
                            <select x-model="$store.app.animation" class="form-select border-primary text-primary" @change="$store.app.toggleAnimation()">
                                <option value="">None</option>
                                <option value="animate__fadeIn">Fade</option>
                                <option value="animate__fadeInDown">Fade Down</option>
                                <option value="animate__fadeInUp">Fade Up</option>
                                <option value="animate__fadeInLeft">Fade Left</option>
                                <option value="animate__fadeInRight">Fade Right</option>
                                <option value="animate__slideInDown">Slide Down</option>
                                <option value="animate__slideInLeft">Slide Left</option>
                                <option value="animate__slideInRight">Slide Right</option>
                                <option value="animate__zoomIn">Zoom In</option>
                            </select>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- end theme customizer section -->

        <div class="main-container min-h-screen text-black dark:text-white-dark" :class="[$store.app.navbar]">
            <!-- start sidebar section -->
            
            @include('layouts.adminLayout.sidebar')

            <!-- end sidebar section -->

            <div class="main-content flex min-h-screen flex-col">
                <!-- start header section -->
                <header class="z-40" :class="{'dark' : $store.app.semidark && $store.app.menu === 'horizontal'}">
                    <div class="shadow-sm">
                        <div class="relative flex w-full items-center bg-white px-5 py-2.5 dark:bg-[#0e1726]">
                            <div class="horizontal-logo flex items-center justify-between ltr:mr-2 rtl:ml-2 lg:hidden">
                                <a href="" class="main-logo flex shrink-0 items-center">
                                    <img class="ml-[10px] w-20 flex-none" src="{{ asset('/1.png') }}" alt="image">
                                    <span class="align-middle text-2xl font-semibold ltr:ml-1.5 rtl:mr-1.5 dark:text-white-light lg:inline">iBarangay</span>                               </a>

                                <a href="javascript:;" class="collapse-icon flex flex-none rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary ltr:ml-2 rtl:mr-2 dark:bg-dark/40 dark:text-[#d0d2d6] dark:hover:bg-dark/60 dark:hover:text-primary lg:hidden" @click="$store.app.toggleSidebar()">
                                    <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20 7L4 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                        <path opacity="0.5" d="M20 12L4 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                        <path d="M20 17L4 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>
                                </a>
                            </div>
                            <div class="hidden ltr:mr-2 rtl:ml-2 sm:block">
                                <ul class="flex items-center space-x-2 rtl:space-x-reverse dark:text-[#d0d2d6]">
                                    <li>
                                        <a href="apps-calendar.html" class="block rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60">
                                            <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H14C17.7712 4 19.6569 4 20.8284 5.17157C22 6.34315 22 8.22876 22 12V14C22 17.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V12Z" stroke="currentColor" stroke-width="1.5"></path>
                                                <path opacity="0.5" d="M7 4V2.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                                <path opacity="0.5" d="M17 4V2.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                                <path opacity="0.5" d="M2 9H22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="apps-todolist.html" class="block rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60">
                                            <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.5" d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                                <path d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z" stroke="currentColor" stroke-width="1.5"></path>
                                                <path opacity="0.5" d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9" stroke="currentColor" stroke-width="1.5"></path>
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="apps-chat.html" class="block rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60">
                                            <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle r="3" transform="matrix(-1 0 0 1 19 5)" stroke="currentColor" stroke-width="1.5"></circle>
                                                <path opacity="0.5" d="M14 2.20004C13.3538 2.06886 12.6849 2 12 2C6.47715 2 2 6.47715 2 12C2 13.5997 2.37562 15.1116 3.04346 16.4525C3.22094 16.8088 3.28001 17.2161 3.17712 17.6006L2.58151 19.8267C2.32295 20.793 3.20701 21.677 4.17335 21.4185L6.39939 20.8229C6.78393 20.72 7.19121 20.7791 7.54753 20.9565C8.88837 21.6244 10.4003 22 12 22C17.5228 22 22 17.5228 22 12C22 11.3151 21.9311 10.6462 21.8 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div x-data="header" class="flex items-center space-x-1.5 ltr:ml-auto rtl:mr-auto rtl:space-x-reverse dark:text-[#d0d2d6] sm:flex-1 ltr:sm:ml-0 sm:rtl:mr-0 lg:space-x-2">
                                <div class="sm:ltr:mr-auto sm:rtl:ml-auto" x-data="{ search: false }" @click.outside="search = false">
                                    <form class="absolute inset-x-0 top-1/2 z-10 mx-4 hidden -translate-y-1/2 sm:relative sm:top-0 sm:mx-0 sm:block sm:translate-y-0" :class="{'!block' : search}" @submit.prevent="search = false">
                                        <div class="relative">
                                            <input type="text" class="peer form-input bg-gray-100 placeholder:tracking-widest ltr:pl-9 ltr:pr-9 rtl:pl-9 rtl:pr-9 sm:bg-transparent ltr:sm:pr-4 rtl:sm:pl-4" placeholder="Search...">
                                            <button type="button" class="absolute inset-0 h-9 w-9 appearance-none peer-focus:text-primary ltr:right-auto rtl:left-auto">
                                                <svg class="mx-auto" width="16" height="16" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor" stroke-width="1.5" opacity="0.5"></circle>
                                                    <path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                                </svg>
                                            </button>
                                            <button type="button" class="absolute top-1/2 block -translate-y-1/2 hover:opacity-80 ltr:right-2 rtl:left-2 sm:hidden" @click="search = false">
                                                <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"></circle>
                                                    <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                    <button type="button" class="search_btn rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 dark:bg-dark/40 dark:hover:bg-dark/60 sm:hidden" @click="search = ! search">
                                        <svg class="mx-auto h-4.5 w-4.5 dark:text-[#d0d2d6]" width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor" stroke-width="1.5" opacity="0.5"></circle>
                                            <path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div>
                                    <a href="javascript:;" x-cloak="" x-show="$store.app.theme === 'light'" href="javascript:;" class="flex items-center rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60" @click="$store.app.toggleTheme('dark')">
                                        <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5"></circle>
                                            <path d="M12 2V4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path d="M12 20V22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path d="M4 12L2 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path d="M22 12L20 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path opacity="0.5" d="M19.7778 4.22266L17.5558 6.25424" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path opacity="0.5" d="M4.22217 4.22266L6.44418 6.25424" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path opacity="0.5" d="M6.44434 17.5557L4.22211 19.7779" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path opacity="0.5" d="M19.7778 19.7773L17.5558 17.5551" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </a>
                                    <a href="javascript:;" x-cloak="" x-show="$store.app.theme === 'dark'" href="javascript:;" class="flex items-center rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60" @click="$store.app.toggleTheme('system')">
                                        <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.0672 11.8568L20.4253 11.469L21.0672 11.8568ZM12.1432 2.93276L11.7553 2.29085V2.29085L12.1432 2.93276ZM21.25 12C21.25 17.1086 17.1086 21.25 12 21.25V22.75C17.9371 22.75 22.75 17.9371 22.75 12H21.25ZM12 21.25C6.89137 21.25 2.75 17.1086 2.75 12H1.25C1.25 17.9371 6.06294 22.75 12 22.75V21.25ZM2.75 12C2.75 6.89137 6.89137 2.75 12 2.75V1.25C6.06294 1.25 1.25 6.06294 1.25 12H2.75ZM15.5 14.25C12.3244 14.25 9.75 11.6756 9.75 8.5H8.25C8.25 12.5041 11.4959 15.75 15.5 15.75V14.25ZM20.4253 11.469C19.4172 13.1373 17.5882 14.25 15.5 14.25V15.75C18.1349 15.75 20.4407 14.3439 21.7092 12.2447L20.4253 11.469ZM9.75 8.5C9.75 6.41182 10.8627 4.5828 12.531 3.57467L11.7553 2.29085C9.65609 3.5593 8.25 5.86509 8.25 8.5H9.75ZM12 2.75C11.9115 2.75 11.8077 2.71008 11.7324 2.63168C11.6686 2.56527 11.6538 2.50244 11.6503 2.47703C11.6461 2.44587 11.6482 2.35557 11.7553 2.29085L12.531 3.57467C13.0342 3.27065 13.196 2.71398 13.1368 2.27627C13.0754 1.82126 12.7166 1.25 12 1.25V2.75ZM21.7092 12.2447C21.6444 12.3518 21.5541 12.3539 21.523 12.3497C21.4976 12.3462 21.4347 12.3314 21.3683 12.2676C21.2899 12.1923 21.25 12.0885 21.25 12H22.75C22.75 11.2834 22.1787 10.9246 21.7237 10.8632C21.286 10.804 20.7293 10.9658 20.4253 11.469L21.7092 12.2447Z" fill="currentColor"></path>
                                        </svg>
                                    </a>
                                    <a href="javascript:;" x-cloak="" x-show="$store.app.theme === 'system'" href="javascript:;" class="flex items-center rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60" @click="$store.app.toggleTheme('light')">
                                        <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 9C3 6.17157 3 4.75736 3.87868 3.87868C4.75736 3 6.17157 3 9 3H15C17.8284 3 19.2426 3 20.1213 3.87868C21 4.75736 21 6.17157 21 9V14C21 15.8856 21 16.8284 20.4142 17.4142C19.8284 18 18.8856 18 17 18H7C5.11438 18 4.17157 18 3.58579 17.4142C3 16.8284 3 15.8856 3 14V9Z" stroke="currentColor" stroke-width="1.5"></path>
                                            <path opacity="0.5" d="M22 21H2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path opacity="0.5" d="M15 15H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                    </a>
                                </div>

                                <div class="dropdown shrink-0" x-data="dropdown" @click.outside="open = false">
                                    <a href="javascript:;" class="block rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60" @click="toggle">
                                        <img :src="`assets/images/flags/${$store.app.locale.toUpperCase()}.svg`" alt="image" class="h-5 w-5 rounded-full object-cover">
                                    </a>
                                    <ul x-cloak="" x-show="open" x-transition="" x-transition.duration.300ms="" class="top-11 grid w-[280px] grid-cols-2 gap-y-2 !px-2 font-semibold text-dark ltr:-right-14 rtl:-left-14 dark:text-white-dark dark:text-white-light/90 sm:ltr:-right-2 sm:rtl:-left-2">
                                        <template x-for="item in languages">
                                            <li>
                                                <a href="javascript:;" class="hover:text-primary" @click="$store.app.toggleLocale(item.value),toggle()" :class="{'bg-primary/10 text-primary' : $store.app.locale == item.value}">
                                                    <img class="h-5 w-5 rounded-full object-cover" :src="`assets/images/flags/${item.value.toUpperCase()}.svg`" alt="image">
                                                    <span class="ltr:ml-3 rtl:mr-3" x-text="item.key"></span>
                                                </a>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                                <div class="dropdown flex-shrink-0" x-data="dropdown" @click.outside="open = false">
                                    <a href="javascript:;" class="group relative" @click="toggle()">
                                        <span><img class="h-9 w-9 rounded-full object-cover saturate-50 group-hover:saturate-100" src="assets/images/user-profile.jpeg" alt="image"></span>
                                    </a>
                                    <ul x-cloak="" x-show="open" x-transition="" x-transition.duration.300ms="" class="top-11 w-[230px] !py-0 font-semibold text-dark ltr:right-0 rtl:left-0 dark:text-white-dark dark:text-white-light/90">
                                        <li>
                                            <div class="flex items-center px-4 py-4">
                                               
                                                <div class="truncate ltr:pl-4 rtl:pr-4">
                                                    <h4 class="text-base">
                                                        {{ Auth::user()->name }} <span class="rounded bg-success-light px-1 text-xs text-success ltr:ml-2 rtl:ml-2"></span>
                                                    </h4>
                                                    <a class="text-black/60 hover:text-primary dark:text-dark-light/60 dark:hover:text-white" href="javascript:;">{{ Auth::user()->gmail }} </a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="{{ route('profile.edit') }}" class="dark:hover:text-white" @click="toggle">
                                                <svg class="h-4.5 w-4.5 shrink-0 ltr:mr-2 rtl:ml-2" width="18" height="18" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="12" cy="6" r="4" stroke="currentColor" stroke-width="1.5"></circle>
                                                    <path opacity="0.5" d="M20 17.5C20 19.9853 20 22 12 22C4 22 4 19.9853 4 17.5C4 15.0147 7.58172 13 12 13C16.4183 13 20 15.0147 20 17.5Z" stroke="currentColor" stroke-width="1.5"></path>
                                                </svg>
                                                Profile</a>
                                        </li>
                                        <li class="border-t border-white-light dark:border-white-light/10">
                                           
                                            <form method="POST" action="{{ route('logout') }}" class="logout-form flex items-center">
                                                @csrf
                                                <svg class="h-4.5 w-4.5 shrink-0 rotate-90 ltr:mr-2 rtl:ml-2" width="18" height="18" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.5" d="M17 9.00195C19.175 9.01406 20.3529 9.11051 21.1213 9.8789C22 10.7576 22 12.1718 22 15.0002V16.0002C22 18.8286 22 20.2429 21.1213 21.1215C20.2426 22.0002 18.8284 22.0002 16 22.0002H8C5.17157 22.0002 3.75736 22.0002 2.87868 21.1215C2 20.2429 2 18.8286 2 16.0002L2 15.0002C2 12.1718 2 10.7576 2.87868 9.87889C3.64706 9.11051 4.82497 9.01406 7 9.00195" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                                    <path d="M12 15L12 2M12 2L15 5.5M12 2L9 5.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                                <button type="submit" class="!py-3 text-danger" @click="toggle">
                                                    Sign Out
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- horizontal menu -->
                        <ul class="horizontal-menu hidden border-t border-[#ebedf2] bg-white px-6 py-1.5 font-semibold text-black rtl:space-x-reverse dark:border-[#191e3a] dark:bg-[#0e1726] dark:text-white-dark lg:space-x-1.5 xl:space-x-8">
                            <li class="menu nav-item relative">
                                <a href="javascript:;" class="nav-link active">
                                    <div class="flex items-center">
                                        <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                                            <path opacity="0.5" d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z" fill="currentColor"></path>
                                            <path d="M9 17.25C8.58579 17.25 8.25 17.5858 8.25 18C8.25 18.4142 8.58579 18.75 9 18.75H15C15.4142 18.75 15.75 18.4142 15.75 18C15.75 17.5858 15.4142 17.25 15 17.25H9Z" fill="currentColor"></path>
                                        </svg>
                                        <span class="px-1">Dashboard</span>
                                    </div>
                                    <div class="right_arrow">
                                        <svg class="h-4 w-4 rotate-90" width="16" height="16" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="index.html" class="active">Sales</a>
                                    </li>
                                    <li>
                                        <a href="analytics.html">Analytics</a>
                                    </li>
                                    <li>
                                        <a href="finance.html">Finance</a>
                                    </li>
                                    <li>
                                        <a href="crypto.html">Crypto</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu nav-item relative">
                                <a href="javascript:;" class="nav-link">
                                    <div class="flex items-center">
                                        <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                                            <g opacity="0.5">
                                                <path d="M14 2.75C15.9068 2.75 17.2615 2.75159 18.2892 2.88976C19.2952 3.02503 19.8749 3.27869 20.2981 3.7019C20.7213 4.12511 20.975 4.70476 21.1102 5.71085C21.2484 6.73851 21.25 8.09318 21.25 10C21.25 10.4142 21.5858 10.75 22 10.75C22.4142 10.75 22.75 10.4142 22.75 10V9.94359C22.75 8.10583 22.75 6.65019 22.5969 5.51098C22.4392 4.33856 22.1071 3.38961 21.3588 2.64124C20.6104 1.89288 19.6614 1.56076 18.489 1.40314C17.3498 1.24997 15.8942 1.24998 14.0564 1.25H14C13.5858 1.25 13.25 1.58579 13.25 2C13.25 2.41421 13.5858 2.75 14 2.75Z" fill="currentColor"></path>
                                                <path d="M9.94358 1.25H10C10.4142 1.25 10.75 1.58579 10.75 2C10.75 2.41421 10.4142 2.75 10 2.75C8.09318 2.75 6.73851 2.75159 5.71085 2.88976C4.70476 3.02503 4.12511 3.27869 3.7019 3.7019C3.27869 4.12511 3.02503 4.70476 2.88976 5.71085C2.75159 6.73851 2.75 8.09318 2.75 10C2.75 10.4142 2.41421 10.75 2 10.75C1.58579 10.75 1.25 10.4142 1.25 10V9.94358C1.24998 8.10583 1.24997 6.65019 1.40314 5.51098C1.56076 4.33856 1.89288 3.38961 2.64124 2.64124C3.38961 1.89288 4.33856 1.56076 5.51098 1.40314C6.65019 1.24997 8.10583 1.24998 9.94358 1.25Z" fill="currentColor"></path>
                                                <path d="M22 13.25C22.4142 13.25 22.75 13.5858 22.75 14V14.0564C22.75 15.8942 22.75 17.3498 22.5969 18.489C22.4392 19.6614 22.1071 20.6104 21.3588 21.3588C20.6104 22.1071 19.6614 22.4392 18.489 22.5969C17.3498 22.75 15.8942 22.75 14.0564 22.75H14C13.5858 22.75 13.25 22.4142 13.25 22C13.25 21.5858 13.5858 21.25 14 21.25C15.9068 21.25 17.2615 21.2484 18.2892 21.1102C19.2952 20.975 19.8749 20.7213 20.2981 20.2981C20.7213 19.8749 20.975 19.2952 21.1102 18.2892C21.2484 17.2615 21.25 15.9068 21.25 14C21.25 13.5858 21.5858 13.25 22 13.25Z" fill="currentColor"></path>
                                                <path d="M2.75 14C2.75 13.5858 2.41421 13.25 2 13.25C1.58579 13.25 1.25 13.5858 1.25 14V14.0564C1.24998 15.8942 1.24997 17.3498 1.40314 18.489C1.56076 19.6614 1.89288 20.6104 2.64124 21.3588C3.38961 22.1071 4.33856 22.4392 5.51098 22.5969C6.65019 22.75 8.10583 22.75 9.94359 22.75H10C10.4142 22.75 10.75 22.4142 10.75 22C10.75 21.5858 10.4142 21.25 10 21.25C8.09318 21.25 6.73851 21.2484 5.71085 21.1102C4.70476 20.975 4.12511 20.7213 3.7019 20.2981C3.27869 19.8749 3.02503 19.2952 2.88976 18.2892C2.75159 17.2615 2.75 15.9068 2.75 14Z" fill="currentColor"></path>
                                            </g>
                                            <path d="M5.52721 5.52721C5 6.05442 5 6.90294 5 8.6C5 9.73137 5 10.2971 5.35147 10.6485C5.70294 11 6.26863 11 7.4 11H8.6C9.73137 11 10.2971 11 10.6485 10.6485C11 10.2971 11 9.73137 11 8.6V7.4C11 6.26863 11 5.70294 10.6485 5.35147C10.2971 5 9.73137 5 8.6 5C6.90294 5 6.05442 5 5.52721 5.52721Z" fill="currentColor"></path>
                                            <path d="M5.52721 18.4728C5 17.9456 5 17.0971 5 15.4C5 14.2686 5 13.7029 5.35147 13.3515C5.70294 13 6.26863 13 7.4 13H8.6C9.73137 13 10.2971 13 10.6485 13.3515C11 13.7029 11 14.2686 11 15.4V16.6C11 17.7314 11 18.2971 10.6485 18.6485C10.2971 19 9.73138 19 8.60002 19C6.90298 19 6.05441 19 5.52721 18.4728Z" fill="currentColor"></path>
                                            <path d="M13 7.4C13 6.26863 13 5.70294 13.3515 5.35147C13.7029 5 14.2686 5 15.4 5C17.0971 5 17.9456 5 18.4728 5.52721C19 6.05442 19 6.90294 19 8.6C19 9.73137 19 10.2971 18.6485 10.6485C18.2971 11 17.7314 11 16.6 11H15.4C14.2686 11 13.7029 11 13.3515 10.6485C13 10.2971 13 9.73137 13 8.6V7.4Z" fill="currentColor"></path>
                                            <path d="M13.3515 18.6485C13 18.2971 13 17.7314 13 16.6V15.4C13 14.2686 13 13.7029 13.3515 13.3515C13.7029 13 14.2686 13 15.4 13H16.6C17.7314 13 18.2971 13 18.6485 13.3515C19 13.7029 19 14.2686 19 15.4C19 17.097 19 17.9456 18.4728 18.4728C17.9456 19 17.0971 19 15.4 19C14.2687 19 13.7029 19 13.3515 18.6485Z" fill="currentColor"></path>
                                        </svg>
                                        <span class="px-1">Apps</span>
                                    </div>
                                    <div class="right_arrow">
                                        <svg class="h-4 w-4 rotate-90" width="16" height="16" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="apps-chat.html">Chat</a>
                                    </li>
                                    <li>
                                        <a href="apps-mailbox.html">Mailbox</a>
                                    </li>
                                    <li>
                                        <a href="apps-todolist.html">Todo List</a>
                                    </li>
                                    <li>
                                        <a href="apps-notes.html">Notes</a>
                                    </li>
                                    <li>
                                        <a href="apps-scrumboard.html">Scrumboard</a>
                                    </li>
                                    <li>
                                        <a href="apps-contacts.html">Contacts</a>
                                    </li>
                                    <li class="relative">
                                        <a href="javascript:;">Invoice
                                            <div class="ltr:ml-auto rtl:mr-auto rtl:rotate-180">
                                                <svg width="16" height="16" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </div>
                                        </a>
                                        <ul class="absolute top-0 z-[10] hidden min-w-[180px] rounded bg-white p-0 py-2 text-dark shadow ltr:left-[95%] rtl:right-[95%] dark:bg-[#1b2e4b] dark:text-white-dark">
                                            <li>
                                                <a href="apps-invoice-list.html">List</a>
                                            </li>
                                            <li>
                                                <a href="apps-invoice-preview.html">Preview</a>
                                            </li>
                                            <li>
                                                <a href="apps-invoice-add.html">Add</a>
                                            </li>
                                            <li>
                                                <a href="apps-invoice-edit.html">Edit</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="apps-calendar.html">Calendar</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu nav-item relative">
                                <a href="javascript:;" class="nav-link">
                                    <div class="flex items-center">
                                        <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                                            <path d="M8.42229 20.6181C10.1779 21.5395 11.0557 22.0001 12 22.0001V12.0001L2.63802 7.07275C2.62423 7.09491 2.6107 7.11727 2.5974 7.13986C2 8.15436 2 9.41678 2 11.9416V12.0586C2 14.5834 2 15.8459 2.5974 16.8604C3.19479 17.8749 4.27063 18.4395 6.42229 19.5686L8.42229 20.6181Z" fill="currentColor"></path>
                                            <path opacity="0.7" d="M17.5774 4.43152L15.5774 3.38197C13.8218 2.46066 12.944 2 11.9997 2C11.0554 2 10.1776 2.46066 8.42197 3.38197L6.42197 4.43152C4.31821 5.53552 3.24291 6.09982 2.6377 7.07264L11.9997 12L21.3617 7.07264C20.7564 6.09982 19.6811 5.53552 17.5774 4.43152Z" fill="currentColor"></path>
                                            <path opacity="0.5" d="M21.4026 7.13986C21.3893 7.11727 21.3758 7.09491 21.362 7.07275L12 12.0001V22.0001C12.9443 22.0001 13.8221 21.5395 15.5777 20.6181L17.5777 19.5686C19.7294 18.4395 20.8052 17.8749 21.4026 16.8604C22 15.8459 22 14.5834 22 12.0586V11.9416C22 9.41678 22 8.15436 21.4026 7.13986Z" fill="currentColor"></path>
                                        </svg>
                                        <span class="px-1">Components</span>
                                    </div>
                                    <div class="right_arrow">
                                        <svg class="h-4 w-4 rotate-90" width="16" height="16" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="components-tabs.html">Tabs</a>
                                    </li>
                                    <li>
                                        <a href="components-accordions.html">Accordions</a>
                                    </li>
                                    <li>
                                        <a href="components-modals.html">Modals</a>
                                    </li>
                                    <li>
                                        <a href="components-cards.html">Cards</a>
                                    </li>
                                    <li>
                                        <a href="components-carousel.html">Carousel</a>
                                    </li>
                                    <li>
                                        <a href="components-countdown.html">Countdown</a>
                                    </li>
                                    <li>
                                        <a href="components-counter.html">Counter</a>
                                    </li>
                                    <li>
                                        <a href="components-sweetalert.html">Sweet Alerts</a>
                                    </li>
                                    <li>
                                        <a href="components-timeline.html">Timeline</a>
                                    </li>
                                    <li>
                                        <a href="components-notifications.html">Notifications</a>
                                    </li>
                                    <li>
                                        <a href="components-media-object.html">Media Object</a>
                                    </li>
                                    <li>
                                        <a href="components-list-group.html">List Group</a>
                                    </li>
                                    <li>
                                        <a href="components-pricing-table.html">Pricing Tables</a>
                                    </li>
                                    <li>
                                        <a href="components-lightbox.html">Lightbox</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu nav-item relative">
                                <a href="javascript:;" class="nav-link">
                                    <div class="flex items-center">
                                        <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.73167 5.77133L5.66953 9.91436C4.3848 11.6526 3.74244 12.5217 4.09639 13.205C4.10225 13.2164 4.10829 13.2276 4.1145 13.2387C4.48945 13.9117 5.59888 13.9117 7.81775 13.9117C9.05079 13.9117 9.6673 13.9117 10.054 14.2754L10.074 14.2946L13.946 9.72466L13.926 9.70541C13.5474 9.33386 13.5474 8.74151 13.5474 7.55682V7.24712C13.5474 3.96249 13.5474 2.32018 12.6241 2.03721C11.7007 1.75425 10.711 3.09327 8.73167 5.77133Z" fill="currentColor"></path>
                                            <path opacity="0.5" d="M10.4527 16.4432L10.4527 16.7528C10.4527 20.0374 10.4527 21.6798 11.376 21.9627C12.2994 22.2457 13.2891 20.9067 15.2685 18.2286L18.3306 14.0856C19.6154 12.3474 20.2577 11.4783 19.9038 10.7949C19.8979 10.7836 19.8919 10.7724 19.8857 10.7613C19.5107 10.0883 18.4013 10.0883 16.1824 10.0883C14.9494 10.0883 14.3329 10.0883 13.9462 9.72461L10.0742 14.2946C10.4528 14.6661 10.4527 15.2585 10.4527 16.4432Z" fill="currentColor"></path>
                                        </svg>
                                        <span class="px-1">Elements</span>
                                    </div>
                                    <div class="right_arrow">
                                        <svg class="h-4 w-4 rotate-90" width="16" height="16" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="elements-alerts.html">Alerts</a>
                                    </li>
                                    <li>
                                        <a href="elements-avatar.html">Avatar</a>
                                    </li>
                                    <li>
                                        <a href="elements-badges.html">Badges</a>
                                    </li>
                                    <li>
                                        <a href="elements-breadcrumbs.html">Breadcrumbs</a>
                                    </li>
                                    <li>
                                        <a href="elements-buttons.html">Buttons</a>
                                    </li>
                                    <li>
                                        <a href="elements-buttons-group.html">Button Groups</a>
                                    </li>
                                    <li>
                                        <a href="elements-color-library.html">Color Library</a>
                                    </li>
                                    <li>
                                        <a href="elements-dropdown.html">Dropdown</a>
                                    </li>
                                    <li>
                                        <a href="elements-infobox.html">Infobox</a>
                                    </li>
                                    <li>
                                        <a href="elements-jumbotron.html">Jumbotron</a>
                                    </li>
                                    <li>
                                        <a href="elements-loader.html">Loader</a>
                                    </li>
                                    <li>
                                        <a href="elements-pagination.html">Pagination</a>
                                    </li>
                                    <li>
                                        <a href="elements-popovers.html">Popovers</a>
                                    </li>
                                    <li>
                                        <a href="elements-progress-bar.html">Progress Bar</a>
                                    </li>
                                    <li>
                                        <a href="elements-search.html">Search</a>
                                    </li>
                                    <li>
                                        <a href="elements-tooltips.html">Tooltips</a>
                                    </li>
                                    <li>
                                        <a href="elements-treeview.html">Treeview</a>
                                    </li>
                                    <li>
                                        <a href="elements-typography.html">Typography</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu nav-item relative">
                                <a href="javascript:;" class="nav-link">
                                    <div class="flex items-center">
                                        <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                                            <path d="M4.97883 9.68508C2.99294 8.89073 2 8.49355 2 8C2 7.50645 2.99294 7.10927 4.97883 6.31492L7.7873 5.19153C9.77318 4.39718 10.7661 4 12 4C13.2339 4 14.2268 4.39718 16.2127 5.19153L19.0212 6.31492C21.0071 7.10927 22 7.50645 22 8C22 8.49355 21.0071 8.89073 19.0212 9.68508L16.2127 10.8085C14.2268 11.6028 13.2339 12 12 12C10.7661 12 9.77318 11.6028 7.7873 10.8085L4.97883 9.68508Z" fill="currentColor"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2 8C2 8.49355 2.99294 8.89073 4.97883 9.68508L7.7873 10.8085C9.77318 11.6028 10.7661 12 12 12C13.2339 12 14.2268 11.6028 16.2127 10.8085L19.0212 9.68508C21.0071 8.89073 22 8.49355 22 8C22 7.50645 21.0071 7.10927 19.0212 6.31492L16.2127 5.19153C14.2268 4.39718 13.2339 4 12 4C10.7661 4 9.77318 4.39718 7.7873 5.19153L4.97883 6.31492C2.99294 7.10927 2 7.50645 2 8Z" fill="currentColor"></path>
                                            <path opacity="0.7" d="M5.76613 10L4.97883 10.3149C2.99294 11.1093 2 11.5065 2 12C2 12.4935 2.99294 12.8907 4.97883 13.6851L7.7873 14.8085C9.77318 15.6028 10.7661 16 12 16C13.2339 16 14.2268 15.6028 16.2127 14.8085L19.0212 13.6851C21.0071 12.8907 22 12.4935 22 12C22 11.5065 21.0071 11.1093 19.0212 10.3149L18.2339 10L16.2127 10.8085C14.2268 11.6028 13.2339 12 12 12C10.7661 12 9.77318 11.6028 7.7873 10.8085L5.76613 10Z" fill="currentColor"></path>
                                            <path opacity="0.4" d="M5.76613 14L4.97883 14.3149C2.99294 15.1093 2 15.5065 2 16C2 16.4935 2.99294 16.8907 4.97883 17.6851L7.7873 18.8085C9.77318 19.6028 10.7661 20 12 20C13.2339 20 14.2268 19.6028 16.2127 18.8085L19.0212 17.6851C21.0071 16.8907 22 16.4935 22 16C22 15.5065 21.0071 15.1093 19.0212 14.3149L18.2339 14L16.2127 14.8085C14.2268 15.6028 13.2339 16 12 16C10.7661 16 9.77318 15.6028 7.7873 14.8085L5.76613 14Z" fill="currentColor"></path>
                                        </svg>
                                        <span class="px-1">Tables</span>
                                    </div>
                                    <div class="right_arrow">
                                        <svg class="h-4 w-4 rotate-90" width="16" height="16" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="tables.html">Tables</a>
                                    </li>
                                    <li class="relative">
                                        <a href="javascript:;">Data Tables
                                            <div class="ltr:ml-auto rtl:mr-auto rtl:rotate-180">
                                                <svg width="16" height="16" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </div>
                                        </a>
                                        <ul class="absolute top-0 z-[10] hidden min-w-[180px] rounded bg-white p-0 py-2 text-dark shadow ltr:left-[95%] rtl:right-[95%] dark:bg-[#1b2e4b] dark:text-white-dark">
                                            <li>
                                                <a href="datatables-basic.html">Basic</a>
                                            </li>
                                            <li>
                                                <a href="datatables-advanced.html">Advanced</a>
                                            </li>
                                            <li>
                                                <a href="datatables-skin.html">Skin</a>
                                            </li>
                                            <li>
                                                <a href="datatables-order-sorting.html">Order Sorting</a>
                                            </li>
                                            <li>
                                                <a href="datatables-multi-column.html">Multi Column</a>
                                            </li>
                                            <li>
                                                <a href="datatables-multiple-tables.html">Multiple Tables</a>
                                            </li>
                                            <li>
                                                <a href="datatables-alt-pagination.html">Alt. Pagination</a>
                                            </li>
                                            <li>
                                                <a href="datatables-checkbox.html">Checkbox</a>
                                            </li>
                                            <li>
                                                <a href="datatables-range-search.html">Range Search</a>
                                            </li>
                                            <li>
                                                <a href="datatables-export.html">Export</a>
                                            </li>
                                            <li>
                                                <a href="datatables-sticky-header.html">Sticky Header</a>
                                            </li>
                                            <li>
                                                <a href="datatables-clone-header.html">Clone Header</a>
                                            </li>
                                            <li>
                                                <a href="datatables-column-chooser.html">Column Chooser</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu nav-item relative">
                                <a href="javascript:;" class="nav-link">
                                    <div class="flex items-center">
                                        <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                                            <path opacity="0.5" d="M3 10C3 6.22876 3 4.34315 4.17157 3.17157C5.34315 2 7.22876 2 11 2H13C16.7712 2 18.6569 2 19.8284 3.17157C21 4.34315 21 6.22876 21 10V14C21 17.7712 21 19.6569 19.8284 20.8284C18.6569 22 16.7712 22 13 22H11C7.22876 22 5.34315 22 4.17157 20.8284C3 19.6569 3 17.7712 3 14V10Z" fill="currentColor"></path>
                                            <path d="M16.5189 16.5013C16.6939 16.3648 16.8526 16.2061 17.1701 15.8886L21.1275 11.9312C21.2231 11.8356 21.1793 11.6708 21.0515 11.6264C20.5844 11.4644 19.9767 11.1601 19.4083 10.5917C18.8399 10.0233 18.5356 9.41561 18.3736 8.94849C18.3292 8.82066 18.1644 8.77687 18.0688 8.87254L14.1114 12.8299C13.7939 13.1474 13.6352 13.3061 13.4987 13.4811C13.3377 13.6876 13.1996 13.9109 13.087 14.1473C12.9915 14.3476 12.9205 14.5606 12.7786 14.9865L12.5951 15.5368L12.3034 16.4118L12.0299 17.2323C11.9601 17.4419 12.0146 17.6729 12.1708 17.8292C12.3271 17.9854 12.5581 18.0399 12.7677 17.9701L13.5882 17.6966L14.4632 17.4049L15.0135 17.2214L15.0136 17.2214C15.4394 17.0795 15.6524 17.0085 15.8527 16.913C16.0891 16.8004 16.3124 16.6623 16.5189 16.5013Z" fill="currentColor"></path>
                                            <path d="M22.3665 10.6922C23.2112 9.84754 23.2112 8.47812 22.3665 7.63348C21.5219 6.78884 20.1525 6.78884 19.3078 7.63348L19.1806 7.76071C19.0578 7.88348 19.0022 8.05496 19.0329 8.22586C19.0522 8.33336 19.0879 8.49053 19.153 8.67807C19.2831 9.05314 19.5288 9.54549 19.9917 10.0083C20.4545 10.4712 20.9469 10.7169 21.3219 10.847C21.5095 10.9121 21.6666 10.9478 21.7741 10.9671C21.945 10.9978 22.1165 10.9422 22.2393 10.8194L22.3665 10.6922Z" fill="currentColor"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.25 9C7.25 8.58579 7.58579 8.25 8 8.25H14.5C14.9142 8.25 15.25 8.58579 15.25 9C15.25 9.41421 14.9142 9.75 14.5 9.75H8C7.58579 9.75 7.25 9.41421 7.25 9ZM7.25 13C7.25 12.5858 7.58579 12.25 8 12.25H11C11.4142 12.25 11.75 12.5858 11.75 13C11.75 13.4142 11.4142 13.75 11 13.75H8C7.58579 13.75 7.25 13.4142 7.25 13ZM7.25 17C7.25 16.5858 7.58579 16.25 8 16.25H9.5C9.91421 16.25 10.25 16.5858 10.25 17C10.25 17.4142 9.91421 17.75 9.5 17.75H8C7.58579 17.75 7.25 17.4142 7.25 17Z" fill="currentColor"></path>
                                        </svg>
                                        <span class="px-1">Forms</span>
                                    </div>
                                    <div class="right_arrow">
                                        <svg class="h-4 w-4 rotate-90" width="16" height="16" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="forms-basic.html">Basic</a>
                                    </li>
                                    <li>
                                        <a href="forms-input-group.html">Input Group</a>
                                    </li>
                                    <li>
                                        <a href="forms-layouts.html">Layouts</a>
                                    </li>
                                    <li>
                                        <a href="forms-validation.html">Validation</a>
                                    </li>
                                    <li>
                                        <a href="forms-input-mask.html">Input Mask</a>
                                    </li>
                                    <li>
                                        <a href="forms-select2.html">Select2</a>
                                    </li>
                                    <li>
                                        <a href="forms-touchspin.html">TouchSpin</a>
                                    </li>
                                    <li>
                                        <a href="forms-checkbox-radio.html">Checkbox & Radio</a>
                                    </li>
                                    <li>
                                        <a href="forms-switches.html">Switches</a>
                                    </li>
                                    <li>
                                        <a href="forms-wizards.html">Wizards</a>
                                    </li>
                                    <li>
                                        <a href="forms-file-upload.html">File Upload</a>
                                    </li>
                                    <li>
                                        <a href="forms-quill-editor.html">Quill Editor</a>
                                    </li>
                                    <li>
                                        <a href="forms-markdown-editor.html">Markdown Editor</a>
                                    </li>
                                    <li>
                                        <a href="forms-date-picker.html">Date & Range Picker</a>
                                    </li>
                                    <li>
                                        <a href="forms-clipboard.html">Clipboard</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu nav-item relative">
                                <a href="javascript:;" class="nav-link">
                                    <div class="flex items-center">
                                        <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                                            <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd" d="M14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V10C2 6.22876 2 4.34315 3.17157 3.17157C4.34315 2 6.23869 2 10.0298 2C10.6358 2 11.1214 2 11.53 2.01666C11.5166 2.09659 11.5095 2.17813 11.5092 2.26057L11.5 5.09497C11.4999 6.19207 11.4998 7.16164 11.6049 7.94316C11.7188 8.79028 11.9803 9.63726 12.6716 10.3285C13.3628 11.0198 14.2098 11.2813 15.0569 11.3952C15.8385 11.5003 16.808 11.5002 17.9051 11.5001L18 11.5001H21.9574C22 12.0344 22 12.6901 22 13.5629V14C22 17.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22Z" fill="currentColor"></path>
                                            <path d="M6 13.75C5.58579 13.75 5.25 14.0858 5.25 14.5C5.25 14.9142 5.58579 15.25 6 15.25H14C14.4142 15.25 14.75 14.9142 14.75 14.5C14.75 14.0858 14.4142 13.75 14 13.75H6Z" fill="currentColor"></path>
                                            <path d="M6 17.25C5.58579 17.25 5.25 17.5858 5.25 18C5.25 18.4142 5.58579 18.75 6 18.75H11.5C11.9142 18.75 12.25 18.4142 12.25 18C12.25 17.5858 11.9142 17.25 11.5 17.25H6Z" fill="currentColor"></path>
                                            <path d="M11.5092 2.2601L11.5 5.0945C11.4999 6.1916 11.4998 7.16117 11.6049 7.94269C11.7188 8.78981 11.9803 9.6368 12.6716 10.3281C13.3629 11.0193 14.2098 11.2808 15.057 11.3947C15.8385 11.4998 16.808 11.4997 17.9051 11.4996L21.9574 11.4996C21.9698 11.6552 21.9786 11.821 21.9848 11.9995H22C22 11.732 22 11.5983 21.9901 11.4408C21.9335 10.5463 21.5617 9.52125 21.0315 8.79853C20.9382 8.6713 20.8743 8.59493 20.7467 8.44218C19.9542 7.49359 18.911 6.31193 18 5.49953C17.1892 4.77645 16.0787 3.98536 15.1101 3.3385C14.2781 2.78275 13.862 2.50487 13.2915 2.29834C13.1403 2.24359 12.9408 2.18311 12.7846 2.14466C12.4006 2.05013 12.0268 2.01725 11.5 2.00586L11.5092 2.2601Z" fill="currentColor"></path>
                                        </svg>
                                        <span class="px-1">Pages</span>
                                    </div>
                                    <div class="right_arrow">
                                        <svg class="h-4 w-4 rotate-90" width="16" height="16" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </a>
                                <ul class="sub-menu">
                                    <li class="relative">
                                        <a href="javascript:;">Users
                                            <div class="ltr:ml-auto rtl:mr-auto rtl:rotate-180">
                                                <svg width="16" height="16" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </div>
                                        </a>
                                        <ul class="absolute top-0 z-[10] hidden min-w-[180px] rounded bg-white p-0 py-2 text-dark shadow ltr:left-[95%] rtl:right-[95%] dark:bg-[#1b2e4b] dark:text-white-dark">
                                            <li>
                                                <a href="users-profile.html">Profile</a>
                                            </li>
                                            <li>
                                                <a href="users-account-settings.html">Account Settings</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="pages-knowledge-base.html">Knowledge Base</a>
                                    </li>
                                    <li>
                                        <a href="pages-contact-us-boxed.html" target="_blank">Contact Us Boxed</a>
                                    </li>
                                    <li>
                                        <a href="pages-contact-us-cover.html" target="_blank">Contact Us Cover</a>
                                    </li>
                                    <li>
                                        <a href="pages-faq.html">Faq</a>
                                    </li>
                                    <li>
                                        <a href="pages-coming-soon-boxed.html" target="_blank">Coming Soon Boxed</a>
                                    </li>
                                    <li>
                                        <a href="pages-coming-soon-cover.html" target="_blank">Coming Soon Cover</a>
                                    </li>
                                    <li>
                                        <a href="pages-maintenence.html" target="_blank">Maintanence</a>
                                    </li>
                                    <li class="relative">
                                        <a href="javascript:;">Error
                                            <div class="ltr:ml-auto rtl:mr-auto rtl:rotate-180">
                                                <svg width="16" height="16" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </div>
                                        </a>
                                        <ul class="absolute top-0 z-[10] hidden min-w-[180px] rounded bg-white p-0 py-2 text-dark shadow ltr:left-[95%] rtl:right-[95%] dark:bg-[#1b2e4b] dark:text-white-dark">
                                            <li>
                                                <a href="pages-error404.html" target="_blank">404</a>
                                            </li>
                                            <li>
                                                <a href="pages-error500.html" target="_blank">500</a>
                                            </li>
                                            <li>
                                                <a href="pages-error503.html" target="_blank">503</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="relative">
                                        <a href="javascript:;">Login
                                            <div class="ltr:ml-auto rtl:mr-auto rtl:rotate-180">
                                                <svg width="16" height="16" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </div>
                                        </a>
                                        <ul class="absolute top-0 z-[10] hidden min-w-[180px] rounded bg-white p-0 py-2 text-dark shadow ltr:left-[95%] rtl:right-[95%] dark:bg-[#1b2e4b] dark:text-white-dark">
                                            <li>
                                                <a href="auth-cover-login.html" target="_blank">Login Cover</a>
                                            </li>
                                            <li>
                                                <a href="auth-boxed-signin.html" target="_blank">Login Boxed</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="relative">
                                        <a href="javascript:;">Register
                                            <div class="ltr:ml-auto rtl:mr-auto rtl:rotate-180">
                                                <svg width="16" height="16" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </div>
                                        </a>
                                        <ul class="absolute top-0 z-[10] hidden min-w-[180px] rounded bg-white p-0 py-2 text-dark shadow ltr:left-[95%] rtl:right-[95%] dark:bg-[#1b2e4b] dark:text-white-dark">
                                            <li>
                                                <a href="auth-cover-register.html" target="_blank">Register Cover</a>
                                            </li>
                                            <li>
                                                <a href="auth-boxed-signup.html" target="_blank">Register Boxed</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="relative">
                                        <a href="javascript:;">Password Recovery
                                            <div class="ltr:ml-auto rtl:mr-auto rtl:rotate-180">
                                                <svg width="16" height="16" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </div>
                                        </a>
                                        <ul class="absolute top-0 z-[10] hidden min-w-[180px] rounded bg-white p-0 py-2 text-dark shadow ltr:left-[95%] rtl:right-[95%] dark:bg-[#1b2e4b] dark:text-white-dark">
                                            <li>
                                                <a href="auth-cover-password-reset.html" target="_blank">Recover ID Cover</a>
                                            </li>
                                            <li>
                                                <a href="auth-boxed-password-reset.html" target="_blank">Recover ID Boxed</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="relative">
                                        <a href="javascript:;">Lockscreen
                                            <div class="ltr:ml-auto rtl:mr-auto rtl:rotate-180">
                                                <svg width="16" height="16" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </div>
                                        </a>
                                        <ul class="absolute top-0 z-[10] hidden min-w-[180px] rounded bg-white p-0 py-2 text-dark shadow ltr:left-[95%] rtl:right-[95%] dark:bg-[#1b2e4b] dark:text-white-dark">
                                            <li>
                                                <a href="auth-cover-lockscreen.html" target="_blank">Unlock Cover</a>
                                            </li>
                                            <li>
                                                <a href="auth-boxed-lockscreen.html" target="_blank">Unlock Boxed</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu nav-item relative">
                                <a href="javascript:;" class="nav-link">
                                    <div class="flex items-center">
                                        <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                                            <path opacity="0.5" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" fill="currentColor"></path>
                                            <path d="M12.75 9C12.75 8.58579 12.4142 8.25 12 8.25C11.5858 8.25 11.25 8.58579 11.25 9L11.25 11.25H9C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75H11.25V15C11.25 15.4142 11.5858 15.75 12 15.75C12.4142 15.75 12.75 15.4142 12.75 15L12.75 12.75H15C15.4142 12.75 15.75 12.4142 15.75 12C15.75 11.5858 15.4142 11.25 15 11.25H12.75V9Z" fill="currentColor"></path>
                                        </svg>
                                        <span class="px-1">More</span>
                                    </div>
                                    <div class="right_arrow">
                                        <svg class="h-4 w-4 rotate-90" width="16" height="16" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="dragndrop.html">Drag and Drop</a>
                                    </li>
                                    <li>
                                        <a href="charts.html">Charts</a>
                                    </li>
                                    <li>
                                        <a href="font-icons.html">Font Icons</a>
                                    </li>
                                    <li>
                                        <a href="widgets.html">Widgets</a>
                                    </li>
                                    <li>
                                        <a href="souysoeng.com" target="_blank">Documentation</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </header>
                <!-- end header section -->

                <script>
                        $(function() {
                            //Initialize Select2 Elements
                            $('.select2').select2()

                            //Initialize Select2 Elements
                            $('.select2bs4').select2({
                                theme: 'bootstrap4'
                            })

                            $("#example1").DataTable({
                                "responsive": true,
                                "lengthChange": false,
                                "autoWidth": false,

                            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                            $('#example2').DataTable({
                                "paging": true,
                                "lengthChange": false,
                                "searching": false,
                                "ordering": true,
                                "info": true,
                                "autoWidth": false,
                                "responsive": true,
                            });
                        });
                    </script>
                <div class="animate__animated p-6" :class="[$store.app.animation]">
                  <main>
                    @yield('content')
                  </main>


                </div>

        @include('layouts.adminLayout.footer')