<?php

namespace HMS\Templates;

class Header {
    public static function header() {
        echo <<< 'Header_HTML'
            <style>
                /* Custom styles for the active button */
                .active-nav {
                    background-color: #38A169; /* Tailwind green */
                    color: white;
                    padding-inline: 10px;
                    padding-block: 5px;
                }
                #wpcontent, #wpfooter {
                    margin-left: 140px;
                }
                .auto-fold #wpcontent {
                    padding: 0;
                }
            </style>
            <script src="https://cdn.tailwindcss.com"></script>
            <nav class="bg-white shadow-md py-3">
                <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-6 mx-auto">
                    <a href="#" class="flex items-center">
                        <img src="https://www.svgrepo.com/show/499962/music.svg" class="h-8 mr-3 sm:h-10" alt="Landwind Logo">
                        <span class="self-center text-2xl font-semibold text-gray-800">Landwind</span>
                    </a>
                    <div class="flex items-center lg:order-2">
                        <button data-collapse-toggle="mobile-menu-2" type="button"
                            class="inline-flex items-center p-2 ml-1 text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 text-gray-400 hover:bg-gray-700 focus:ring-gray-600"
                            aria-controls="mobile-menu-2" aria-expanded="true">
                            <span class="sr-only">Open main menu</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="items-center justify-between w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                        <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0 items-center	">
                            <li>
                                <a href="#" class="block py-2 px-3 rounded text-gray-700 hover:bg-green-100 lg:hover:bg-transparent lg:text-green-600 lg:p-0 active-nav" aria-current="page">Home</a>
                            </li>
                            <li>
                                <a href="#" class="block py-2 px-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-green-600 lg:p-0">Company</a>
                            </li>
                            <li>
                                <a href="#" class="block py-2 px-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-green-600 lg:p-0">Marketplace</a>
                            </li>
                            <li>
                                <a href="#" class="block py-2 px-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-green-600 lg:p-0">Features</a>
                            </li>
                            <li>
                                <a href="#" class="block py-2 px-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-green-600 lg:p-0">Team</a>
                            </li>
                            <li>
                                <a href="#" class="block py-2 px-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-green-600 lg:p-0">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>
            Header_HTML;
    }
}
