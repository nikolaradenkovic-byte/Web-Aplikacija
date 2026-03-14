let audioPlayer = document.getElementById("audioPlayer");
const source = document.getElementById('source');
let songId;
let updateView;

function playSong(songPath, id) {
    songId = id;
    source.src = songPath;
    audioPlayer.load();
    audioPlayer.play();
}

 
audioPlayer.addEventListener("playing", function() {
    if(updateView != songId) {
        fetch(`updateViews.php?id=${songId}`);
        updateView = songId; 
    }
});