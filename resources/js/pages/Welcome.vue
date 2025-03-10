<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { BotMessageSquareIcon, Check, Clock11, Mail, MapPin } from 'lucide-vue-next';
import Customize from '../../../public/assets/svgs/customize.svg';
import Fast from '../../../public/assets/svgs/fast.svg';
import HeroSvg from '../../../public/assets/svgs/hero.svg';
import Personal from '../../../public/assets/svgs/personal.svg';
import Program from '../../../public/assets/svgs/program.svg';
import Scripts from '../../../public/assets/svgs/scripts.svg';
import Sort from '../../../public/assets/svgs/sort.svg';
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex min-h-screen flex-col items-center overflow-y-scroll bg-[#FDFDFC] p-6 text-[#1b1b18] dark:bg-[#0a0a0a] lg:justify-center lg:p-8">
        <header class="not-has-[nav]:hidden mb-6 w-full max-w-[335px] text-sm lg:max-w-4xl">
            <nav class="flex items-center justify-between gap-4">
                <div class="flex items-center space-x-1 font-medium">
                    <BotMessageSquareIcon />
                    <p>Chat Support</p>
                </div>
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('chats.index')"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <div>
                        <Link
                            :href="route('login')"
                            class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                        >
                            Log in
                        </Link>
                        <Link
                            :href="route('register')"
                            class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                        >
                            Register
                        </Link>
                    </div>
                </template>
            </nav>
        </header>
        <!-- hero section -->
        <section
            class="duration-750 starting:opacity-0 grid h-[90vh] grid-cols-2 items-center justify-center pb-10 opacity-100 transition-opacity lg:grow xl:w-[60%]"
        >
            <div class="max-w-xl text-start text-4xl font-bold">
                <p>
                    Automate Your Business with <br />
                    <span class="bg-gradient-to-r from-indigo-500 to-indigo-800 bg-clip-text text-transparent">AI Precision Response</span>
                </p>
                <!-- description -->
                <p class="mt-4 text-xs tracking-wide text-gray-500">
                    Boost your business efficiency with AI Precision Response, an intelligent automation solution that streamlines operations and
                    enhances customer interactions. Leverage advanced AI to provide instant, accurate responses and optimize workflow with minimal
                    effort.
                </p>
                <!-- Call to action -->
                <div class="mt-4 flex-row items-center space-x-2">
                    <button
                        class="inline-flex items-center gap-x-2 rounded-lg border border-transparent bg-black px-4 py-3 text-sm font-medium text-white disabled:pointer-events-none disabled:opacity-50 dark:bg-white dark:text-black"
                    >
                        Get Started
                    </button>
                    <button
                        class="inline-flex items-center gap-x-2 rounded-lg border border-transparent px-4 py-3 text-lg font-medium disabled:pointer-events-none disabled:opacity-50 dark:bg-white dark:text-black"
                    >
                        Our Plans
                    </button>
                </div>
            </div>

            <div>
                <img :src="HeroSvg" />
            </div>
        </section>
        <!-- cards -->
        <section
            class="duration-750 starting:opacity-0 grid w-full grid-cols-1 gap-2 p-10 opacity-100 transition-opacity sm:grid-cols-2 lg:max-w-6xl lg:grid-cols-3"
        >
            <!-- cards -->
            <div class="h-[400px] w-full sm:max-w-[300px]">
                <img :src="Scripts" alt="Chat Scripts" class="h-[200px]" />
                <h1 class="font-bold">Chat Scripts</h1>
                <p class="text-justify">
                    Predefined chat scripts allow business owners to maintain consistency in their responses. These scripts can be tailored to common
                    inquiries, ensuring quick and professional engagement with customers.
                </p>
            </div>

            <div class="h-[400px] w-full sm:max-w-[300px]">
                <img :src="Fast" alt="Fast" class="h-[200px]" />
                <h1 class="font-bold">Fast Response</h1>
                <p class="text-justify">
                    The AI-driven system delivers instant replies, minimizing customer wait times and enhancing satisfaction. By automating responses,
                    businesses can efficiently handle large volumes of inquiries without delays.
                </p>
            </div>

            <div class="h-[400px] w-full sm:max-w-[300px]">
                <img :src="Personal" alt="Personalize" class="h-[200px]" />
                <h1 class="font-bold">Personalize Ai Assisted</h1>
                <p class="text-justify">
                    The application leverages AI to generate responses tailored to each customer’s query. It analyzes user interactions to provide
                    contextual and meaningful replies, improving the overall customer experience.
                </p>
            </div>

            <div class="h-[400px] w-full sm:max-w-[300px]">
                <img :src="Customize" alt="Customizable" class="h-[200px]" />
                <h1 class="font-bold">Customizable</h1>
                <p class="text-justify">
                    Business owners have full control over the response system, allowing them to customize message tone, style, and content to align
                    with their brand’s voice. This ensures a more personalized and engaging communication approach
                </p>
            </div>

            <div class="h-[400px] w-full sm:max-w-[300px]">
                <img :src="Sort" alt="Sorted Response" class="h-[200px]" />
                <h1 class="font-bold">Sorted Response</h1>
                <p class="text-justify">
                    The system intelligently categorizes incoming messages based on urgency, topic, or customer type. This helps prioritize responses,
                    making sure critical queries are addressed promptly while maintaining organization.
                </p>
            </div>

            <div class="h-[400px] w-full sm:max-w-[300px]">
                <img :src="Program" alt="Integration" class="h-[200px]" />
                <h1 class="font-bold">Integration</h1>
                <p class="text-justify">
                    The application is designed to integrate smoothly with various platforms such as websites, social media, and messaging apps. This
                    ensures a unified communication experience, allowing businesses to manage customer interactions efficiently.
                </p>
            </div>
        </section>

        <!-- plans -->
        <section
            class="duration-750 starting:opacity-0 grid h-[100vh] w-full max-w-5xl grid-cols-1 items-center justify-center gap-4 opacity-100 transition-opacity sm:grid-cols-3 lg:grow"
        >
            <div class="flex h-[600px] flex-col rounded-md p-4">
                <h1 class="text-xl font-bold">Free</h1>
                <h2 class="mt-2 text-4xl font-bold">$0 <span class="text-sm text-gray-500">/month</span></h2>
                <p class="mt-2">
                    Get started with 50 free tokens to test the platform and explore its features. Perfect for new users who want to try before they
                    buy.
                </p>

                <div class="flex flex-1 flex-col justify-between">
                    <div class="mt-8 space-y-4 p-4">
                        <div class="flex items-center space-x-2">
                            <Check class="text-green-500" />
                            <p>Sample</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <Check class="text-green-500" />
                            <p>Sample</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <Check class="text-green-500" />
                            <p>Sample</p>
                        </div>
                    </div>
                    <button class="h-[40px] w-full rounded bg-gray-900 text-white">Get Started</button>
                </div>
            </div>

            <div class="flex h-[600px] flex-col rounded-md bg-gray-900 p-4">
                <h1 class="text-xl font-bold text-white">Business</h1>
                <h2 class="mt-2 text-4xl font-bold text-white">$12 <span class="text-sm text-white">/month</span></h2>
                <p class="mt-2 text-white">
                    Unlock full access with 650 tokens for more extended and detailed interactions. Ideal for users who need regular access.
                </p>

                <div class="flex flex-1 flex-col justify-between">
                    <div class="mt-8 space-y-4 p-4 text-white">
                        <div class="flex items-center space-x-2">
                            <Check class="text-green-500" />
                            <p>Sample</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <Check class="text-green-500" />
                            <p>Sample</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <Check class="text-green-500" />
                            <p>Sample</p>
                        </div>
                    </div>
                    <button class="h-[40px] w-full rounded bg-indigo-900 text-white">Get Started</button>
                </div>
            </div>
            <div class="flex h-[600px] flex-col rounded-md p-4">
                <h1 class="text-xl font-bold">Start up</h1>
                <h2 class="mt-2 text-4xl font-bold">$20 <span class="text-sm text-gray-500">/month</span></h2>
                <p class="mt-2">
                    Enjoy 1000 tokens for even more flexibility and in-depth usage. Designed for power users and businesses that require extensive
                    interactions.
                </p>

                <div class="flex flex-1 flex-col justify-between">
                    <div class="mt-8 space-y-4 p-4">
                        <div class="flex items-center space-x-2">
                            <Check class="text-green-500" />
                            <p>Sample</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <Check class="text-green-500" />
                            <p>Sample</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <Check class="text-green-500" />
                            <p>Sample</p>
                        </div>
                    </div>
                    <button class="h-[40px] w-full rounded bg-gray-900 text-white">Get Started</button>
                </div>
            </div>
        </section>
    </div>
    <!-- contact information -->
    <section class="flex h-[50vh] w-full items-center justify-center bg-indigo-800 p-4">
        <div class="grid h-full w-1/2 grid-cols-2">
            <div class="p-4 text-white">
                <h1 class="text-4xl font-medium">Contact Us</h1>
                <p class="mt-4">
                    For inquiries related to our services, partnerships, or support, feel free to contact us via phone, email, or by filling out our
                    contact form.
                </p>
                <div>
                    <div class="mt-4">
                        <div class="mt-4">
                            <div class="flex items-center space-x-2">
                                <Mail />
                                <p class="font-medium">Email :</p>
                            </div>
                            <a href="">rainierlesondatoii@gmail.com</a>
                        </div>

                        <div class="mt-4">
                            <div class="flex items-center space-x-2">
                                <Clock11 />
                                <p class="font-medium">Business Hours :</p>
                            </div>
                            <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
                            <p>Saturday - Sunday: Closed</p>
                        </div>

                        <div class="mt-4">
                            <div class="flex items-center space-x-2">
                                <MapPin />
                                <p class="font-medium">Address :</p>
                            </div>
                            <p>Cotabato,Philippines</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- send us -->
            <div class="p-4 text-white">
                <h1 class="text-xl font-medium">Send us a message</h1>
                <form action="" class="mt-2">
                    <div>
                        <label for="email" class="font-medium">Email</label>
                        <input type="text" id="email" class="block w-1/2" />
                    </div>

                    <div class="mt-4">
                        <label for="plan" class="font-medium">Plan</label>
                        <input type="text" id="plan" class="block w-1/2" />
                    </div>

                    <div class="mt-4">
                        <label for="plan" class="font-medium">Message</label>
                        <textarea name="" id="" rows="6" class="block w-full"></textarea>
                    </div>

                    <button class="mt-4 h-[40px] w-full rounded bg-gray-900 text-white">Send Message</button>
                </form>
            </div>
        </div>
    </section>
</template>
