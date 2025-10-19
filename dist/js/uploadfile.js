const container = document.querySelector(".upload-container");
const form_ktp = container.closest('form');
const fileInput = document.querySelector(".file-input");
const progressArea = document.querySelector(".progress-area");
const uploadedArea = document.querySelector(".uploaded-area");
const img_ktp = $("#photo_product");

const img_cropper_ktp = document.querySelector('#img_product_cropper');
var cropper = new Cropper(img_cropper_ktp,{
    aspectRatio:7/6,
    zoomable:false,
    minContainerHeight:250,
    minContainerWidth:300,
})

// form click event
container.addEventListener("click", () =>{
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
      cropper.replace(reader.result)
              
      $('#modal_product_resizer').on('shown.bs.modal', function () {
          cropped_img = cropper.getCroppedCanvas().toDataURL('image/png')
          $('#output_product_resizer').attr('src',cropped_img)
          
          $('#btn_cropper').on('click',function(){
            cropped_img = cropper.getCroppedCanvas().toDataURL('image/png')

            $('#output_product_resizer').attr('src',cropped_img)
          })
          $('#submit_product_cropper').on('click',function(){
            console.log(is_submit)
              is_submit = 1;
              const cropped_img2 = cropper.getCroppedCanvas().toDataURL('image/png')
              console.log(cropped_img2);
              
              $('#base64_input').val(cropped_img2)
              checkImageProductResolution()
              
              // file.val(dataURLtoFile(cropped_img2,choosedFile.name))
              img_ktp.attr('src', cropped_img2);
              img_ktp.show()
              $('#modal_product_resizer').modal('hide')
          })
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
  console.log(file_product)
  var img2 = new Image();
  console.log(img);
  // var prevImg = img.getAttribute('src');

  var fileInput2 = $('#base64_input');
  var base64_string = fileInput2.val();
  // var cropped_image = dataURLtoFile(base64_string,filename)
  
  img2.onload = function () {
      if ((file_product.size/1024) > 4000) {
          alert("Maksimum resolusi gambar harus 2 MB");
          fileInput.value = "";
          // img_ktp.setAttribute('src',prevImg);
      }else{
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