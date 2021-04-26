var colorButton = document.getElementById("fill");
var colorDiv = document.getElementById("color_val");
// save empty canvas state when page loades for undo/redo
$(document).ready(function() {
    updateHistory();
});
        // when changing color without selection an object update colorDiv
        colorButton.onchange = function () {
            colorDiv.innerHTML = colorButton.value;
            updateHistory(); // when color changes save state for undo/redo
        }

        var canvas = this.__canvas = new fabric.Canvas('canvas');
        const undoButton = document.getElementById('undo');
        const redoButton = document.getElementById('redo');

        addRect.onclick = AddRect;
        addCircle.onclick = AddCircle;
        clearAll.onclick = ClearAll;
        //saveJSON.onclick = download(JSON.stringify(canvas.toJSON(['id'])),
        //    'json.txt', 'text/plain');
        saveJSON.onclick = SaveJSON;
        loadJSON.onclick = LoadJSON;
        //undo.onclick = UndoNew();
        //redo.onclick = RedoNew();
        function resizeCanvas() {
            canvas.setHeight(window.innerHeight - 100);
            canvas.setWidth(window.innerWidth - 100);
            canvas.renderAll();
        }

        // resize on init
        resizeCanvas();

        var objectId = 0;

        // create a rect object
        //var deleteIcon = "data:image/svg+xml,%3C%3Fxml version='1.0' encoding='utf-8'%3F%3E%3C!DOCTYPE svg PUBLIC '-//W3C//DTD SVG 1.1//EN' 'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'%3E%3Csvg version='1.1' id='Ebene_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='595.275px' height='595.275px' viewBox='200 215 230 470' xml:space='preserve'%3E%3Ccircle style='fill:%23F44336;' cx='299.76' cy='439.067' r='218.516'/%3E%3Cg%3E%3Crect x='267.162' y='307.978' transform='matrix(0.7071 -0.7071 0.7071 0.7071 -222.6202 340.6915)' style='fill:white;' width='65.545' height='262.18'/%3E%3Crect x='266.988' y='308.153' transform='matrix(0.7071 0.7071 -0.7071 0.7071 398.3889 -83.3116)' style='fill:white;' width='65.544' height='262.179'/%3E%3C/g%3E%3C/svg%3E";
        //var deleteIcon = "svg/remove.svg";
        var cloneIcon = "data:image/svg+xml,%3C%3Fxml version='1.0' encoding='iso-8859-1'%3F%3E%3Csvg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 55.699 55.699' width='100px' height='100px' xml:space='preserve'%3E%3Cpath style='fill:%23010002;' d='M51.51,18.001c-0.006-0.085-0.022-0.167-0.05-0.248c-0.012-0.034-0.02-0.067-0.035-0.1 c-0.049-0.106-0.109-0.206-0.194-0.291v-0.001l0,0c0,0-0.001-0.001-0.001-0.002L34.161,0.293c-0.086-0.087-0.188-0.148-0.295-0.197 c-0.027-0.013-0.057-0.02-0.086-0.03c-0.086-0.029-0.174-0.048-0.265-0.053C33.494,0.011,33.475,0,33.453,0H22.177 c-3.678,0-6.669,2.992-6.669,6.67v1.674h-4.663c-3.678,0-6.67,2.992-6.67,6.67V49.03c0,3.678,2.992,6.669,6.67,6.669h22.677 c3.677,0,6.669-2.991,6.669-6.669v-1.675h4.664c3.678,0,6.669-2.991,6.669-6.669V18.069C51.524,18.045,51.512,18.025,51.51,18.001z M34.454,3.414l13.655,13.655h-8.985c-2.575,0-4.67-2.095-4.67-4.67V3.414z M38.191,49.029c0,2.574-2.095,4.669-4.669,4.669H10.845 c-2.575,0-4.67-2.095-4.67-4.669V15.014c0-2.575,2.095-4.67,4.67-4.67h5.663h4.614v10.399c0,3.678,2.991,6.669,6.668,6.669h10.4 v18.942L38.191,49.029L38.191,49.029z M36.777,25.412h-8.986c-2.574,0-4.668-2.094-4.668-4.669v-8.985L36.777,25.412z M44.855,45.355h-4.664V26.412c0-0.023-0.012-0.044-0.014-0.067c-0.006-0.085-0.021-0.167-0.049-0.249 c-0.012-0.033-0.021-0.066-0.036-0.1c-0.048-0.105-0.109-0.205-0.194-0.29l0,0l0,0c0-0.001-0.001-0.002-0.001-0.002L22.829,8.637 c-0.087-0.086-0.188-0.147-0.295-0.196c-0.029-0.013-0.058-0.021-0.088-0.031c-0.086-0.03-0.172-0.048-0.263-0.053 c-0.021-0.002-0.04-0.013-0.062-0.013h-4.614V6.67c0-2.575,2.095-4.67,4.669-4.67h10.277v10.4c0,3.678,2.992,6.67,6.67,6.67h10.399 v21.616C49.524,43.26,47.429,45.355,44.855,45.355z'/%3E%3C/svg%3E%0A"

        var deleteImg = document.createElement('img');
        deleteImg.src = '../../img/floordrawing/remove.svg';
        var cloneImg = document.createElement('img');
        cloneImg.src = cloneIcon;

        fabric.Object.prototype.transparentCorners = false;
        fabric.Object.prototype.cornerColor = '#0000cc';
        fabric.Object.prototype.cornerStyle = 'circle';

        var json;

        function ClearAll() {
            updateHistory();
            canvas.clear();
        }
        json = '';
        function SaveJSON() {
            json = JSON.stringify(canvas.toJSON(['id']));
            console.log(json);
        }

        // function download(fileName, contentType) {
        //     var a = document.createElement("a");
        //     var file = new Blob([content], { type: contentType });
        //     a.href = URL.createObjectURL(file);
        //     a.download = fileName;
        //     a.click();
        // }

        function LoadJSON() {
            if (json != '')
                canvas.loadFromJSON(json);
            else
                console.log('no json saved!');
        }

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
                const jsonData = canvas.toJSON(['id']); // include object id in json data
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

        const UndoNew = () => {
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

        const RedoNew = () => {
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

        //------------ Undo/Redo section -----------//
        // var isRedoing = false;
        // var history = [];
        // canvas.on('object:added', function () {
        //     if (!isRedoing) {
        //         history = [];
        //     }
        //     isRedoing = false;
        // });

        // function Undo() {
        //     if (canvas._objects.length > 0) {
        //         history.push(canvas._objects.pop());
        //         canvas.renderAll();
        //     }
        // }

        // function Redo() {
        //     if (history.length > 0) {
        //         isRedoing = true;
        //         canvas.add(history.pop());
        //     }
        // }

        //------------ adding shapes section -----------//
        function AddRect() {
            var rect = new fabric.Rect({
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

        function AddCircle() {
            var circle = new fabric.Circle({
                id: objectId++,
                left: 100,
                top: 50,
                radius: 30,
                fill: '#FFFFFF',
                objectCaching: false,
                stroke: '#000000',
                strokeWidth: 4,
                cornerStyle: 'circle',
            });

            canvas.add(circle);
            canvas.setActiveObject(circle);
        };

        function renderIcon(icon) {
            return function renderIcon(ctx, left, top, styleOverride, fabricObject) {
                var size = this.cornerSize;
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

        function deleteObject(eventData, transform) {
            var target = transform.target;
            var canvas = target.canvas;
            canvas.remove(target);
            canvas.requestRenderAll();
        }

        function cloneObject(eventData, transform) {
            // var target = transform.target;
            // var canvas = target.canvas;
            // target.clone(function (cloned) {
            //     cloned.left += 10;
            //     cloned.top += 10;
            //     cloned.id = objectId++;
            //     canvas.add(cloned);
            // });
            var activeObject = canvas.getActiveObject();
            activeObject.clone(function (cloned) {
                canvas.discardActiveObject();
                cloned.set({
                    top: cloned.top + 20,
                    evented: true,
                    id: objectId++,
                }, ['id', 'componentType', 'shape']);
                // handle multiple objects selection
                if (cloned.type === 'activeSelection') {
                    // active selection needs a reference to the canvas.
                    cloned.canvas = canvas;
                    cloned.forEachObject(function (obj) {
                        canvas.add(obj);
                        obj.id = objectId++;
                    });
                    cloned.setCoords();
                } else {
                    canvas.add(cloned);
                }
                canvas.setActiveObject(cloned);
                canvas.requestRenderAll();
            });
        }

        // handle fill actions

        function observeValue(property) {
            document.getElementById(property).oninput = function () {
                if (!canvas.getActiveObject()) // if no object is selected
                    return;
                canvas.getActiveObject().set("fill", this.value);
                canvas.requestRenderAll();
                // updateHistory(); // changing object fill doesn't fire object:modified event so do it manually
                //canvas.fire('object:modified',{ target: canvas.getActiveObject() }); // manually fire object:modified
            };
        }
        observeValue('fill');

        canvas.on({
            'selection:updated': HandleElement,
            'selection:created': HandleElement,
            'selection:cleared': HandleUnselect // clear 
        });

        function HandleElement(obj) {
            var activeObj = canvas.getActiveObject()
            console.log("active obj id = ", activeObj.id);
            console.log("active obj color = ", activeObj.fill);
            var fill = document.getElementById('fill');
            colorDiv.innerHTML = activeObj.fill;
            fill.value = activeObj.fill;
        }
        // if no object is selected reset colorDiv value to white - '#FFFFFF'
        function HandleUnselect() {
            if (!canvas.getActiveObject())
                colorDiv.innerHTML = '#FFFFFF';
        }
        canvas.on('mouse:wheel', function (opt) {
            var delta = opt.e.deltaY;
            var zoom = canvas.getZoom();
            zoom *= 0.999 ** delta;
            if (zoom > 20) zoom = 20;
            if (zoom < 0.01) zoom = 0.01;
            canvas.zoomToPoint({ x: opt.e.offsetX, y: opt.e.offsetY }, zoom);
            opt.e.preventDefault();
            opt.e.stopPropagation();
        });
