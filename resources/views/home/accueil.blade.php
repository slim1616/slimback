@extends('home.app')

@section('content')

<div class="relative bottom-0 left-0 z-30 hidden w-full h-16 md:block bg-gradient-to-r from-wave-500 via-wave-600 to-purple-500">
    <div class="flex items-center justify-between w-full h-full px-3 mx-auto max-w-7xl">
        <div class="relative flex items-center">
            <a href="https://devdojo.com/wave" target="_blank" class="flex items-center text-sm text-blue-200 hover:underline">
                <span class="hidden font-medium text-blue-100 xl:block">This is a demo of Wave.</span>
                <span class="ml-1 font-normal">The self-hosted Software as a Service Starter Kit</span>
                <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        
        <div class="w-auto">
            <a href="https://github.com/thedevdojo/wave" target="_blank" class="flex items-center h-8 px-3 text-sm font-medium text-white border border-white rounded-md cursor-pointer">
                <svg class="w-7 h-8 h-full pr-1 pr-2.5 border-r text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
                <span class="py-1.5 pl-2.5">View On Github</span>
            </a>
        </div>
    </div>
</div>
@include('home.header')
<main class="flex-grow overflow-x-hidden"> 
    <div class="relative flex items-center w-full">
        <div class="relative z-20 px-8 mx-auto xl:px-5 max-w-7xl">
            
            <div class="flex flex-col items-center h-full pt-16 pb-56 lg:flex-row">
                
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
                        <img src="./home/mFajn4fwpGFXzI1UsNH6.png" class="w-full max-w-3xl sm:w-auto">
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
                    <img src="./home/subscriptions.png" class="w-16 rounded sm:mx-auto">
                    <h3 class="mt-6 text-sm font-semibold leading-6 sm:text-center text-wave-100">Analyse des Résultats</h3>
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
                <div>
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
                </div>
                <div>
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
                </div>
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
                        <h2 class="pt-12 text-4xl font-extrabold text-gray-900 lg:text-5xl">Example Pricing</h2>
                        <p class="w-full my-1 text-base text-left text-gray-900 opacity-75 sm:my-2 sm:text-center sm:text-xl">It's easy to customize the pricing of your Software as a Service</p>
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