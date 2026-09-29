@props([
    'title' =>'Asu Koe',
    'background' => 'https://cdn.21st.dev/assets/mirror/a4/a43f4eae3459c461345ee676f12d6e1ddca65e8a5279a5af00d475b17ff83aea.webp',
    'middle' => 'https://cdn.21st.dev/assets/mirror/50/50ca6a0d36d2780bfcb469d6db7eaec0be7e0d2961ba69a63d2a1473b040338d.webp',
    'foreground' => 'https://cdn.21st.dev/assets/mirror/e1/e1c8137b5f971c3b3ec1a0f9e79b9c17018767005f844a10082b890472afecfb.webp',
])

<div {{ $attributes->merge(['class' => 'relative w-full overflow-hidden bg-black text-[#efeeec]']) }}>
    <section class="relative z-2 min-h-svh">
        <div class="absolute top-0 left-0 h-[120%] w-full">
            <div class="absolute -bottom-px left-0 z-20 h-0.5 w-full bg-black"></div>

            <div data-parallax-layers class="absolute inset-0 overflow-hidden">
                <img src="{{ $background }}" loading="eager" width="800" alt="" data-parallax-layer="1"
                    class="pointer-events-none absolute -top-[17.5%] left-0 h-[117.5%] w-full max-w-none object-cover">

                <img src="{{ $middle }}" loading="eager" width="800" alt="" data-parallax-layer="2"
                    class="pointer-events-none absolute -top-[17.5%] left-0 h-[117.5%] w-full max-w-none object-cover">

                <div data-parallax-layer="3" class="absolute top-0 left-0 flex h-svh w-full items-center justify-center">
                    <h2 class="pointer-events-auto relative mr-[.075em] mb-[.1em] text-center text-[11vw] leading-none font-extrabold">
                        {{ $title }}
                    </h2>
                </div>

                <img src="{{ $foreground }}" loading="eager" width="800" alt="" data-parallax-layer="4"
                    class="pointer-events-none absolute -top-[17.5%] left-0 h-[117.5%] w-full max-w-none object-cover">
            </div>

            <div class="absolute bottom-0 left-0 z-30 h-1/5 w-full bg-[linear-gradient(to_top,#000_0%,#000000bc_19%,#0000008a_34%,#00000061_47%,#00000047_56.5%,#00000031_65%,#00000020_73%,#00000013_80.2%,#0000000b_86.1%,#00000005_91%,#00000002_95.2%,#00000001_98.2%,#0000_100%)]"></div>
        </div>
    </section>

    <section class="relative flex min-h-svh items-center justify-center px-4 py-30 md:px-6 lg:px-8">
        @if ($slot->isEmpty())
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" viewBox="0 0 160 160" fill="none" class="relative w-32">
                <path d="M94.8284 53.8578C92.3086 56.3776 88 54.593 88 51.0294V0H72V59.9999C72 66.6273 66.6274 71.9999 60 71.9999H0V87.9999H51.0294C54.5931 87.9999 56.3777 92.3085 53.8579 94.8283L18.3431 130.343L29.6569 141.657L65.1717 106.142C67.684 103.63 71.9745 105.396 72 108.939V160L88.0001 160L88 99.9999C88 93.3725 93.3726 87.9999 100 87.9999H160V71.9999H108.939C105.407 71.9745 103.64 67.7091 106.12 65.1938L106.142 65.1716L141.657 29.6568L130.343 18.3432L94.8284 53.8578Z" fill="currentColor"></path>
            </svg>
        @else
            {{ $slot }}
        @endif
    </section>
</div>