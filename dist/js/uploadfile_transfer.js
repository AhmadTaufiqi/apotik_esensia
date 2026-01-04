const container = document.querySelector(".upload-container");
const form_ktp = container.closest('form');
const fileInput = document.querySelector(".file-input");
const progressArea = document.querySelector(".progress-area");
const uploadedArea = document.querySelector(".uploaded-area");
const img_ktp = $("#photo_product");

// form click event
container.addEventListener("click", () =>{
  console.log('clicked')
  fileInput.click();
});

fileInput.onchange = ({target})=>{
  let file_product = target.files[0]; //getting file [0] this means if user has selected multiple files then get first one only
  if(file_product){

    const reader = new FileReader(); //FileReader is a predefined function of JS
    // console.log(file_product)
    // console.log(reader)

    reader.addEventListener('load', function () {
      var is_submit = 0;
      $('#modal_product_resizer').modal('show')
              
      $('#modal_product_resizer').on('shown.bs.modal', function () {
  
      })

      $('#modal_product_resizer').on('hidden.bs.modal', function () {
          if(is_submit === 0){
              location.reload()
          }
      })
    });

    reader.readAsDataURL(file_product);

  }
}

// file upload function
function uploadFile(name){
  let xhr = new XMLHttpRequest(); //creating new xhr object (AJAX)
  xhr.open("POST", ""); //sending post request to the specified URL
  xhr.upload.addEventListener("progress", ({loaded, total}) =>{ //file uploading progress event
    let fileLoaded = Math.floor((loaded / total) * 100);  //getting percentage of loaded file size
    let fileTotal = Math.floor(total / 1000); //gettting total file size in KB from bytes
    let fileSize;
    // if file size is less than 1024 then add only KB else convert this KB into MB
    (fileTotal < 1024) ? fileSize = fileTotal + " KB" : fileSize = (loaded / (1024*1024)).toFixed(2) + " MB";
    let progressHTML = `<li class="row">
                          <i class="fas fa-file-alt"></i>
                          <div class="content">
                            <div class="details">
                              <span class="name">${name} • Uploading</span>
                              <span class="percent">${fileLoaded}%</span>
                            </div>
                            <div class="progress-bar">
                              <div class="progress" style="width: ${fileLoaded}%"></div>
                            </div>
                          </div>
                        </li>`;
    // uploadedArea.innerHTML = ""; //uncomment this line if you don't want to show upload history
    // uploadedArea.classList.add("onprogress");
    // progressArea.innerHTML = progressHTML;
    if(loaded == total){
      // progressArea.innerHTML = "";
      // let uploadedHTML = `<li class="row">
      //                       <div class="content upload">
      //                         <i class="fas fa-file-alt"></i>
      //                         <div class="details">
      //                           <span class="name">${name} • Uploaded</span>
      //                           <span class="size">${fileSize}</span>
      //                         </div>
      //                       </div>
      //                       <i class="fas fa-check"></i>
      //                     </li>`;
      // uploadedArea.classList.remove("onprogress");
      // uploadedArea.innerHTML = uploadedHTML; //uncomment this line if you don't want to show upload history
      // uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML); //remove this line if you don't want to show upload history
    }
  });

  let data = new FormData(form_ktp); //FormData is an object to easily send form data
  xhr.send(data); //sending form data
}

function checkImageProductResolution() {
  const fileInput = document.querySelector(".file-input");
  var file_product = fileInput.files[0];
  let fileName = file_product.name;
  
  var img2 = new Image();

  var fileInput2 = $('#base64_input');
  var base64_string = fileInput2.val();
  var base64_size = getFileSizeFromBase64(base64_string);
  console.log('file size ' + base64_size/1024/1024 + ' MB');
  // var cropped_image = dataURLtoFile(base64_string,filename)
  
  img2.onload = function () {
    
      if ((file_product.size/1024/1024) > 4){ //if file size is greater than 4MB
        reduceImageSize(base64_string, 800, 0.7).then((reducedBase64) => {
            var reduced_size = getFileSizeFromBase64(reducedBase64);
            console.log('reduced size ' + reduced_size/1024/1024 + ' MB');
            if(reduced_size/1024/1024 > 4){
                alert("Maksimum resolusi gambar harus 4 MB setelah dikompresi");
                fileInput.value = "";
                // img_ktp.setAttribute('src',prevImg);
            }else{
                // proceed with upload
                if(fileName.length >= 12){ //if file name length is greater than 12 then split it and add ...
                  let splitName = fileName.split('.');
                  fileName = splitName[0].substring(0, 13) + "... ." + splitName[1];
                }
                uploadFile(fileName); //calling uploadFile with passing file name as an argument
              
              fileInput2.val(reducedBase64);
            }
        });
      }else{
        // proceed with upload
        if(fileName.length >= 12){ //if file name length is greater than 12 then split it and add ...
          let splitName = fileName.split('.');
          fileName = splitName[0].substring(0, 13) + "... ." + splitName[1];
        }
        uploadFile(fileName); //calling uploadFile with passing file name as an argument
      }
    };

  // img.src = window.URL.createObjectURL(file);
  img2.src = base64_string
}

function getFileSizeFromBase64(base64String) {
  // Remove data URI prefix if present
  const parts = base64String.split(',');
  const encodedString = parts.length > 1 ? parts[1] : base64String;

  const base64StringLength = encodedString.length;
  let paddingCount = 0;

  if (encodedString.endsWith('==')) {
    paddingCount = 2;
  } else if (encodedString.endsWith('=')) {
    paddingCount = 1;
  }

  const fileSizeInBytes = (base64StringLength * 3 / 4) - paddingCount;
  return fileSizeInBytes;
}

function reduceImageSize(base64ImageData, maxWidth = 800, quality = 0.7) {
    return new Promise((resolve) => {
        const img = new Image();
        img.onload = () => {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            let newWidth = img.width;
            let newHeight = img.height;

            // Resize if wider than maxWidth
            if (newWidth > maxWidth) {
                const ratio = newWidth / newHeight;
                newWidth = maxWidth;
                newHeight = newWidth / ratio;
            }

            canvas.width = newWidth;
            canvas.height = newHeight;

            ctx.drawImage(img, 0, 0, newWidth, newHeight);

            // Get compressed Base64 data
            const compressedBase64 = canvas.toDataURL('image/jpeg', quality);
            resolve(compressedBase64);
        };
        img.src = base64ImageData;
    });
}