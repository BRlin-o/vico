var class_count = document.getElementById("class-count")
var knn_json = document.querySelector("#kNN-json-url");
var btn_knn_json = document.querySelector("#btn-kNN-json");
var btn_classify = document.querySelector("#classify-action");

class_count.addEventListener("change", (e) => {
    console.log(e.target.value);
    var count = e.target.value;
    var classify = document.getElementById("classify");
    classify.innerHTML = "";
    for(var i = 0; i < count; i++) {
        var div = document.createElement("div");
        div.classList.add("col-12");
        div.classList.add("input-group");
        div.classList.add("p-1");
        var label = document.createElement("span");
        label.classList.add("input-group-text");
        label.innerHTML = "Class " + i;
        var input1 = document.createElement("input");
        input1.classList.add("form-control");
        input1.id = `class-count-${i}`;
        input1.type = "number";
        input1.value = 0;
        var input2 = document.createElement("input");
        input2.classList.add("form-control");
        input2.id = `class-predict-${i}`;
        input2.type = "text";
        input2.value = "";
        var button = document.createElement("button");
        button.classList.add("btn");
        button.classList.add("btn-outline-secondary");
        button.type = "button";
        button.dataset.id = i;
        button.innerText = "Add";
        button.addEventListener("click", (e) => {
            console.log(e.target);
            addExample(e.target.dataset.id)
        });
        div.appendChild(label);
        div.appendChild(input1);
        div.appendChild(input2);
        div.appendChild(button);
        classify.appendChild(div);
    }
});

var addExample = (label) => {
    const poseArray = poses[0].pose.keypoints.map(p => [p.score, p.position.x, p.position.y]);
    knnClassifier.addExample(poseArray, label);
    try{
        info_message["example"][label].push({t: video.elt.currentTime, pose: poseArray});
    }catch (e) {
        info_message["example"][label] = [{t: video.elt.currentTime, pose: poseArray}];
    }
    updateCounts();
    // console.log("[addExample] label: " + label, "; poseArray: " + poseArray);
}
var updateCounts = () => {
    const counts = knnClassifier.getCountByLabel();
    Object.keys(counts).forEach((i) => {
        // console.log(i, counts[i] || 0);
        select("#class-count-" + i).value(counts[i] || 0);
    })
}
var classify = () => {
    const numLabels = knnClassifier.getNumLabels();
    if (numLabels <= 0) {
        console.error('There is no examples in any label');
        return;
    }
    if(poses.length > 0 && action_isPlay){
        try{
            const poseArray = poses[0].pose.keypoints.map(p => [p.score, p.position.x, p.position.y]);
            knnClassifier.classify(poseArray, gotResults);
        }catch(e) {
            console.log("e", e);
            console.log("poses", poses);
        }
    }
}

var build_class_form = () => {
    var classify = document.getElementById("classify");
    classify.innerHTML = "";
    const counts = knnClassifier.getCountByLabel();
    Object.keys(counts).forEach((i) => {
        // console.log(i, counts[i] || 0);
        var div = document.createElement("div");
        div.classList.add("col-12");
        div.classList.add("input-group");
        div.classList.add("p-1");
        var label = document.createElement("span");
        label.classList.add("input-group-text");
        label.innerHTML = "Class " + i;
        var input1 = document.createElement("input");
        input1.classList.add("form-control");
        input1.id = `class-count-${i}`;
        input1.type = "number";
        input1.value = counts[i] || 0;
        var input2 = document.createElement("input");
        input2.classList.add("form-control");
        input2.id = `class-predict-${i}`;
        input2.type = "text";
        input2.value = "";
        var button = document.createElement("button");
        button.classList.add("btn");
        button.classList.add("btn-outline-secondary");
        button.type = "button";
        button.dataset.id = i;
        button.innerText = "Add";
        button.addEventListener("click", (e) => {
            console.log(e.target);
            addExample(e.target.dataset.id)
        });
        div.appendChild(label);
        div.appendChild(input1);
        div.appendChild(input2);
        div.appendChild(button);
        classify.appendChild(div);
        class_count.value = parseInt(i) + 1;
        classify_count = parseInt(i) + 1;
        // select("#class-count-" + i).value();
    })
}
var loadKnnJson = () => {
    knnClassifier.load(knn_json.value, build_class_form);
    btn_classify.disabled = false;
}
btn_knn_json.addEventListener("click", loadKnnJson);

var action_count = 0;
var now_classify = 0;
var unjump = 0; //抑制彈跳
var unjump_count = 3;
var classify_count = 2;
var gotResults = (err, result) => {
    try{
        if (result.confidencesByLabel) {
            const confidences = result.confidencesByLabel;
            Object.keys(confidences).forEach((i) => {
                info_message['classify'][i] = `${confidences[i] ? parseInt(confidences[i] * 100, 10) : 0} %`;
                select(`#class-predict-${i}`).value(`${confidences[i] ? parseInt(confidences[i] * 100, 10) : 0} %`);
            })
            var mostClassify = Object.entries(confidences).reduce((a, b) => a[1] > b[1] ? a : b)[0];
            classify_count = Object.keys(confidences).length;
            // const result = Object.entries(confidences).reduce((a, b) => a[1] > b[1] ? a : b)[0];
            if(mostClassify == (now_classify + 1) % classify_count) {
                unjump += 1;
                if (unjump >= unjump_count) {
                    // if ((now_classify + 1) % classify_count == 0){
                    //     action_count+=1;
                    //     document.querySelector("#action-count").value = action_count;
                    //     console.log("action-count +1");
                    // }
                    if (now_classify == classify_count-1){
                        action_count+=1;
                        document.querySelector("#action-count").value = action_count
                    }
                    unjump = 0;
                    now_classify = mostClassify;
                }
            }
            info_message["action_count"] = action_count;
            info_message["now_classify"] = now_classify;
            info_message["unjump"] = unjump;
            info_message["unjump_count"] = unjump_count;
            info_message["classify_count"] = classify_count;
            info_message["mostClassify"] = Object.entries(confidences).reduce((a, b) => a[1] > b[1] ? a : b)[0];
            // info_message["val"] = classify_count;
            // info_message["test"] = result
            Info_update();
        }
    }catch (e) {
        console.log("e", e);
        console.log("err", err);
        console.log("result", result);
    }
    
    classify();
}