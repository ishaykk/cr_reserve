let contextMenuItems;
let objectId = 0;
const canvas = new fabric.Canvas('canvas', {
    preserveObjectStacking: true
});
//canvas.setWidth(window.innerWidth - 100);
//canvas.setHeight(window.innerHeight - 100);
fitToContainer(canvas);

function fitToContainer(canvas){
    canvas.setWidth(window.innerWidth - 150);
    canvas.setHeight(window.innerHeight - 150);
}

const colorButton = document.getElementById("fill");
const colorDiv = document.getElementById("color_val");

//Add right-click event monitoring on the upper-layer object of the canvas
$(".upper-canvas").contextmenu(onContextmenu);

//Initialize the right-click menu
$.contextMenu({
    selector: '#contextmenu-output',
    trigger: 'none',
    build: function ($trigger, e) {
        //The build method of the build menu item will be executed every right click
        return {
            callback: contextMenuClick,
            items: contextMenuItems
        };
    },
});

//Right click event response
function onContextmenu(event) {
    var pointer = canvas.getPointer(event.originalEvent);
    var objects = canvas.getObjects();
    for (var i = objects.length - 1; i >= 0; i--) {
        var object = objects[i];
        //Determine whether the object is at the mouse click
        if (object.containsPoint(pointer)) {
            //Select the object
            canvas.setActiveObject(object);
            //Display menu
            showContextMenu(event, object);
            continue;
        }
    }
    //Block the system right-click menu
    event.preventDefault();
    return false;
}

//Right-click menu item click
function showContextMenu(event, object) {
    //Define the right-click menu item
    contextMenuItems = {
        "delete": { name: "Delete", icon: "delete", data: object },
        "add": { name: "Add", icon: "add", data: object },
        "clone": { name: "Clone", icon: "copy", data: object },
    };
    //Right-click menu display position
    var position = {
        x: event.clientX,
        y: event.clientY
    }
    $('#contextmenu-output').contextMenu(position);
}

//Right-click menu item click
function contextMenuClick(key, options) {
    if (key == "delete") {
        //Get the corresponding object and delete
        var object = contextMenuItems[key].data;
        canvas.remove(object);
    } else if (key == "add") {
        var rect3 = new fabric.Rect({ top: 50, left: 350, width: 70, height: 70, fill: 'red' });
        canvas.add(rect3);
        canvas.renderAll();
    } else if (key == "clone") {
        console.log("clone");
        cloneObject();
    }
}

// when changing color without selection an object update colorDiv
colorButton.onchange = function () {
    colorDiv.innerHTML = colorButton.value;
    updateHistory(); // when color changes save state for undo/redo
}

const undoButton = document.getElementById('undo');
const redoButton = document.getElementById('redo');

let cloneIcon = "data:image/svg+xml,%3C%3Fxml version='1.0' encoding='iso-8859-1'%3F%3E%3Csvg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 55.699 55.699' width='100px' height='100px' xml:space='preserve'%3E%3Cpath style='fill:%23010002;' d='M51.51,18.001c-0.006-0.085-0.022-0.167-0.05-0.248c-0.012-0.034-0.02-0.067-0.035-0.1 c-0.049-0.106-0.109-0.206-0.194-0.291v-0.001l0,0c0,0-0.001-0.001-0.001-0.002L34.161,0.293c-0.086-0.087-0.188-0.148-0.295-0.197 c-0.027-0.013-0.057-0.02-0.086-0.03c-0.086-0.029-0.174-0.048-0.265-0.053C33.494,0.011,33.475,0,33.453,0H22.177 c-3.678,0-6.669,2.992-6.669,6.67v1.674h-4.663c-3.678,0-6.67,2.992-6.67,6.67V49.03c0,3.678,2.992,6.669,6.67,6.669h22.677 c3.677,0,6.669-2.991,6.669-6.669v-1.675h4.664c3.678,0,6.669-2.991,6.669-6.669V18.069C51.524,18.045,51.512,18.025,51.51,18.001z M34.454,3.414l13.655,13.655h-8.985c-2.575,0-4.67-2.095-4.67-4.67V3.414z M38.191,49.029c0,2.574-2.095,4.669-4.669,4.669H10.845 c-2.575,0-4.67-2.095-4.67-4.669V15.014c0-2.575,2.095-4.67,4.67-4.67h5.663h4.614v10.399c0,3.678,2.991,6.669,6.668,6.669h10.4 v18.942L38.191,49.029L38.191,49.029z M36.777,25.412h-8.986c-2.574,0-4.668-2.094-4.668-4.669v-8.985L36.777,25.412z M44.855,45.355h-4.664V26.412c0-0.023-0.012-0.044-0.014-0.067c-0.006-0.085-0.021-0.167-0.049-0.249 c-0.012-0.033-0.021-0.066-0.036-0.1c-0.048-0.105-0.109-0.205-0.194-0.29l0,0l0,0c0-0.001-0.001-0.002-0.001-0.002L22.829,8.637 c-0.087-0.086-0.188-0.147-0.295-0.196c-0.029-0.013-0.058-0.021-0.088-0.031c-0.086-0.03-0.172-0.048-0.263-0.053 c-0.021-0.002-0.04-0.013-0.062-0.013h-4.614V6.67c0-2.575,2.095-4.67,4.669-4.67h10.277v10.4c0,3.678,2.992,6.67,6.67,6.67h10.399 v21.616C49.524,43.26,47.429,45.355,44.855,45.355z'/%3E%3C/svg%3E%0A"

let deleteImg = document.createElement('img');
deleteImg.src = '../../img/floordrawing/remove.svg';
let cloneImg = document.createElement('img');
cloneImg.src = cloneIcon;

fabric.Object.prototype.transparentCorners = false;
fabric.Object.prototype.cornerColor = '#0000cc';
fabric.Object.prototype.cornerStyle = 'circle';

function clearAll() {
    updateHistory();
    canvas.clear();
}

$("#saveJSON").click(function () {
    let dateNow = new Date().toLocaleString();//.split(' ');
    let parsedDate = dateNow.replace(/[/:]/g, '-').split(',');
    console.log(parsedDate[1].split(' '));
    let timestamp = (parsedDate[0] + '-' + parsedDate[1].split(' ')[1]);
    const json = JSON.stringify(canvas.toJSON(['id', 'room_id']), null, 2);
    const a = document.createElement("a");
    const file = new Blob([json], {
        type: 'json' //'text/plain'
    });
    a.href = URL.createObjectURL(file);
    a.download = 'drawData' + '_' + timestamp + '.json';
    a.click();
});

$('#loadjson').change(function(e) {
    var file = e.target.files[0];
    if(!file) return;
    var reader = new FileReader();
    reader.onload = function(f) {
      var data = f.target.result;
      canvas.loadFromJSON(
      JSON.parse(data),
      canvas.renderAll.bind(canvas));
    };
    reader.readAsText(file);
});

//------------ Undo/Redo New section -----------//
var canvasHistory = {
    state: [],
    currentStateIndex: -1,
    undoStatus: false,
    redoStatus: false,
    undoFinishedStatus: true,
    redoFinishedStatus: true,
};

const updateHistory = () => {
    if (canvasHistory.undoStatus === true || canvasHistory.redoStatus === true)
        console.log('Do not do anything, this got triggered automatically while the undo and redo actions were performed');
    else {
        const jsonData = canvas.toJSON(['id', 'room_id']); // include object id in json data
        const canvasAsJson = JSON.stringify(jsonData);

        // NOTE: This is to replace the canvasHistory when it gets rewritten 20180912:Alevale
        if (canvasHistory.currentStateIndex < canvasHistory.state.length - 1) {

            const indexToBeInserted = canvasHistory.currentStateIndex + 1;
            canvasHistory.state[indexToBeInserted] = canvasAsJson;
            const elementsToKeep = indexToBeInserted + 1;
            console.log(`History rewritten, preserved ${elementsToKeep} items`);
            canvasHistory.state = canvasHistory.state.splice(0, elementsToKeep);

            // NOTE: This happens when there is a new item pushed to the canvasHistory (normal case) 20180912:Alevale
        } else {
            console.log('push to canvasHistory');
            canvasHistory.state.push(canvasAsJson);
        }

        canvasHistory.currentStateIndex = canvasHistory.state.length - 1;
        console.log("currentStateIndex = ", canvasHistory.currentStateIndex);
        console.log("state length = ", canvasHistory.state.length);
        updateButtonsState();
    }
};

canvas.on('object:added', () => {
    updateHistory();
});
canvas.on('object:modified', () => {
    updateHistory();
    });
canvas.on({
    'mouse:down': function(e) {
        if(e.target) {
            e.target.opacity = 0.5;
            canvas.renderAll();
        }
    },
    'mouse:up': function(e) {
        if(e.target) {
            e.target.opacity = 1;
            canvas.renderAll();
        }
    },
    'object:moved': function(e) {
        e.target.opacity = 0.1;
    },
    'object:modified': function(e) {
        e.target.opacity = 1;
    },
});

const undo = () => {
    if (canvasHistory.currentStateIndex - 1 === -1) {
        console.log('nothing in the past');
        return;
    }

    if (canvasHistory.undoFinishedStatus) {
        canvasHistory.undoFinishedStatus = false;
        canvasHistory.undoStatus = true;
        canvas.loadFromJSON(canvasHistory.state[canvasHistory.currentStateIndex - 1], () => {
            canvas.renderAll();
            canvasHistory.undoStatus = false;
            canvasHistory.currentStateIndex--;
            canvasHistory.undoFinishedStatus = true;
            //console.log("undo action was performed!");
        });
    }
    console.log("currentStateIndex = ", canvasHistory.currentStateIndex);
    updateButtonsState();
};

const redo = () => {
    if (canvasHistory.currentStateIndex + 1 === canvasHistory.state.length) {
        console.log('nothing in the future');
        return;
    }

    if (canvasHistory.redoFinishedStatus) {
        canvasHistory.redoFinishedStatus = false;
        canvasHistory.redoStatus = true;
        canvas.loadFromJSON(canvasHistory.state[canvasHistory.currentStateIndex + 1], () => {
            canvas.renderAll();
            canvasHistory.redoStatus = false;
            canvasHistory.currentStateIndex++;
            canvasHistory.redoFinishedStatus = true;
        });
    }
    console.log("currentStateIndex = ", canvasHistory.currentStateIndex);
    updateButtonsState();
};

function updateButtonsState() {
    undoButton.disabled = (canvasHistory.currentStateIndex > 0) ? false : true;
    redoButton.disabled = (canvasHistory.state.length - canvasHistory.currentStateIndex >= 2 && canvasHistory.currentStateIndex > -1) ? false : true;
}

//------------ adding shapes section -----------//
function addRect() {
    const rect = new fabric.Rect({
        id: objectId++,
        left: 100,
        //originX: 'center',
        top: 50,
        //originY: 'center',
        fill: '#FFFFFF',
        width: 200,
        height: 100,
        objectCaching: false,
        stroke: '#000000',
        strokeWidth: 4,
        cornerStyle: 'circle',
        strokeUniform: true,
        //evented: false,
    });
    // var text = new fabric.IText('404', {
    //     fontSize: 30,
    //     originX: 'center',
    //     originY: 'center'
    // });

    // var group = new fabric.Group([rect, text], {
    //     left: 150,
    //     top: 100,
    //     angle: 0
    // });

    // canvas.add(group);
    // canvas.setActiveObject(group);

    canvas.add(rect);
    canvas.setActiveObject(rect);
}

function addCircle() {
    const circle = new fabric.Circle({
        id: objectId++,
        left: 100,
        top: 50,
        radius: 30,
        fill: '#FFFFFF',
        objectCaching: false,
        stroke: '#000000',
        strokeWidth: 4,
        strokeUniform: true,
        cornerStyle: 'circle',
    });

    canvas.add(circle);
    canvas.setActiveObject(circle);
};
function addText() {
    let text = new fabric.IText('Text', {
        fontSize: 30,
        top: 50,
        left: 100,
        originX: 'center',
        originY: 'center'
    });
    canvas.add(text);
    canvas.setActiveObject(text);
}

const toFront = () => {
    canvas.getActiveObject().bringToFront();
}

const toBack = () => {
    canvas.getActiveObject().sendToBack();
}

document.addEventListener('keydown', function(e) {
    const activeObj = canvas.getActiveObject();
    if(activeObj) {
        switch(e.key) {
            case 'ArrowRight': 
                e.preventDefault();
                activeObj.left += 2;
                updateHistory();
                break;
            case 'ArrowLeft':
                e.preventDefault();
                activeObj.left -= 2;
                updateHistory();
                break;
            case 'ArrowUp':
                e.preventDefault();
                activeObj.top -= 2;
                updateHistory();
                break;
            case 'ArrowDown':
                e.preventDefault();
                activeObj.top += 2;
                updateHistory();
                break;
            case 'Delete':
                e.preventDefault();
                deleteObject();
                updateHistory();
                break;
        }
        canvas.renderAll(); 
    }
});

function renderIcon(icon) {
    return function renderIcon(ctx, left, top, styleOverride, fabricObject) {
        const size = this.cornerSize;
        ctx.save();
        ctx.translate(left, top);
        ctx.rotate(fabric.util.degreesToRadians(fabricObject.angle));
        ctx.drawImage(icon, -size / 2, -size / 2, size, size);
        ctx.restore();
    }
}

fabric.Object.prototype.controls.deleteControl = new fabric.Control({
    x: 0.5,
    y: -0.5,
    offsetY: -16,
    offsetX: 16,
    cursorStyle: 'pointer',
    mouseUpHandler: deleteObject,
    render: renderIcon(deleteImg),
    cornerSize: 24
});

fabric.Object.prototype.controls.clone = new fabric.Control({
    x: -0.5,
    y: -0.5,
    offsetY: -16,
    offsetX: -16,
    cursorStyle: 'pointer',
    mouseUpHandler: cloneObject,
    render: renderIcon(cloneImg),
    cornerSize: 24
});

function deleteObject() {
    updateHistory();
    const activeObject = canvas.getActiveObjects();
    canvas.discardActiveObject();
    canvas.remove(...activeObject);

}

function cloneObject(eventData, transform) {
    const activeObject = canvas.getActiveObject();
    //if(activeObject.room_id) return;
    activeObject.clone(function (cloned) {
        canvas.discardActiveObject();
        cloned.set({
            left: cloned.left + cloned.width,
            evented: true,
            id: objectId++,
            room_id: activeObject.room_id,
        }, ['id', 'componentType', 'shape', 'room_id']);
        // handle multiple objects selection
        if (cloned.type === 'activeSelection') {
            // active selection needs a reference to the canvas.
            cloned.canvas = canvas;
            cloned.forEachObject(function (obj) {
                canvas.add(obj);
                obj.id = objectId++;
                //room_id = activeObject.room_id;
            });
            cloned.setCoords();
        } else {
            canvas.add(cloned);
        }
        canvas.setActiveObject(cloned);
        canvas.requestRenderAll();
    });
}


// handle fill action for each selected object
function observeValue(property) {
    document.getElementById(property).oninput = function () {
        if (!canvas.getActiveObject()) // if no object is selected
            return;
        canvas.getActiveObjects().forEach((object) => {
            object.set('fill', this.value);
        });
        canvas.renderAll();
    };
}
observeValue('fill');

canvas.on({
    'selection:updated': HandleElement,
    'selection:created': HandleElement,
    'selection:cleared': HandleUnselect // clear 
});

// Update color_val to selected obj color and bring selected obj to front
function HandleElement(obj) {
    console.log("active obj id = ", obj.target.id);
    console.log("active obj color = ", obj.target.fill);
    $('#fill').val(obj.target.fill);
    colorDiv.innerHTML = obj.target.fill;
    //obj.target.bringToFront();
}

// if no object is selected reset colorDiv value to white - '#FFFFFF'
function HandleUnselect() {
    if (!canvas.getActiveObject())
        colorDiv.innerHTML = '#FFFFFF';
}

// handle mousewheel event to zoom-in / zoom-out
canvas.on('mouse:wheel', function (opt) {
    const delta = opt.e.deltaY;
    let zoom = canvas.getZoom();
    zoom *= 0.999 ** delta;
    if (zoom > 20) zoom = 20;
    if (zoom < 0.01) zoom = 0.01;
    canvas.zoomToPoint({ x: opt.e.offsetX, y: opt.e.offsetY }, zoom);
    opt.e.preventDefault();
    opt.e.stopPropagation();
});

// save canvas state when page loades for undo/redo
updateHistory();
