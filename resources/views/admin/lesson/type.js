var video = document.querySelector(".video");
var juice = document.querySelector(".orange-juice");
var btn = document.getElementById("play-pause");
var stop = document.getElementById("stop");
var mutebtn = document.getElementById("mute-video");
var fullscreen = document.getElementById("fs");


videoControls.setAttribute('data-state', 'visible');

function togglePlayPause() {
    if(video.paused){
        btn.className = 'pause';
        video.play();
    }else{
        btn.className = 'play';
        video.pause();
    }
}

btn.onclick = function() {
    togglePlayPause();
}

stop.addEventListener('click', (e) => {
    video.pause();
    video.currentTime = 0;
    progress.value = 0;
});

video.addEventListener('timeupdate', function(){
    var juicePosition = video.currentTime / video.duration;
    juice.style.width = juicePosition * 100 + '%';

    if(video.ended){
        btn.className = 'play';
    }
});

function changeButtonState(type) {
    if (type === 'playpause') {
        // Play/Pause button
        if (video.paused || video.ended) {
            playpause.setAttribute('data-state', 'play');
        } else {
            playpause.setAttribute('data-state', 'pause');
        }
    } else if (type === 'mute') {
        // Mute button
        mutebtn.setAttribute('data-state', video.muted ? 'unmute' : 'mute');
    }
}

mutebtn.addEventListener('click', (e) => {
    video.muted = !video.muted;
    changeButtonState('mute');
});

fullscreen.addEventListener('click', (e) => {
    alert();
    handleFullscreen();
});

function handleFullscreen() {
    if (document.fullscreenElement !== null) {
        // The document is in fullscreen mode
        document.exitFullscreen();
        setFullscreenData(false);
    } else {
        // The document is not in fullscreen mode
        videoContainer.requestFullscreen();
        setFullscreenData(true);
    }
}

function setFullscreenData(state) {
    videoContainer.setAttribute('data-fullscreen', !!state);
}

document.addEventListener('fullscreenchange', (e) => {
    setFullscreenData(!!document.fullscreenElement);
});

.video-controls{
    width: 100%;
    max-width: 800px;
    position: relative;
    overflow: hidden;
}

.video-controls:hover .controls {
    transform: translateY(0);
}

.controls {
    display: flex;
    position: absolute;
    bottom: 0;
    width: 100%;
    flex-wrap: wrap;
    background-color: rgba(0, 0, 0, 0.3);
    transform: translateY(100%) translateY(-5px);
    transition: all 0.2s ease-in-out;
    align-items: center;
    justify-content: center;
}

.buttons {
    padding: 5px;
}

.buttons button {
    background: none;
    border: 0;
    outline: 0;
    cursor: pointer
}

.buttons button:before {
    content: '\f144';
    font-family: 'Font Awesome 5 Free';
    width: 10px;
    height: 10px;
    display: inline-block;
    font-size: 20px;
    color: #ffffff;
    -webkit-font-smoothing: subpixel-antialiased;
}

.buttons button.play:before {
    content: '\f144';
}

.buttons button.pause:before {
    content: '\f28b';
}

.stop-buttons {
    padding: 5px;
}

.stop-buttons button {
    background: none;
    border: 0;
    outline: 0;
    cursor: pointer
}

.stop-buttons button:before {
    content: '\f04d';
    font-family: 'Font Awesome 5 Free';
    width: 10px;
    height: 10px;
    display: inline-block;
    font-size: 20px;
    color: #ffffff;
    -webkit-font-smoothing: subpixel-antialiased;
}

.mute {
    padding: 5px;
}

.mute button {
    background: none;
    border: 0;
    outline: 0;
    cursor: pointer
}

.mute button:before {
    content: '\f6a9';
    width: 10px;
    height: 10px;
    display: inline-block;
    font-size: 20px;
    color: #ffffff;
    -webkit-font-smoothing: subpixel-antialiased;
}

.mute button.mute:before {
    content: '\f6a9';
}

.mute button.unmute:before {
    content: '\f28b';
}

.orange-bar {
    height: 10px;
    top: 0;
    left: 0;
    width: 100%;
    background: #000;
}

.orange-juice {
    height: 10px;
    background-color: orangered;
}