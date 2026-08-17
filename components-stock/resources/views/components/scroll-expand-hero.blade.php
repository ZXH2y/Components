@props([
    'mediaType' => 'video',
    'mediaSrc',
    'posterSrc' => null,
    'bgSrc',
    'bgType' => 'image',
    'title' => '',
    'date' => '',
    'scrollText' => '',
])

@php
    $uid = 'seh_' . uniqid();
@endphp

<div id="{{ $uid }}" class="seh-wrapper">
    <section class="seh-section">
        <div class="seh-bg" data-role="bg">
            @if ($bgType === 'video')
                <video src="{{ $bgSrc }}" autoplay muted loop playsinline preload="auto" class="seh-bg-img"></video>
            @else
                <img src="{{ $bgSrc }}" alt="Background" class="seh-bg-img">
            @endif
            <div class="seh-bg-overlay"></div>
        </div>

        <div class="seh-container">
            <div class="seh-hero">
                <div class="seh-media" data-role="media">
                    @if ($mediaType === 'video')
                        <video
                            src="{{ $mediaSrc }}"
                            @if($posterSrc) poster="{{ $posterSrc }}" @endif
                            autoplay muted loop playsinline preload="auto"
                            class="seh-media-el"
                        ></video>
                    @else
                        <img src="{{ $mediaSrc }}" alt="{{ $title }}" class="seh-media-el">
                    @endif
                    <div class="seh-media-overlay" data-role="media-overlay"></div>

                    <div class="seh-media-text">
                        @if($date)
                            <p class="seh-date" data-role="text-left">{{ $date }}</p>
                        @endif
                        @if($scrollText)
                            <p class="seh-scroll-text" data-role="text-right">{{ $scrollText }}</p>
                        @endif
                    </div>
                </div>

                <div class="seh-title-wrap">
                    <h2 class="seh-title-left" data-role="text-left">{{ explode(' ', $title)[0] ?? '' }}</h2>
                    <h2 class="seh-title-right" data-role="text-right">{{ implode(' ', array_slice(explode(' ', $title), 1)) }}</h2>
                </div>
            </div>

            <section class="seh-content" data-role="content">
                {{ $slot }}
            </section>
        </div>
    </section>
</div>

<style>
    .seh-wrapper { overflow-x: hidden; }
    .seh-section { position: relative; display: flex; flex-direction: column; align-items: center; min-height: 100dvh; }
    .seh-bg { position: absolute; inset: 0; z-index: 0; height: 100%; transition: opacity .1s linear; }
    .seh-bg-img { width: 100vw; height: 100vh; object-fit: cover; object-position: center; }
    .seh-bg-overlay { position: absolute; inset: 0; background: rgba(0,0,0,.1); }
    .seh-container { width: 100%; max-width: 1200px; margin: 0 auto; display: flex; flex-direction: column; align-items: center; position: relative; z-index: 10; }
    .seh-hero { display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100%; height: 100dvh; position: relative; }
    .seh-media { position: absolute; z-index: 0; top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius: 1rem; max-width: 95vw; max-height: 85vh; box-shadow: 0 0 50px rgba(0,0,0,.3); overflow: hidden; }
    .seh-media-el { width: 100%; height: 100%; object-fit: cover; display: block; }
    .seh-media-overlay { position: absolute; inset: 0; background: rgba(0,0,0,.5); transition: opacity .2s linear; }
    .seh-media-text { position: absolute; bottom: -3.5rem; left: 0; right: 0; display: flex; flex-direction: column; align-items: center; text-align: center; gap: .25rem; }
    .seh-date { font-size: 1.25rem; color: #bfdbfe; margin: 0; }
    .seh-scroll-text { color: #bfdbfe; font-weight: 500; margin: 0; }
    .seh-title-wrap { display: flex; align-items: center; justify-content: center; gap: 1rem; text-align: center; flex-wrap: wrap; position: relative; z-index: 10; width: 100%; }
    .seh-title-left, .seh-title-right { font-size: 2.5rem; font-weight: 700; color: #bfdbfe; margin: 0; }
    @media (min-width: 768px) { .seh-title-left, .seh-title-right { font-size: 3.5rem; } }
    .seh-content { display: flex; flex-direction: column; width: 100%; padding: 2.5rem 2rem; opacity: 0; transition: opacity .7s ease; }
    @media (min-width: 768px) { .seh-content { padding: 5rem 4rem; } }
</style>

<script>
(function () {
    const wrap = document.getElementById('{{ $uid }}');
    const media = wrap.querySelector('[data-role="media"]');
    const mediaOverlay = wrap.querySelector('[data-role="media-overlay"]');
    const bg = wrap.querySelector('[data-role="bg"]');
    const content = wrap.querySelector('[data-role="content"]');
    const textLefts = wrap.querySelectorAll('[data-role="text-left"]');
    const textRights = wrap.querySelectorAll('[data-role="text-right"]');

    let progress = 0;
    let expanded = false;
    let touchStartY = 0;
    let isMobile = window.innerWidth < 768;

    window.addEventListener('resize', () => { isMobile = window.innerWidth < 768; });

    function render() {
        const mediaWidth = 300 + progress * (isMobile ? 650 : 1250);
        const mediaHeight = 400 + progress * (isMobile ? 200 : 400);
        const textTranslate = progress * (isMobile ? 18 : 15);

        media.style.width = mediaWidth + 'px';
        media.style.height = mediaHeight + 'px';
        mediaOverlay.style.opacity = 0.5 - progress * 0.3;
        bg.style.opacity = 1 - progress;

        textLefts.forEach(el => el.style.transform = `translateX(-${textTranslate}vw)`);
        textRights.forEach(el => el.style.transform = `translateX(${textTranslate}vw)`);

        content.style.opacity = expanded ? 1 : 0;
    }

    function updateProgress(delta) {
        progress = Math.min(Math.max(progress + delta, 0), 1);
        if (progress >= 1) {
            expanded = true;
        } else if (progress < 0.75) {
            expanded = false;
        }
        render();
    }

    function onWheel(e) {
        if (expanded && e.deltaY < 0 && window.scrollY <= 5) {
            expanded = false;
            render();
            e.preventDefault();
        } else if (!expanded) {
            e.preventDefault();
            updateProgress(e.deltaY * 0.0009);
        }
    }

    function onTouchStart(e) { touchStartY = e.touches[0].clientY; }

    function onTouchMove(e) {
        if (!touchStartY) return;
        const touchY = e.touches[0].clientY;
        const deltaY = touchStartY - touchY;

        if (expanded && deltaY < -20 && window.scrollY <= 5) {
            expanded = false;
            render();
            e.preventDefault();
        } else if (!expanded) {
            e.preventDefault();
            const factor = deltaY < 0 ? 0.008 : 0.005;
            updateProgress(deltaY * factor);
            touchStartY = touchY;
        }
    }

    function onTouchEnd() { touchStartY = 0; }

    function onScroll() {
        if (!expanded) window.scrollTo(0, 0);
    }

    window.addEventListener('wheel', onWheel, { passive: false });
    window.addEventListener('scroll', onScroll);
    window.addEventListener('touchstart', onTouchStart, { passive: false });
    window.addEventListener('touchmove', onTouchMove, { passive: false });
    window.addEventListener('touchend', onTouchEnd);

    render();
})();
</script>