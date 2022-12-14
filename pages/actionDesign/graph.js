let canvas_width=640, canvas_height=480;
let media_width=640, media_height=480;

let video;
const knnClassifier = ml5.KNNClassifier();
let poseNet;
let poses = [];
let loadCount = 0;

var file_uploadedVideo = document.getElementById("uploadedVideo");

var uploaded = () => {
    const file = file_uploadedVideo.files[0];
    return Promise.resolve(URL.createObjectURL(file));
}

var uploadVideo = () => {
    uploaded().then((new_video_url) => {
        video_url = new_video_url;
        setup();
        bs_Video_Uploader.hide();
    })
}

var preload = () => {
    console.log("[DEBUG]", "#Start preload");
}

function setup() {
    console.log("[DEBUG]", "#Start setup");
    video = createVideo(video_url, videoLoaded);
    video.parent("videoplayer");
    
    if(loadCount > 0) {
        poseNet = ml5.poseNet(
            video, 
            {
                architecture: "ResNet50", 
                outputStride: 16,
                maxPoseDetections: 1,
                detectionType: 'single',
                scoreThreshold: 0.5,
                quantBytes: 4,
                multiplier: 0.75,
            }, 
            () => {
                console.log("Model Loaded!");
                action_player.disabled = false
            }
        );
        poseNet.on('pose', (results) => {
            poses = results;
            if(poses.length > 0){
                info_message["pose"] = results[0]["pose"];
                Info_update();
            }
        });
    }
    
    video.hide();
    noLoop();
    loadCount++;
}
var videoLoaded = () => {
    video.elt.setAttribute("crossorigin", "anonymous | use-credentials");
    
    video_player.disabled = false;
    canvas_width = video.elt.width;
    canvas_height = video.elt.height;
    const canvas = createCanvas(video.elt.width, video.elt.height);

    canvas.parent('displayer');
    if(loadCount > 0) {
        // image(video, 0, 0, width, height);
    }
}

var looping = () => {
    console.log(isLooping());
}

var draw = () => {
    image(video, 0, 0, width, height);
    if(poses.length && action_isPlay) {
        for(let i=0;i<poses.length;++i) {
            drawBody(poses[i], i);
        }
    }
}
var drawBody = (pose, poseIndex) => {
    strokeWeight(1);
    const kpFillColor = color(255, 255, 255, 200);

    const keypoints = pose.pose.keypoints;
    const kpSize = 10;
    const kpTextMargin = 2;
    let xPoseLeftMost = width;
    let xPoseRightMost = -1;
    let yPoseTop = height;
    let yPoseBottom = -1;
    for (let j = 0; j < keypoints.length; j++) {
        // A keypoint is an object describing a body part (like rightArm or leftShoulder)
        let kp = keypoints[j];
        // Only draw an ellipse is the pose probability is bigger than 0.2
        if(xPoseLeftMost > kp.position.x){
            xPoseLeftMost = kp.position.x;
        }else if(xPoseRightMost < kp.position.x){
            xPoseRightMost = kp.position.x;
        }

        if(yPoseBottom < kp.position.y){
            yPoseBottom = kp.position.y;
        }else if(yPoseTop > kp.position.y){
            yPoseTop = kp.position.y;
        }
        if (kp.score > 0.4) {
            if (j<5){
                fill(255, 0, 0);
            }else if (j<12){
                fill(0, 255, 0);
            }else{
                fill(0, 0, 255);
            }
            noStroke();
            ellipse(kp.position.x, kp.position.y, kpSize, kpSize);
        }
    }
    const boundingBoxExpandFraction = 0.1;
    let boundingBoxWidth = xPoseRightMost - xPoseLeftMost;
    let boundingBoxHeight = yPoseBottom - yPoseTop;
    let boundingBoxXMargin = boundingBoxWidth * boundingBoxExpandFraction;
    let boundingBoxYMargin = boundingBoxHeight * boundingBoxExpandFraction;
    xPoseRightMost += boundingBoxXMargin / 2;
    xPoseLeftMost -= boundingBoxXMargin / 2;
    yPoseTop -= boundingBoxYMargin / 2;
    yPoseBottom += boundingBoxYMargin / 2;
    noFill();
    stroke(kpFillColor);
    rect(xPoseLeftMost, yPoseTop, boundingBoxWidth + boundingBoxXMargin, 
        boundingBoxHeight + boundingBoxYMargin);
}


var video_player = document.querySelector("#service-action");
video_player.addEventListener("click", (e) => {
    video_isPlay = !video_isPlay;
    console.log("video_isPlay: " + video_isPlay);
    if(video_isPlay) {
        video_player_play();
    } else {
        video_player_pause();
    }
});
var video_player_play = () => {
    video_player.querySelector(".material-icons-outlined").innerHTML = "stop";
    loop();
    video.play();
}
var video_player_pause = () => {
    video_player.querySelector(".material-icons-outlined").innerHTML = "play_arrow";
    noLoop();
    video.pause();
}


var action_player = document.querySelector("#classify-action");
action_player.addEventListener("click", (e) => {
    action_isPlay = !action_isPlay;
    console.log("action_isPlay: " + action_isPlay);
    if(action_isPlay) {
        action_player_play();
    } else {
        action_player_pause();
    }
    classify_count = 0;
    classify();
});
var action_player_play = () => {
    action_player.querySelector(".material-icons-outlined").innerText = "stop_circle";
    action_isPlay = true;
    // loop();
}
var action_player_pause = () => {
    action_player.querySelector(".material-icons-outlined").innerText = "play_circle";
    action_isPlay = false;
    // noLoop();
}