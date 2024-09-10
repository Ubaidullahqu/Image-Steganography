// Assuming dct-js library is included
// Make sure to adapt to your actual DCT library functions


//Variable Declarations // Get references to HTML elements
let encodebtn = document.getElementById("encodebtn");
let encodeimage1fileinput = document.getElementById("encodeimage1");
let canvasbox = document.getElementById("canvasbox");
let secretTextField = document.getElementById("secretText");
let loadedImage;
let encodedImage;
let decodebtn = document.getElementById("decodebtn");
let decodeimage1fileinput = document.getElementById("decodeimage1");
let decodeimage2fileinput = document.getElementById("decodeimage2");
let decodeimage1;
let decodeimage2;

// Handle image file input
encodeimage1fileinput.addEventListener('change', (event) => {
    if (event.target.files && event.target.files[0]) {
        let file = event.target.files[0];
        let reader = new FileReader();
        reader.onload = function(e) {
            let imgElement = document.createElement('img');
            imgElement.src = e.target.result;
            imgElement.onload = function() {
                canvasbox.innerHTML = '';
                let canvas = document.createElement('canvas');
                let scaleFactor = 0.3;
                canvas.width = imgElement.width * scaleFactor;
                canvas.height = imgElement.height * scaleFactor;
                canvasbox.appendChild(canvas);
                let ctx = canvas.getContext('2d');
                ctx.drawImage(imgElement, 0, 0, canvas.width, canvas.height);
            }
        };
        reader.readAsDataURL(file);
    }
});

// Encode button handler
encodebtn.addEventListener("click", e => {
    console.log("encoding...");
    encodebtn.classList.add("disabled");

    if (encodeimage1fileinput.files && encodeimage1fileinput.files[0]) {
        let file = encodeimage1fileinput.files[0];
        let reader = new FileReader();
        reader.onload = function(e) {
            let imgElement = document.createElement('img');
            imgElement.src = e.target.result;
            imgElement.onload = function() {
                let canvas = document.createElement('canvas');
                canvas.width = imgElement.width;
                canvas.height = imgElement.height;
                let ctx = canvas.getContext('2d');
                ctx.drawImage(imgElement, 0, 0);

                let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                let dctImage = applyDCT(imageData.data);

                let secretText = secretTextField.value;
                let binaryMessage = textToBinary(secretText);

                encodeMessageWithDCT(dctImage, binaryMessage);

                let encodedImageData = applyIDCT(dctImage);
                ctx.putImageData(new ImageData(encodedImageData, canvas.width, canvas.height), 0, 0);

                downloadEncodedImage(canvas, 'encoded_image.jpg');
            }
        };
        reader.readAsDataURL(file);
    } else {
        alert("Please select an image file.");
    }
});

// Decode button handler
decodebtn.addEventListener("click", e => {
    console.log("decoding...");
    decodebtn.classList.add("disabled");

    if (decodeimage1fileinput.files && decodeimage1fileinput.files[0] && decodeimage2fileinput.files && decodeimage2fileinput.files[0]) {
        let file1 = decodeimage1fileinput.files[0];
        let file2 = decodeimage2fileinput.files[0];

        let reader1 = new FileReader();
        reader1.onload = function(e) {
            let imgElement1 = document.createElement('img');
            imgElement1.src = e.target.result;
            imgElement1.onload = function() {
                let reader2 = new FileReader();
                reader2.onload = function(e) {
                    let imgElement2 = document.createElement('img');
                    imgElement2.src = e.target.result;
                    imgElement2.onload = function() {
                        let canvas1 = document.createElement('canvas');
                        canvas1.width = imgElement1.width;
                        canvas1.height = imgElement1.height;
                        let ctx1 = canvas1.getContext('2d');
                        ctx1.drawImage(imgElement1, 0, 0);
                        let imageData1 = ctx1.getImageData(0, 0, canvas1.width, canvas1.height);
                        let dctImage1 = applyDCT(imageData1.data);

                        let canvas2 = document.createElement('canvas');
                        canvas2.width = imgElement2.width;
                        canvas2.height = imgElement2.height;
                        let ctx2 = canvas2.getContext('2d');
                        ctx2.drawImage(imgElement2, 0, 0);
                        let imageData2 = ctx2.getImageData(0, 0, canvas2.width, canvas2.height);
                        let dctImage2 = applyDCT(imageData2.data);

                        let decodedMessage = decodeMessageWithDCT(dctImage1, dctImage2);
                        secretTextField.value = binaryToText(decodedMessage);
                    }
                };
                reader2.readAsDataURL(file2);
            }
        };
        reader1.readAsDataURL(file1);
    } else {
        alert("Please select both image files.");
    }
});

// Functions for DCT operations
function applyDCT(data) {
    // Apply DCT to image data (implement or use a library function)
    // Example placeholder implementation
    return dct2d(data); // replace with actual DCT function
}

function applyIDCT(data) {
    // Apply Inverse DCT to image data (implement or use a library function)
    // Example placeholder implementation
    return idct2d(data); // replace with actual IDCT function
}

//Message Encoding and Decoding Functions
function encodeMessageWithDCT(dctData, binaryMessage) {
    // Embed the binary message into the DCT coefficients
    let index = 0;
    for (let i = 0; i < dctData.length; i++) {
        if (index < binaryMessage.length) {
            let bit = parseInt(binaryMessage[index]);
            dctData[i] = (dctData[i] & ~1) | bit; // Modify the coefficient
            index++;
        }
    }
}

function decodeMessageWithDCT(originalDctData, encodedDctData) {
    // Extract the message from DCT coefficients
    let binaryMessage = "";
    for (let i = 0; i < originalDctData.length; i++) {
        let originalValue = originalDctData[i] & 1;
        let encodedValue = encodedDctData[i] & 1;
        binaryMessage += (encodedValue !== originalValue) ? '1' : '0';
    }
    return binaryMessage;
}

function textToBinary(text) {
    let binaryMessage = '';
    for (let i = 0; i < text.length; i++) {
        let binaryChar = text[i].charCodeAt(0).toString(2);
        binaryMessage += '0'.repeat(8 - binaryChar.length) + binaryChar;
    }
    return binaryMessage;
}

function binaryToText(binaryMessage) {
    let textMessage = "";
    for (let i = 0; i < binaryMessage.length; i += 8) {
        let byte = binaryMessage.substr(i, 8);
        textMessage += String.fromCharCode(parseInt(byte, 2));
    }
    return textMessage;
}

function downloadEncodedImage(canvas, filename) {
    let link = document.createElement('a');
    let dataURL = canvas.toDataURL();
    link.href = dataURL;
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

let generateKeyBtn = document.getElementById("generateKeyBtn");
let secretKeyInput = document.getElementById("secretKeyInput");

function generateSecretKey(length = 16) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    return result;
}

generateKeyBtn.addEventListener("click", e => {
    const secretKey = generateSecretKey();
    secretKeyInput.value = secretKey;
});
