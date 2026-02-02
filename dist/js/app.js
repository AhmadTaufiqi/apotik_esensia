//declearing html elements

const imgDiv = document.querySelector('.profile-pic-div');
const img = document.querySelector('#photo');
const file_profile = document.querySelector('#file_profile');
const uploadBtn = document.querySelector('#uploadBtn');
localStorage.setItem("old_photo_profile",img.getAttribute('src'));

const img_cropper = document.querySelector('#img_cropper');
var cropper = new Cropper(img_cropper,{
    aspectRatio:4/4,
    zoomable:false,
    minContainerHeight:250,
    minContainerWidth:250,
})

//if user hover on img div

imgDiv.addEventListener('mouseenter', function () {
    uploadBtn.style.display = "block";
});

//if we hover out from img div

imgDiv.addEventListener('mouseleave', function () {
    uploadBtn.style.display = "none";
});

//lets work for image showing functionality when we choose an image to upload

//when we choose a foto to upload

file_profile.addEventListener('change', function () {
    //this refers to file
    const choosedFile = this.files[0];

    if (choosedFile) {

        const reader = new FileReader(); //FileReader is a predefined function of JS

        reader.addEventListener('load', function () {
            var is_submit = 0;
            $('#modal_resizer').modal('show')
            cropper.replace(reader.result)

            $('#modal_resizer').on('shown.bs.modal', function () {
                cropped_img = cropper.getCroppedCanvas().toDataURL('image/png')
                $('#output_resizer').attr('src',cropped_img)

                $('#btn_profile_cropper').on('click',function(){
                    cropped_img = cropper.getCroppedCanvas().toDataURL('image/png')
                    $('#output_resizer').attr('src',cropped_img)
                })
                $('#submit_profile_cropper').on('click',function(){
                    is_submit = 1;
                    console.log(is_submit);
                    const cropped_img2 = cropper.getCroppedCanvas().toDataURL('image/png')

                    $('#foto_base64').val(cropped_img2)
                    checkImageResolutionProfile()

                    // file.val(dataURLtoFile(cropped_img2,choosedFile.name))
                    img.setAttribute('src', cropped_img2);
                    $('#modal_resizer').modal('hide')
                })
            })

            $('#modal_resizer').on('hidden.bs.modal', function () {
                if(is_submit === 0){
                    location.reload()
                }
            })
        });

        reader.readAsDataURL(choosedFile);

        //Allright is done

        //please like the video
        //comment if have any issue related to vide & also rate my work in comment section

        //And aslo please subscribe for more tutorial like this

        //thanks for watching
    }
});

// membatasi resolusi gambar

function checkImageResolutionProfile() {
    var fileInput = document.getElementById('file_profile');
    console.log(fileInput);
    var file = fileInput.files[0];
    var filename = file.name;
    var img2 = new Image();

    var fileInput2 = $('#foto_base64');
    var base64_string = fileInput2.val();
    // var cropped_image = dataURLtoFile(base64_string,filename)
    
    img2.onload = function () {
        if ((file.size/1024) > 2000) {
            alert("Maksimum resolusi gambar harus 2 MB");
            fileInput.value = "";
            img.setAttribute('src',localStorage.getItem("old_photo_profile"));
            base64_string = '';
        }
    };

    // img.src = window.URL.createObjectURL(file);
    img2.src = base64_string
}

function dataURLtoFile(dataurl, filename) {
    var arr = dataurl.split(','),
        mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[arr.length - 1]),
        n = bstr.length,
        u8arr = new Uint8Array(n);
    while(n--){
        u8arr[n] = bstr.charCodeAt(n);
    }
    return new File([u8arr], filename, {type:mime});
}