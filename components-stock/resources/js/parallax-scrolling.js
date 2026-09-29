import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';
import 'lenis/dist/lenis.css';

const layers = [
    { layer: '1', yPercent: 70 },
    { layer: '2', yPercent: 55 },
    { layer: '3', yPercent: 40 },
    { layer: '4', yPercent: 10 },
];

function initParallax() {
    const triggerElements = document.querySelectorAll('[data-parallax-layers]');

    // Tidak ada komponen parallax di halaman ini -> tidak melakukan apa-apa
    if (!triggerElements.length) return;

    gsap.registerPlugin(ScrollTrigger);

    triggerElements.forEach((triggerElement) => {
        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: triggerElement,
                start: '0% 0%',
                end: '100% 0%',
                scrub: 0,
            },
        });

        layers.forEach((layerObj, idx) => {
            tl.to(
                triggerElement.querySelectorAll(`[data-parallax-layer="${layerObj.layer}"]`),
                {
                    yPercent: layerObj.yPercent,
                    ease: 'none',
                },
                idx === 0 ? undefined : '<',
            );
        });
    });

    // Smooth scroll (Lenis) yang disinkronkan dengan ScrollTrigger
    const lenis = new Lenis();
    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => {
        lenis.raf(time * 1000);
    });
    gsap.ticker.lagSmoothing(0);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initParallax);
} else {
    initParallax();
}