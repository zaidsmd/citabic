const initHeroVideoPlayback = () => {
    const heroVideo = document.querySelector('[data-hero-video]');

    if (!heroVideo) {
        return;
    }

    const playbackRate = Number.parseFloat(heroVideo.dataset.playbackRate ?? '1');

    const applyPlaybackRate = () => {
        if (Number.isFinite(playbackRate) && playbackRate > 0) {
            heroVideo.playbackRate = playbackRate;
        }
    };

    // Ensure muted is explicitly set for mobile and autoplay policy
    heroVideo.muted = true;
    heroVideo.defaultMuted = true;

    applyPlaybackRate();
    heroVideo.addEventListener('loadeddata', applyPlaybackRate);
    heroVideo.addEventListener('play', applyPlaybackRate);

    // Eagerly trigger playback
    const startPlay = () => {
        const playPromise = heroVideo.play();
        if (playPromise !== undefined) {
            playPromise.catch(() => {
                // If autoplay is restricted by browser policy, try again on first interaction
                const onFirstInteraction = () => {
                    heroVideo.play().catch(() => {});
                    window.removeEventListener('touchstart', onFirstInteraction);
                    window.removeEventListener('click', onFirstInteraction);
                };
                window.addEventListener('touchstart', onFirstInteraction, { once: true, passive: true });
                window.addEventListener('click', onFirstInteraction, { once: true, passive: true });
            });
        }
    };

    if (heroVideo.readyState >= 2) {
        startPlay();
    } else {
        heroVideo.addEventListener('canplay', startPlay, { once: true });
    }

    // Pause video when user scrolls off screen to conserve resources
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        heroVideo.play().catch(() => {});
                    } else {
                        heroVideo.pause();
                    }
                });
            },
            { threshold: 0.1 }
        );
        observer.observe(heroVideo);
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHeroVideoPlayback);
} else {
    initHeroVideoPlayback();
}
