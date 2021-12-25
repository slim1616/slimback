<footer class="bg-white border-t mt-10">
    <div class="flex flex-col items-center justify-between p-3 lg:flex-row">
        <img class="h-16" src="{{asset('home/logo.png')}}" alt="{{ config('app.name', 'Laravel') }}">
        
        <ul class="flex items-center mt-10 space-x-5 lg:mt-0">
            <li>
                <a href="#" class="text-gray-600 hover:text-gray-900">
                    <span class="sr-only">Facebook</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </li>
            <li>
                <a href="#" class="text-gray-600 hover:text-gray-900">
                    <span class="sr-only">LinkedIn</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </svg>
                </a>
            </li>
            <li>
                <a href="#" class="text-gray-600 hover:text-gray-900">
                    <span class="sr-only">Twitter</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                    </svg>
                </a>
            </li>
        </ul>
    </div>
</footer>
<!-- Scripts -->
<script src="{{asset('home/app.js')}}"></script>
@yield('script')
<div x-init="$watch(&#39;open&#39;, value =&gt; {
    if(value){
        document.body.classList.add(&#39;overflow-hidden&#39;);
        let thisElement = $el;
        escapeKeyListener = document.addEventListener(&#39;keydown&#39;, escapeKeyCloseDevBar);
    } else {
        document.body.classList.remove(&#39;overflow-hidden&#39;);
        document.removeEventListener(&#39;keydown&#39;, escapeKeyCloseDevBar);
    }})" id="wave_dev_bar" class="fixed bottom-0 left-0 z-40 w-full h-screen transition-all duration-150 ease-out transform translate-y-full" x-data="{ open: false, url: &#39;&#39;, active: &#39;&#39; }" :class="{ &#39;translate-y-full&#39;: !open, &#39;translate-y-0&#39;: open }" x-on:keydown.escape="open = false">
    <div class="fixed inset-0 z-20 bg-black bg-opacity-25" x-show="open" @click="open=false" style="display: none;"></div>
    
    
    
    <div class="absolute inset-0 z-30 hidden sm:block bottom-0" :class="{ &#39;bottom-0&#39;: !open }">
        
        <div class="inset-0 z-40 transition duration-200 ease-out relative h-10 -mt-10" :class="{ &#39;absolute h-14&#39;: open, &#39;relative h-10 -mt-10&#39;: !open }">
            <div class="w-full h-full border-t border-blue-500 bg-gradient-to-r from-wave-500 via-blue-500 to-purple-600" :class="{ &#39;overflow-hidden&#39;: open }">
                <div class="flex justify-between w-full h-full">
                    <div class="flex h-full w-full justify-content-between">
                        
                        <div class="flex items-center justify-center h-full text-white text-xs leading-none text-blue-100 border-l border-blue-500 cursor-pointer hover:bg-wave-600 px-3 bg-wave-500">
                            {{ config('app.name', 'Laravel') }}
                        </div>
                        <div class="flex items-center justify-center text-white text-xs text-blue-100  cursor-pointer  px-3">
                            www.satys.com.tn © 2021 - All rights reserved.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="relative w-full h-full overflow-hidden bg-white">
            <iframe class="w-full h-full pt-14" :src="url" src="./home/saved_resource.html"></iframe>
        </div>
    </div>
</div>

<!-- Full Screen Loader -->
<div id="fullscreenLoader" class="fixed inset-0 top-0 left-0 z-50 flex flex-col items-center justify-center hidden w-full h-full bg-gray-900 opacity-50">
    <svg class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    <p id="fullscreenLoaderMessage" class="mt-4 text-sm font-medium text-white uppercase"></p>
</div>
<!-- End Full Loader -->


<div class="fixed inset-0 z-40 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end">
    <div id="toast" x-data="{ show: false, &#39;type&#39; : &#39;&#39;, &#39;message&#39;: &#39;&#39; }" @click="show=false" x-show="show" x-transition:enter="transform ease-out duration-300 transition" x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-lg cursor-pointer pointer-events-auto hover:-translate-1" style="display: none;">
        <div class="relative overflow-hidden rounded-lg shadow-xs">
            <div class="px-4 py-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 pr-0.5">
                        <template x-if="type == &#39;info&#39;"></template>
                        <template x-if="type == &#39;warning&#39;"></template>
                        <template x-if="type == &#39;success&#39;"></template>
                        <template x-if="type == &#39;danger&#39;"></template>
                    </div>
                    <div class="flex-1 w-0 pl-3.5 ml-1 border-l border-gray-100">
                        <p class="text-sm font-medium leading-5 text-gray-900">
                            <template x-if="type == &#39;info&#39;"></template>
                            <template x-if="type == &#39;warning&#39;"></template>
                            <template x-if="type == &#39;success&#39;"></template>
                            <template x-if="type == &#39;danger&#39;"></template>
                        </p>
                        <p class="text-sm leading-5 text-gray-500" x-text="message"></p>
                    </div>
                    <div class="flex self-start flex-shrink-0 ml-4">
                        <button @click="show = false;" class="inline-flex -mt-1 text-gray-400 transition duration-150 ease-in-out rounded-full focus:outline-none focus:text-gray-500">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div id="toast_bar" class="absolute bottom-0 left-0 w-full h-1 transition-all ease-out"  style="transition-duration: 3950ms;"></div>
        </div>
    </div>
</div>