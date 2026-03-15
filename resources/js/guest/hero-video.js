const initHeroVideoPlayback = () => {
    const heroVideo = document.querySelector('[data-hero-video]');

    if (!heroVideo) {
        return;
    }

    const playbackRate = Number.parseFloat(heroVideo.dataset.playbackRate ?? '1');

    if (!Number.isFinite(playbackRate) || playbackRate <= 0) {
        return;
    }

    const applyPlaybackRate = () => {
        heroVideo.playbackRate = playbackRate;
    };

    applyPlaybackRate();
    heroVideo.addEventListener('loadeddata', applyPlaybackRate);
    heroVideo.addEventListener('play', applyPlaybackRate);
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHeroVideoPlayback);
} else {
    initHeroVideoPlayback();
}
