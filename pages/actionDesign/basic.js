var video_url = "/static/pose1_media.mp4";
// var video_url = "https://xamp.brlin.org/static/pose1_media.mp4";
// var video_url = 'https://o365nutc-my.sharepoint.com/personal/s1410832036_ad1_nutc_edu_tw/_layouts/15/embed.aspx?UniqueId=3dc5a442-6851-4332-a609-cc89d97bb2c6&embed=%7B%22hvm%22%3Atrue%2C%22ust%22%3Atrue%7D&referrer=OneUpFileViewer&referrerScenario=EmbedDialog.Create'
var knn_json_url = "/static/pose1_KNN.json";
// var knn_json_url = "https://xamp.brlin.org/static/pose1_KNN.json"
var DEBUG = false;
var testEle = null;
var InfoOffcanvas_msg = document.querySelector("#System > .offcanvas-body > .tab-content > #nav-debug > .message");
var bs_InfoOffcanvas = new bootstrap.Offcanvas('#System');
var bs_Video_Uploader = new bootstrap.Modal("#video-Uploader");
var bs_Uploaded = new bootstrap.Modal("#Uploaded");
var showKeyPoints = true;
var info_message = {
    "pose": {
        "KeyPoints": "not yet!"
    },
    "example": {
    },
    "classify": {
    }
};
document.addEventListener("keydown", (event) => {
    console.log(event.code);
    if(event.isComposing || event.code == "KeyP"){
        DEBUG = !DEBUG;
    }
    if(DEBUG) {
        bs_InfoOffcanvas.show();
    }else {
        bs_InfoOffcanvas.hide();
    }
});
var Info_update = () => {
    InfoOffcanvas_msg.innerHTML = JSON.stringify(info_message, undefined, 4);
}
document.getElementById("Camera-device").addEventListener("click", (e) => {
    if (e.target.checked) {
        console.log("Camera-device: on");
        discoverCamera();
    }else {
        console.log("Camera-device: off");
        coverCamera();
    }
})

var coverCamera = () => {
    video.elt.srcObject.getTracks().forEach((t) => {t.enabled = false})
}
var discoverCamera = () => {
    video.elt.srcObject.getTracks().forEach((t) => {t.enabled = true})
}

var ipt_video_path = document.querySelector("#ipt-video-path");
var btn_video_path = document.querySelector("#btn-video-path");
btn_video_path.addEventListener("click", (e) => {
    video_url = ipt_video_path.value;
    video.elt.src = video_url;
})

var action_player = document.querySelector("#classify-action");
var video_player = document.querySelector("#service-action");
var video_isPlay = false;
var action_isPlay = false; // showKeyPoints