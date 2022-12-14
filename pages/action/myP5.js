let canvas_width=640, canvas_height=480;
let media_width=640, media_height=480;
// let canvas_height=windowWidth, canvas_width=windowHeight;
let video;
let video2;
// Create a KNN classifier
const knnClassifier = ml5.KNNClassifier();
let poseNet;
let poses = [];
function setup() {
    // video = createVideo(video_url, videoLoaded);
    // video.parent("videoplayer");
    video2 = createVideo(video_url, videoLoaded);
    video2.parent("videoplayer");
    let constraints = {
        video: {
            widht: 1920,
            height: 1080
        },
        audio: false
    };
    // video = createCapture(VIDEO);
    video = createCapture(constraints, () => {
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
            if(poses.length > 0) info_message["pose"] = results[0]["pose"];
        });
        const canvas = createCanvas(video2.elt.width, video2.elt.height);
        canvas_width = video2.elt.width;
        canvas_height = video2.elt.height;
        canvas.parent('displayer');
    });
    video.hide();
    noLoop();
}
var videoLoaded = () => {
    video_player.disabled = false;
    // video2.elt.setAttribute("autoplay muted loop");
    video2.elt.muted = true;
    video2.elt.loop = true;
    image(video, 0, 0, width, height);
}
function draw() {
    image(video, 0, 0, width, height);
    // We can call both functions to draw all keypoints and the skeletons
    if(poses && showKeyPoints) {
        for(let i=0;i<poses.length;++i) {
            drawBody(poses[i], i);
        }
    }
    
    if(DEBUG) {
        Info_update();
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
        let kp = Object.assign({}, keypoints[j]);
        // kp.position.x = keypoints[j].position.x * canvas_width / media_width;
        // kp.position.y = keypoints[j].position.y * canvas_height / media_height;
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
// var video_player = document.querySelector("#service-action");
video_player.addEventListener("click", (e) => {
    video_isPlay = !video_isPlay;
    console.log("video_isPlay: " + video_isPlay);
    if(video_isPlay) {
        video_player_pause();
    } else {
        video_player_stop();
    }
});
var video_player_pause = () => {
    video_player.querySelector(".material-icons-outlined").innerHTML = "stop";
    // loop();
    video2.play();
}
var video_player_stop = () => {
    video_player.querySelector(".material-icons-outlined").innerHTML = "play_arrow";
    // noLoop();
    video2.pause();
}
// var action_player = document.querySelector("#classify-action");
action_player.addEventListener("click", (e) => {
    action_isPlay = !action_isPlay;
    console.log("action_isPlayp: " + action_isPlay);
    if(action_isPlay) {
        action_player_pause();
    } else {
        action_player_stop();
    }
    classify_count = 0;
    classify();
});
var action_player_pause = () => {
    action_player.querySelector(".material-icons-outlined").innerText = "stop_circle";
    loop();
}
var action_player_stop = () => {
    action_player.querySelector(".material-icons-outlined").innerText = "play_circle";
    noLoop();
}