$(function () {
    jwplayer.key = "POZTJrXjW3DRxtZXk+w0lQmp0NFsfd/QeBaS3VP31DA=";
});

function initPlay($video, width, height) {
    var video = $video.data('src'),
        thumbnail = $video.data('thumbnail'),
        width = width != undefined && width != null ? width : "100%",
        height = height != undefined && height != null ? height : 285;

    var playerInstance = jwplayer($video[0]);

    playerInstance.setup({
        "file": video,
        "image": thumbnail,
        "width": width,
        "height": height
    });

    return playerInstance;
}