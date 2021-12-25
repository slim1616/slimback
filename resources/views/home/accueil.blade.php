@extends('home.app')

@section('content')

<div class="relative bottom-0 left-0 z-30 hidden w-full h-16 md:block bg-gradient-to-r from-wave-500 via-wave-600 to-purple-500">
    <div class="flex items-center justify-between w-full h-full px-3 mx-auto max-w-7xl">
        <div class="relative flex items-center">
            <a href="#" target="_blank" class="flex items-center text-sm text-blue-200 hover:underline">
                <span class="ml-1 font-normal">
                    <i class="fa fa-envelope text-white"></i>
                </span>
                <span class="ml-2 text-white hidden font-medium text-blue-100 xl:block">contact@satys.com</span>
            </a>
        </div>
        
        <div class="w-auto">
            <a href="tel:+21670707070" target="_blank" class="flex items-center h-8 px-3 text-sm font-medium text-white border border-white rounded-md cursor-pointer">
                <i class="fa fa-phone"></i><span class="py-1.5 pl-2.5"> +216 70 70 70 70</span>
            </a>
        </div>
    </div>
</div>
@include('home.header')
<main class="flex-grow overflow-x-hidden"> 
    <div class="relative flex items-center w-full">
        <div class="relative z-20 px-8 mx-auto xl:px-5 max-w-7xl">
            
            <div class="flex flex-col items-center h-full pb-56 lg:flex-row">
                
                <div class="flex flex-col items-start w-full mb-16 md:items-center lg:pr-12 lg:items-start lg:w-1/2 lg:mb-0">
                    
                    <h2 class="text-sm font-semibold tracking-wide text-gray-700 uppercase duration-700 ease-out transform sm:text-base lg:text-sm xl:text-base transition-all visible translate-y-0 scale-100 opacity-100" data-replace="{ &quot;transition-none&quot;: &quot;transition-all&quot;, &quot;invisible&quot;: &quot;visible&quot;, &quot;translate-y-12&quot;: &quot;translate-y-0&quot;, &quot;scale-110&quot;: &quot;scale-100&quot;, &quot;opacity-0&quot;: &quot;opacity-100&quot; }">Bienvenue</h2>
                    <h1 class="pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent duration-700 ease-out delay-150 transform bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl transition-all visible translate-y-0 scale-100 opacity-100" data-replace="{ &quot;transition-none&quot;: &quot;transition-all&quot;, &quot;invisible&quot;: &quot;visible&quot;, &quot;translate-y-12&quot;: &quot;translate-y-0&quot;, &quot;scale-110&quot;: &quot;scale-100&quot;, &quot;opacity-0&quot;: &quot;opacity-100&quot; }">Evaluez votre marché, testez vos idées.</h1>
                    <p class="max-w-2xl mt-0 text-base text-left text-gray-600 duration-700 ease-out delay-300 transform md:text-center lg:text-left sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl transition-all visible translate-y-0 scale-100 opacity-100" data-replace="{ &quot;transition-none&quot;: &quot;transition-all&quot;, &quot;invisible&quot;: &quot;visible&quot;, &quot;translate-y-12&quot;: &quot;translate-y-0&quot;, &quot;scale-110&quot;: &quot;scale-100&quot;, &quot;opacity-0&quot;: &quot;opacity-100&quot; }">Commencez tout de suite et gratuitement ! Votre première enquête sera prête dans quelques minutes. Nous vous souhaitons une bonne acquisition des connaissances importantes !</p>
                    <div class="w-full mt-5 duration-700 ease-out transform delay-450 sm:mt-8 sm:flex sm:justify-center lg:justify-start sm:w-auto transition-all visible translate-y-0 opacity-100" data-replace="{ &quot;transition-none&quot;: &quot;transition-all&quot;, &quot;invisible&quot;: &quot;visible&quot;, &quot;translate-y-12&quot;: &quot;translate-y-0&quot;, &quot;opacity-0&quot;: &quot;opacity-100&quot; }">
                        <div class="rounded-md">
                            <a href="{{route('login')}}" class="flex items-center justify-center w-full px-8 py-3 text-base font-medium leading-6 text-white transition duration-150 ease-in-out border border-transparent rounded-md bg-wave-500 hover:bg-wave-600 focus:outline-none focus:border-wave-600 focus:shadow-outline-indigo md:py-4 md:text-lg md:px-10">
                                Se Connecter
                            </a>
                        </div>
                        <div class="sm:mt-0 sm:ml-3">
                            <a href="#" class="flex items-center justify-center w-full px-8 py-3 text-base font-medium leading-6 text-indigo-700 transition duration-150 ease-in-out bg-indigo-100 border-2 border-transparent rounded-md hover:text-indigo-600 hover:bg-indigo-50 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-300 md:py-4 md:text-lg md:px-10">
                                Plus de détails
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="flex w-full mb-16 lg:w-1/2 lg:mb-0">
                    
                    <div class="relative duration-1000 delay-100 transform transition-all visible translate-y-0 opacity-100" data-replace="{ &quot;transition-none&quot;: &quot;transition-all&quot;, &quot;invisible&quot;: &quot;visible&quot;, &quot;translate-x-12&quot;: &quot;translate-y-0&quot;, &quot;opacity-0&quot;: &quot;opacity-100&quot; }">
                        <img src="./home/3.png" class="w-full max-w-3xl sm:w-auto">
                    </div>
                    
                </div>
            </div>
        </div>
        
        
        
    </div>
    
    <div class="relative z-40 -mt-64">
        
        <svg viewBox="0 0 120 28" class="-mt-64">
            <defs>
                <path id="wave" d="M 0,10 C 30,10 30,15 60,15 90,15 90,10 120,10 150,10 150,15 180,15 210,15 210,10 240,10 v 28 h -240 z"></path>
            </defs>
            <use id="wave3" class="wave" xlink:href="#wave" x="0" y="-2"></use>
            <use id="wave2" class="wave" xlink:href="#wave" x="0" y="0"></use>
            <use id="wave1" class="wave" xlink:href="#wave" x="0" y="1"></use>
        </svg>
    </div>
    
    
    <section class="relative z-40 w-full pt-10 pb-16 lg:pt-5 xl:-mt-24 bg-gradient-to-b from-wave-500 via-wave-600 to-wave-400">
        
        <div class="absolute top-0 left-0 z-10 w-full h-full transform -translate-x-1/2 opacity-10">
            <svg class="w-full h-full text-white opacity-25 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 205 205"><defs></defs><g fill="#FFF" fill-rule="evenodd"><path d="M182.63 37c14.521 18.317 22.413 41.087 22.37 64.545C205 158.68 159.1 205 102.486 205c-39.382-.01-75.277-22.79-92.35-58.605C-6.939 110.58-2.172 68.061 22.398 37a105.958 105.958 0 00-9.15 43.352c0 54.239 39.966 98.206 89.265 98.206 49.3 0 89.265-43.973 89.265-98.206A105.958 105.958 0 00182.629 37z"></path><path d="M103.11 0A84.144 84.144 0 01150 14.21C117.312-.651 78.806 8.94 56.7 37.45c-22.105 28.51-22.105 68.58 0 97.09 22.106 28.51 60.612 38.101 93.3 23.239-30.384 20.26-70.158 18.753-98.954-3.75-28.797-22.504-40.24-61.021-28.47-95.829C34.346 23.392 66.723.002 103.127.006L103.11 0z"></path><path d="M116.479 13c36.655-.004 67.014 28.98 69.375 66.234 2.36 37.253-24.089 69.971-60.44 74.766 29.817-8.654 48.753-38.434 44.308-69.685-4.445-31.25-30.9-54.333-61.904-54.014-31.003.32-56.995 23.944-60.818 55.28v-1.777C46.99 44.714 78.096 13.016 116.479 13z"></path></g></svg>
        </div>
        
        <div class="relative z-20 flex flex-col items-start justify-start px-8 mx-auto sm:items-center max-w-7xl xl:px-5">
            <h2 class="text-4xl font-medium leading-9 text-white">Fonctionnalitées</h2>
            <p class="mt-4 leading-6 sm:text-center text-wave-200">Construire un questionnaire n'a jamais été aussi<br class="hidden md:block"> simple!</p>
            
            <div class="grid mt-16 gap-y-10 sm:grid-cols-2 sm:gap-x-8 md:gap-x-12 lg:grid-cols-3 xl:grid-cols-4 lg:gap-20">
                <div>
                    <img src="./home/authentication.png" class="w-16 rounded sm:mx-auto">
                    <h3 class="mt-6 text-sm font-semibold leading-6 sm:text-center text-wave-100">ENQUETE EN LIGNE</h3>
                    <p class="mt-2 text-sm leading-5 sm:text-center text-wave-200">Rapide, efficace et sans besoin de formation, vous créez facilement votre étude de marché, sondage ou questionnaire.</p>
                </div>
                <div>
                    <img src="./home/profile.png" class="w-16 rounded sm:mx-auto">
                    <h3 class="mt-6 text-sm font-semibold leading-6 sm:text-center text-wave-100">MOBILE ENQUETE</h3>
                    <p class="mt-2 text-sm leading-5 sm:text-center text-wave-200">Customizable user profiles. Allow your users to enter data and easily customize their user profiles.</p>
                </div>
                <div>
                    <img src="./home/impersonation.png" class="w-16 rounded sm:mx-auto">
                    <h3 class="mt-6 text-sm font-semibold leading-6 sm:text-center text-wave-100">Collectez des </h3>
                    <p class="mt-2 text-sm leading-5 sm:text-center text-wave-200">Diffusez votre enquête par mail, lien web Collectez les réponses immédiatement.</p>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  style="width: 71px;" class="sm:mx-auto" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 468.52 468.52" style="enable-background:0 0 69.52 69.52;" xml:space="preserve">
                            <g>
                                <path style="fill:#E6E6E6;" d="M468.52,102.595v251.88c0,11.14-7.571,20.52-17.86,23.25c-1.98,0.531-4.06,0.81-6.2,0.81H38.58   c-13.29,0-24.061-10.77-24.061-24.06v-251.88c0-13.29,10.771-24.06,24.061-24.06h405.88c2.14,0,4.22,0.28,6.2,0.81   C460.949,82.075,468.52,91.455,468.52,102.595"/>
                                <path style="fill:#B3B3B3;" d="M468.518,102.591v23.94h-454v-23.94c0-13.29,10.771-24.06,24.06-24.06h405.88   C457.747,78.532,468.518,89.302,468.518,102.591"/>
                                <rect x="42.099" y="141.002" style="fill:#999999;" width="118.901" height="16.532"/>
                                <polyline style="fill:#FFFFFF;" points="442.383,222.765 256.652,222.765 256.652,354.496 442.383,354.496 442.383,222.765  "/>
                                <polyline style="fill:#29ABE2;" points="434.552,329.733 265.552,329.733 265.552,346.265 434.552,346.265 434.552,329.733  "/>
                                <polyline style="fill:#FC7A51;" points="286.552,297.744 265.552,297.744 265.552,314.276 286.552,314.276 286.552,297.744  "/>
                                <polyline style="fill:#F9DE58;" points="350.552,265.754 265.552,265.754 265.552,282.286 350.552,282.286 350.552,265.754  "/>
                                <polyline style="fill:#999999;" points="411.552,233.765 265.552,233.765 265.552,250.297 411.552,250.297 411.552,233.765  "/>
                                <circle style="fill:#FC7A51;" cx="47.517" cy="102.532" r="15"/>
                                <circle style="fill:#F9DE58;" cx="87.517" cy="102.532" r="15"/>
                                <path style="fill:#EEEEEE;" d="M463.696,88.139c3.027,4.024,4.822,9.029,4.822,14.453v23.94h-23.321   c0.04,35.899-19.42,70.584-53.444,88.347c-2.102,0.921-4.223,1.779-6.365,2.574l2.774,5.313h54.222v131.731H298.563l7.326,24.038   h138.57c2.14,0,4.22-0.28,6.2-0.81c10.29-2.73,17.86-12.11,17.86-23.25v-251.88C468.52,97.17,466.725,92.164,463.696,88.139    M463.657,88.088c0.012,0.016,0.023,0.031,0.036,0.047C463.681,88.12,463.669,88.103,463.657,88.088 M463.621,88.04   c0.008,0.01,0.015,0.02,0.023,0.03C463.636,88.06,463.629,88.05,463.621,88.04 M463.59,87.999c0.003,0.004,0.006,0.008,0.009,0.012   C463.596,88.007,463.593,88.003,463.59,87.999"/>
                                <path style="fill:#CBCBCB;" d="M444.46,78.535h-11.739c0.396,0.716,0.784,1.437,1.165,2.167c7.655,14.662,11.293,30.36,11.31,45.83   h23.321v-23.94c0-5.424-1.795-10.429-4.822-14.453l0,0c-0.001-0.001-0.002-0.002-0.003-0.003l0,0   c-0.012-0.016-0.023-0.031-0.036-0.047l0,0c-0.005-0.006-0.009-0.012-0.014-0.018l0,0c-0.008-0.01-0.015-0.02-0.023-0.03l0,0   c-0.007-0.01-0.014-0.019-0.022-0.029l0,0c-0.003-0.004-0.006-0.008-0.009-0.012l0,0c-3.187-4.171-7.708-7.269-12.93-8.654   C448.68,78.815,446.6,78.535,444.46,78.535"/>
                                <path style="fill:#FFFFFF;" d="M442.383,222.765h-54.222l5.326,10.202c-0.519,0.271-1.04,0.537-1.561,0.798h19.626v16.532H266.807   l4.711,15.457h79.034v16.532h-73.996l4.711,15.458h5.285v16.532h-0.246l4.711,15.457h143.536v16.532H296.055l2.509,8.231h143.819   V222.765"/>
                                <polyline style="fill:#6EC6EB;" points="434.552,329.733 291.016,329.733 296.055,346.265 434.552,346.265 434.552,329.733  "/>
                                <polyline style="fill:#FDA589;" points="286.552,297.744 281.267,297.744 286.306,314.276 286.552,314.276 286.552,297.744  "/>
                                <polyline style="fill:#FBE98E;" points="350.552,265.754 271.518,265.754 276.556,282.286 350.552,282.286 350.552,265.754  "/>
                                <path style="fill:#EEEEEE;" d="M246.265,126.531h-17.178l29.329,96.234h62.908c-1.465-0.282-2.926-0.591-4.384-0.929l-1.001-0.232   c-24.282-7.625-45.651-24.51-58.362-48.855C249.857,157.962,246.221,142.128,246.265,126.531"/>
                                <path style="fill:#CBCBCB;" d="M258.73,78.535h-44.27l14.628,47.996h17.178c0.028-10.08,1.594-20.062,4.587-29.594   C252.852,90.569,255.489,84.4,258.73,78.535"/>
                                <path style="fill:#FFFFFF;" d="M321.324,222.765h-62.908l7.136,23.415v-12.415h53.983l3.362-10.708   C322.373,222.963,321.848,222.866,321.324,222.765"/>
                                <path style="fill:#BABABA;" d="M411.552,233.765h-19.626c-14.25,7.129-29.421,10.514-44.383,10.514   c-10.173,0-20.251-1.566-29.869-4.586l1.861-5.928h-53.983v12.415l1.255,4.117h144.745V233.765"/>
                                <path style="fill:#CECECE;" d="M385.387,217.453c-6.196,2.3-12.551,4.073-18.994,5.313h21.767L385.387,217.453"/>
                                <path style="fill:#DBDBDB;" d="M388.161,222.765h-21.767c-7.428,1.428-14.973,2.147-22.536,2.147   c-6.999,0-14.015-0.616-20.959-1.855l-3.362,10.708h72.391c0.521-0.261,1.042-0.527,1.561-0.798L388.161,222.765"/>
                                <path style="fill:#A4A4A4;" d="M391.926,233.765h-72.391l-1.861,5.928c9.618,3.02,19.696,4.586,29.869,4.586   C362.505,244.279,377.677,240.894,391.926,233.765"/>
                                <path style="fill:#DBDBDB;" d="M345.64,27.261c-15.507,0-31.24,3.637-45.936,11.309c-17.955,9.374-31.855,23.466-40.973,39.961   h173.987c-12.828-23.18-33.641-39.288-57.199-46.682C365.898,28.829,355.817,27.261,345.64,27.261"/>
                                <polyline style="fill:#9F9F9F;" points="432.719,78.532 258.732,78.532 258.73,78.535 432.721,78.535 432.719,78.532  "/>
                                <path style="fill:#CECECE;" d="M445.196,126.531H246.265c-0.044,15.597,3.592,31.43,11.312,46.218   c12.711,24.345,34.08,41.23,58.362,48.855l1.001,0.232c1.458,0.338,2.919,0.647,4.384,0.929h45.069   c6.443-1.239,12.797-3.012,18.994-5.313c2.142-0.795,4.263-1.653,6.365-2.574C425.776,197.115,445.237,162.431,445.196,126.531"/>
                                <path style="fill:#B2B2B2;" d="M432.721,78.535H258.73c-3.241,5.865-5.878,12.033-7.878,18.402   c-2.993,9.532-4.559,19.515-4.587,29.594h198.931c-0.017-15.469-3.656-31.168-11.31-45.83   C433.505,79.972,433.117,79.251,432.721,78.535"/>
                                <path style="fill:#DBDBDB;" d="M366.393,222.765h-45.069c0.524,0.101,1.049,0.198,1.574,0.292   c6.945,1.239,13.96,1.855,20.959,1.855C351.42,224.912,358.965,224.193,366.393,222.765"/>
                                <path style="fill:#F9DE58;" d="M345.73,113.225l-5.24,16.69l-24.55,78.18c-24.28-7.62-45.65-24.51-58.36-48.85   c-12.71-24.35-14.35-51.53-6.73-75.81l83.46,26.2L345.73,113.225z"/>
                                <path style="fill:#29ABE2;" d="M393.49,219.465c-7.48,3.9-15.23,6.76-23.08,8.63c-17.7,4.21-35.91,3.38-52.74-1.91l26.47-84.29   l3.32-10.59L393.49,219.465z"/>
                                <path style="fill:#FC7A51;" d="M391.75,201.375l-46.02-88.15l-11.42-3.59l-83.46-26.2c7.63-24.29,24.51-45.66,48.85-58.37   c2.55-1.33,5.12-2.54,7.73-3.62c22.27-9.33,46.35-9.93,68.09-3.1c24.29,7.62,45.66,24.5,58.37,48.85   C459.3,115.885,440.44,175.955,391.75,201.375z"/>
                                <polyline style="fill:#FFFFFF;" points="226.383,168.765 40.652,168.765 40.652,354.496 226.383,354.496 226.383,168.765  "/>
                                <polyline style="fill:#2BE0C6;" points="93.6,254.001 57.602,254.001 57.602,343.996 93.6,343.996 93.6,254.001  "/>
                                <polyline style="fill:#F9DE58;" points="151.517,224.002 115.518,224.002 115.518,343.996 151.517,343.996 151.517,224.002  "/>
                                <polyline style="fill:#FC7A51;" points="209.432,191.004 173.435,191.004 173.435,343.996 209.432,343.996 209.432,191.004  "/>
                                <polyline style="fill:#29ABE2;" points="242.83,325.765 242.83,454.765 0,454.765 0,325.765 242.83,325.765  "/>
                                <polyline style="fill:#F2F2F2;" points="15,439.765 15,340.765 227.826,340.765 227.826,439.765 15,439.765  "/>
                                <polyline style="fill:#FC7A51;" points="108.064,430.978 87.408,408.6 78.664,420.466 71.9,415.483 86.68,395.426 106.349,416.734    137.239,360.959 160.785,398.8 188.393,349.552 195.722,353.66 161.162,415.307 137.661,377.538 108.064,430.978  "/>
                                <rect x="26" y="357.765" style="fill:#999999;" width="27" height="11"/>
                                <rect x="26" y="384.765" style="fill:#999999;" width="27" height="11"/>
                                <rect x="26" y="411.765" style="fill:#999999;" width="27" height="11"/>
                                <polyline style="fill:#6EC6EB;" points="242.83,325.765 209.432,325.765 173.435,325.765 151.517,325.765 115.518,325.765    93.6,325.765 92.88,325.765 97.451,340.765 227.826,340.765 227.826,439.765 127.619,439.765 132.19,454.765 242.83,454.765    242.83,325.765  "/>
                                <polyline style="fill:#F6F6F6;" points="227.826,340.765 97.451,340.765 115.542,400.135 137.239,360.959 160.785,398.8    188.393,349.552 195.722,353.66 161.162,415.307 137.661,377.538 118.951,411.32 127.619,439.765 227.826,439.765 227.826,340.765     "/>
                                <polyline style="fill:#FDA589;" points="188.393,349.552 160.785,398.8 137.239,360.959 115.542,400.135 118.951,411.32    137.661,377.538 161.162,415.307 195.722,353.66 188.393,349.552  "/>
                                <path style="fill:#CCCCCC;" d="M393.695,417.909l8.485-20.662l25.251,25.251c1.464,1.464,3.387,2.199,5.303,2.192   c1.923,0,3.84-0.728,5.303-2.192c2.934-2.934,2.927-7.679,0-10.607l-25.251-25.251l20.669-8.492l-78.559-38.792L393.695,417.909z"/>
                                <path style="fill:#808080;" d="M393.695,417.909l8.485-20.662l25.251,25.251c1.464,1.464,3.387,2.199,5.303,2.192   c1.923,0,3.84-0.728,5.303-2.192l-83.142-83.142L393.695,417.909z"/>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            </svg>
                    <h3 class="mt-3 text-sm font-semibold leading-6 sm:text-center text-wave-100">Analyse des Résultats</h3>
                    <p class="mt-2 text-sm leading-5 sm:text-center text-wave-200">Analysez vos données en temps réel et personnalisez vos rapports en utilisant les solutions d’analyses performantes.</p>
                </div>
                <div>
                    <img src="./home/plans.png" class="w-16 rounded sm:mx-auto">
                    <h3 class="mt-6 text-sm font-semibold leading-6 sm:text-center text-wave-100">Multi Sites</h3>
                    <p class="mt-2 text-sm leading-5 sm:text-center text-wave-200">Créez des enqêtes multi sites/emplacements</p>
                </div>
                <div>
                    <img src="./home/roles.png" class="w-16 rounded sm:mx-auto">
                    <h3 class="mt-6 text-sm font-semibold leading-6 sm:text-center text-wave-100">Multi utilisateurs</h3>
                    <p class="mt-2 text-sm leading-5 sm:text-center text-wave-200">Multi utilisateurs.</p>
                </div>
                {{-- <div>
                    <img src="./home/notifications.png" class="w-16 rounded sm:mx-auto">
                    <h3 class="mt-6 text-sm font-semibold leading-6 sm:text-center text-wave-100">Solutions pour les enquêtes clients</h3>
                    <p class="mt-2 text-sm leading-5 sm:text-center text-wave-200">Ready-to-use Notification System which integrates with the default Laravel notification feature.</p>
                </div>
                <div>
                    <img src="./home/announcements.png" class="w-16 rounded sm:mx-auto">
                    <h3 class="mt-6 text-sm font-semibold leading-6 sm:text-center text-wave-100">Pour les étudiants</h3>
                    <p class="mt-2 text-sm leading-5 sm:text-center text-wave-200">Create user announcements to notify users about new features or updates in your application.</p>
                </div>
                <div>
                    <img src="./home/blog.png" class="w-16 rounded sm:mx-auto">
                    <h3 class="mt-6 text-sm font-semibold leading-6 sm:text-center text-wave-100">Solutions pour les analystes de marché</h3>
                    <p class="mt-2 text-sm leading-5 sm:text-center text-wave-200">Equipped with a fully-functional blog. Write posts related to your product to gain free SEO traffic.</p>
                </div> --}}
                {{-- <div>
                    <img src="./home/api.png" class="w-16 rounded sm:mx-auto">
                    <h3 class="mt-6 text-sm font-semibold leading-6 sm:text-center text-wave-100">Exportation facile de données</h3>
                    <p class="mt-2 text-sm leading-5 sm:text-center text-wave-200">Ready-to-consume API for your application. Create API tokens with role specific permissions.</p>
                </div>
                <div>
                    <img src="./home/admin.png" class="w-16 rounded sm:mx-auto">
                    <h3 class="mt-6 text-sm font-semibold leading-6 sm:text-center text-wave-100">Importez vos listes</h3>
                    <p class="mt-2 text-sm leading-5 sm:text-center text-wave-200">Wave has been crafted using Laravel &amp; Voyager, which makes administering your app a breeze!</p>
                </div>
                <div>
                    <img src="./home/themes.png" class="w-16 rounded sm:mx-auto">
                    <h3 class="mt-6 text-sm font-semibold leading-6 sm:text-center text-wave-100">Diffusez vos enquetes</h3>
                    <p class="mt-2 text-sm leading-5 sm:text-center text-wave-200">Invitez vos clients/prospects... en les invitant à répondrs à vos enquêtes par mail/sms ou par le biais des médias sociaux</p>
                </div> --}}
            </div>
            
        </div>
    </section>
    
    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" class="bg-gray-100" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1440 156" style="enable-background:new 0 0 1440 126;" xml:space="preserve">
        <style type="text/css">
            .wave-svg{fill:#0069ff;}
            .wave-svg-lighter{fill:#4c95fe}
        </style>
        <g fill-rule="nonzero">
            <path class="wave-svg" d="M694,94.437587 C327,161.381336 194,153.298248 0,143.434189 L2.01616501e-13,44.1765618 L1440,27 L1440,121 C1244,94.437587 999.43006,38.7246898 694,94.437587 Z" id="Shape" fill="#0069FF" opacity="0.519587054"></path>
            <path class="wave-svg" d="M686.868924,95.4364002 C416,151.323752 170.73341,134.021565 1.35713663e-12,119.957876 L0,25.1467017 L1440,8 L1440,107.854321 C1252.11022,92.2972893 1034.37894,23.7359827 686.868924,95.4364002 Z" id="Shape" fill="#0069FF" opacity="0.347991071"></path>
            <path class="wave-svg-lighter" d="M685.6,30.8323303 C418.7,-19.0491687 170.2,1.94304528 0,22.035593 L0,118 L1440,118 L1440,22.035593 C1252.7,44.2273621 1010,91.4098622 685.6,30.8323303 Z" transform="translate(720.000000, 59.000000) scale(1, -1) translate(-720.000000, -59.000000) "></path>
        </g>
    </svg>
    
    <!-- BEGINNING OF TESTIMONIALS SECTION -->
    <div id="testimonials">
        <div class="relative flex items-center justify-center pt-32 pb-12 bg-gray-100 md:pb-32 lg:pb-64 min-w-screen">
            <div class="max-w-6xl px-10 pb-20 mx-auto bg-gray-100">
                <div class="flex flex-col items-center lg:flex-row">
                    <div class="flex flex-col justify-center w-full h-full mb-10 lg:pr-8 sm:w-4/5 md:items-center lg:mb-0 lg:items-start md:w-3/5 lg:w-1/2">
                        <p class="mb-2 text-base font-medium tracking-tight uppercase text-wave-500">Our customers love our product</p>
                        <h2 class="text-4xl font-extrabold leading-10 tracking-tight text-gray-900 sm:leading-none lg:text-5xl xl:text-6xl">
                            Testimonials</h2>
                            <p class="pr-5 my-6 text-lg text-gray-600 md:text-center lg:text-left">This is an example section of where you will add your testimonials for your Software as a Service.</p>
                            <a href="#_" class="flex items-center justify-center px-8 py-3 text-base font-medium leading-6 text-white transition duration-150 ease-in-out border border-transparent rounded-md shadow bg-wave-600 hover:bg-wave-500 focus:outline-none focus:border-wave-700 focus:shadow-outline-wave md:py-4 md:text-lg md:px-10">View
                                Case Studies</a>
                            </div>
                            <div class="w-full sm:w-4/5 lg:w-1/2">
                                <blockquote class="flex flex-row-reverse items-center justify-between w-full col-span-1 p-6 bg-white rounded-lg shadow sm:flex-row">
                                    <div class="flex flex-col pl-5 sm:pr-8">
                                        <div class="relative sm:pl-12">
                                            <svg class="absolute left-0 hidden w-10 h-10 fill-current sm:block text-wave-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 125">
                                                <path d="M30.7 42c0 6.1 12.6 7 12.6 22 0 11-7.9 19.2-18.9 19.2C12.7 83.1 5 72.6 5 61.5c0-19.2 18-44.6 29.2-44.6 2.8 0 7.9 2 7.9 5.4S30.7 31.6 30.7 42zM82.4 42c0 6.1 12.6 7 12.6 22 0 11-7.9 19.2-18.9 19.2-11.8 0-19.5-10.5-19.5-21.6 0-19.2 18-44.6 29.2-44.6 2.8 0 7.9 2 7.9 5.4S82.4 31.6 82.4 42z"></path>
                                            </svg>
                                            <p class="mt-2 text-base text-gray-600">Wave allowed me to build the Software as a Service of my dreams!
                                            </p>
                                        </div>
                                        
                                        <h3 class="mt-3 text-base font-medium leading-5 text-gray-800 truncate sm:pl-12">Jane Cooper <span class="mt-1 text-sm leading-5 text-gray-500 truncate">- CEO SomeCompany</span></h3>
                                        <p class="mt-1 text-sm leading-5 text-gray-500 truncate"></p>
                                    </div>
                                    <img class="flex-shrink-0 w-24 h-24 bg-gray-300 rounded-full" src="./home/photo-1494790108377-be9c29b29330" alt="">
                                </blockquote>
                                <blockquote class="flex flex-row-reverse items-center justify-between w-full col-span-1 p-6 my-5 bg-white rounded-lg shadow sm:flex-row">
                                    <div class="flex flex-col pl-5 sm:pr-10">
                                        <div class="relative sm:pl-12">
                                            <svg class="absolute left-0 hidden w-10 h-10 fill-current sm:block text-wave-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 125">
                                                <path d="M30.7 42c0 6.1 12.6 7 12.6 22 0 11-7.9 19.2-18.9 19.2C12.7 83.1 5 72.6 5 61.5c0-19.2 18-44.6 29.2-44.6 2.8 0 7.9 2 7.9 5.4S30.7 31.6 30.7 42zM82.4 42c0 6.1 12.6 7 12.6 22 0 11-7.9 19.2-18.9 19.2-11.8 0-19.5-10.5-19.5-21.6 0-19.2 18-44.6 29.2-44.6 2.8 0 7.9 2 7.9 5.4S82.4 31.6 82.4 42z"></path>
                                            </svg>
                                            <p class="mt-2 text-base text-gray-600">Wave saved us hundreds of development hours. Creating a Software as a Service is now easier than ever with Wave.</p>
                                        </div>
                                        <h3 class="mt-3 text-base font-medium leading-5 text-gray-800 truncate sm:pl-12">John Doe <span class="mt-1 text-sm leading-5 text-gray-500 truncate">- CEO SomeCompany</span></h3>
                                        <p class="mt-1 text-sm leading-5 text-gray-500 truncate"></p>
                                    </div>
                                    <img class="flex-shrink-0 w-24 h-24 bg-gray-300 rounded-full" src="./home/photo-1527980965255-d3b416303d12" alt="">
                                </blockquote>
                                <blockquote class="flex flex-row-reverse items-center justify-between w-full col-span-1 p-6 bg-white rounded-lg shadow sm:flex-row">
                                    <div class="flex flex-col pl-5 sm:pr-10">
                                        <div class="relative sm:pl-12">
                                            <svg class="absolute left-0 hidden w-10 h-10 fill-current sm:block text-wave-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 125">
                                                <path d="M30.7 42c0 6.1 12.6 7 12.6 22 0 11-7.9 19.2-18.9 19.2C12.7 83.1 5 72.6 5 61.5c0-19.2 18-44.6 29.2-44.6 2.8 0 7.9 2 7.9 5.4S30.7 31.6 30.7 42zM82.4 42c0 6.1 12.6 7 12.6 22 0 11-7.9 19.2-18.9 19.2-11.8 0-19.5-10.5-19.5-21.6 0-19.2 18-44.6 29.2-44.6 2.8 0 7.9 2 7.9 5.4S82.4 31.6 82.4 42z"></path>
                                            </svg>
                                            <p class="mt-2 text-base text-gray-600">This is the best solution available for creating your own Software as a Service!</p>
                                        </div>
                                        
                                        <h3 class="mt-3 text-base font-medium leading-5 text-gray-800 truncate sm:pl-12">John Smith <span class="mt-1 text-sm leading-5 text-gray-500 truncate">- CEO SomeCompany</span></h3>
                                        <p class="mt-1 text-sm leading-5 text-gray-500 truncate"></p>
                                    </div>
                                    <img class="flex-shrink-0 w-24 h-24 bg-gray-300 rounded-full" src="./home/photo-1545167622-3a6ac756afa4" alt="">
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    
                    <svg version="1.1" id="Layer_3" xmlns="http://www.w3.org/2000/svg" class="absolute bottom-0 w-full" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1440 126" style="enable-background:new 0 0 1440 126;" xml:space="preserve">
                        <style type="text/css">
                            .wave-svg-light {
                                fill: #ffffff;
                            }
                        </style>
                        <g id="wave" transform="translate(720.000000, 75.000000) scale(1, -1) translate(-720.000000, -75.000000) " fill-rule="nonzero">
                            <path class="wave-svg-light" d="M694,94.437587 C327,161.381336 194,153.298248 0,143.434189 L2.01616501e-13,44.1765618 L1440,27 L1440,121 C1244,94.437587 999.43006,38.7246898 694,94.437587 Z" id="Shape" fill="#0069FF" opacity="0.519587054"></path>
                            <path class="wave-svg-light" d="M686.868924,95.4364002 C416,151.323752 170.73341,134.021565 1.35713663e-12,119.957876 L0,25.1467017 L1440,8 L1440,107.854321 C1252.11022,92.2972893 1034.37894,23.7359827 686.868924,95.4364002 Z" id="Shape" fill="#0069FF" opacity="0.347991071"></path>
                            <path class="wave-svg-light" d="M685.6,30.8323303 C418.7,-19.0491687 170.2,1.94304528 0,22.035593 L0,118 L1440,118 L1440,22.035593 C1252.7,44.2273621 1010,91.4098622 685.6,30.8323303 Z" id="Shape" fill="url(#linearGradient-1)" transform="translate(720.000000, 59.000000) scale(1, -1) translate(-720.000000, -59.000000) "></path>
                        </g>
                    </svg>
                    
                </div>
            </div>
            <!-- END OF TESTIMONIALS SECTION -->
            
            <!-- BEGINNING OF PRICING SECTION -->
            <div id="pricing" class="relative">
                
                <div class="relative z-20 px-8 pb-8 mx-auto max-w-7xl xl:px-5">
                    <div class="w-full text-left sm:text-center">
                        <h2 class="pt-12 text-4xl font-extrabold text-gray-900 lg:text-5xl">Nos Formules</h2>
                        <p class="w-full my-1 text-base text-left text-gray-900 opacity-75 sm:my-2 sm:text-center sm:text-xl">Nos formules sont adaptées à tous types de besoins</p>
                    </div>
                    
                    <div class="flex flex-wrap mx-auto mt-12 max-w-7xl">
                        
                            <?php $i = 1; ?>
                            @foreach($formules as $formule)
                            <?php $i += 1 ?>
                                <div class="w-full max-w-md px-0 mx-auto mb-6 lg:w-1/3 lg:px-3 lg:mb-0">
                                    <div class="relative flex flex-col h-full mb-10 bg-white border border-gray-200 rounded-lg shadow-xl border-b-none sm:mb-0">
                                        <div class="px-10 pt-7">
                                            <div class="absolute right-0 inline-block mr-6 transform">
                                                @if($i%2==0)
                                                    <h2 class="relative z-20 w-full h-full px-2 py-1 text-xs font-bold leading-tight tracking-wide text-center uppercase bg-white border-2 border-wave-400 text-wave-500 rounded">{{$formule->title}}</h2>
                                                @else
                                                    <h2 class="relative z-20 w-full h-full px-2 py-1 text-xs font-bold leading-tight tracking-wide text-center uppercase bg-white border-2 border-gray-900 text-gray-800 rounded">{{$formule->title}}</h2>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="px-10 mt-5">
                                            <span class="font-mono text-5xl font-bold">{{ $formule->price }}</span>
                                            <span class="text-lg font-bold text-gray-500">/ Mois</span>
                                        </div>
                                        
                                        <div class="px-10 mt-6 pb-9">
                                            <p class="text-lg leading-7 text-gray-500">
                                                {{$formule->nbmois}} Mois
                                            </p>
                                        </div>
                                        
                                        <div class="relative px-10 pt-0 pb-12 mt-auto text-gray-700 rounded-b-lg">
                                            
                                            <ul class="flex flex-col space-y-2.5">
                                                <li class="relative">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-3 text-green-500 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                            <path d="M0 11l2-2 5 5L18 3l2 2L7 18z"></path>
                                                        </svg>
                                                        
                                                        <span>
                                                                {{ $formule->nbsurvey }} enquetes
                                                        </span>
                                                    </span>
                                                </li>
                                                <li class="relative">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-3 text-green-500 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                            <path d="M0 11l2-2 5 5L18 3l2 2L7 18z"></path>
                                                        </svg>
                                                        
                                                        <span>
                                                                {{ $formule->nbsemplacements }} emplacements
                                                        </span>
                                                    </span>
                                                </li>
                                                <li class="relative">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-3 text-green-500 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                            <path d="M0 11l2-2 5 5L18 3l2 2L7 18z"></path>
                                                        </svg>
                                                        
                                                        <span>
                                                                {{$formule->nbmois}} Mois
                                                        </span>
                                                    </span>
                                                </li>
                                                <li class="relative">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-3 text-green-500 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                            <path d="M0 11l2-2 5 5L18 3l2 2L7 18z"></path>
                                                        </svg>
                                                        
                                                        <span>
                                                            Basic Feature Example 4
                                                        </span>
                                                    </span>
                                                </li>
                                            </ul>
                                            
                                            
                                        </div>
                                        
                                        <div class="relative">
                                            @if($i%2==0)
                                                <div data-plan="11160" class="inline-flex items-center justify-center w-full px-4 py-4 text-base font-semibold text-white transition duration-150 ease-in-out  bg-gradient-to-r from-wave-600 to-indigo-500 hover:from-wave-500 hover:to-indigo-400 border border-transparent cursor-pointer rounded-b-md checkout focus:outline-none disabled:opacity-25">
                                            @else
                                            <div data-plan="11159" class="inline-flex items-center justify-center w-full px-4 py-4 text-base font-semibold text-white transition duration-150 ease-in-out bg-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:border-gray-900 focus:shadow-outline-gray border border-transparent cursor-pointer rounded-b-md checkout focus:outline-none disabled:opacity-25">
                                            @endif
                                                Commencer
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                @endforeach
                        
                    </div>
                    
                    <div class="px-2 mx-auto mt-12 max-w-7xl">
                        <div class="w-full p-10 text-gray-600 bg-blue-50 rounded-xl">
                            <div class="flex items-center pb-4">
                                <svg class="mr-2 w-14 h-14 text-wave-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path></svg>
                                <div class="relative">
                                    <h2 class="text-base font-bold text-wave-500">Sandbox Mode</h2>
                                    <p class="text-sm text-blue-400">Application billing is in sandbox mode, which means you can test the checkout process using the following credentials:</p>
                                </div>
                            </div>
                            <div class="pt-2 text-sm font-bold text-gray-500">
                                Credit Card Number: <span class="ml-2 font-mono text-green-500">4242 4242 4242 4242</span>
                            </div>
                            <div class="pt-2 text-sm font-bold text-gray-500">
                                Expiration Date: <span class="ml-2 font-mono text-green-500">Any future date</span>
                            </div>
                            <div class="pt-2 text-sm font-bold text-gray-500">
                                Security Code: <span class="ml-2 font-mono text-green-500">Any 3 digits</span>
                            </div>
                        </div>
                    </div>
                    
                    <p class="w-full my-8 text-left text-gray-500 sm:my-10 sm:text-center">All plans are fully configurable in the Admin Area.</p>
                </div>
            </div>
            <!-- END OF PRICING SECTION -->
            
        </main>
        @endsection