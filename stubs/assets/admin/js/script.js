$("select[multiple]").select2();
$("select.select2").select2();


function loader(action = true) {
  var elm = $("#loader");
  if (action) {
    elm.css("display", "flex");
  } else {
    elm.css("display", "none");
  }
}
$(window).on("load", function () {
  loader(false);
});

$(".delete-alert").click(function(event) {
    var confirmation = confirm('Are you sure to delete this? Deleted items will not revert.');

    if ($(this).hasClass('btn-loader') && confirmation == true) {
        btnLoader($(this));
    }

    return confirmation;
});

if (localStorage.getItem("sidebar") == 'hidden') {
    $("body").addClass('sidebar-enable vertical-collpsed');
}
$("#vertical-menu-btn").click(function(event) {
    setTimeout(function () {
        if ($("body").hasClass('vertical-collpsed')) {
            localStorage.setItem("sidebar", "hidden");
        } else {
            localStorage.setItem("sidebar", "show");
        }
    }, 500);
});


$(".btn-loader:not(.delete-alert), button[type='submit'], a:not(.no-loader, [href^='javascript:'], [href=''], [href='#'], [href^='mailto:'], [href^='tel:'], [href^='smss:'], [target='_blank'], [download])").click(function(event) {

    if ($(this).attr('type') == 'submit') {
        if (!$(this).parent().parent()[0].checkValidity()) {
            return true;
        }
    }

    if ($(this).attr('load-active') == '1') {
        $(this).html($(this).attr('data-org-text'));
        $(this).attr('load-active', 0);
        return true;
    }

    btnLoader($(this));
});

function btnLoader(elm) {
    var textColor = elm.attr('load-color');
    textColor = textColor ? textColor : 'light';

    var orgText = elm.html();
    elm.html('<div class="spinner-border text-'+textColor+' spinner-border-sm"></div>');
    elm.attr('load-active', '1');
    elm.attr('load-org-text', orgText);
    if (!elm.hasClass('load-circle')) {
        var loadText = elm.attr('load-text');
        loadText = loadText ? loadText : ' Please Wait ...';
        elm.append(loadText);
    }
}

function imageCropper(targetId='crop-image', userImageRatio=16/9, previewImg=null){

    // image-box is the id of the div element that will store our cropping image preview
    const imagebox = document.getElementById('image-box')
        // crop-btn is the id of button that will trigger the event of change original file with cropped file.
    const crop_btn = document.getElementById('crop-btn')
    // id_image is the id of the input tag where we will upload the image
    const input = document.getElementById(targetId)

    // imagePreview is the id of the input where image will be displayed before upload
    const imagePreview = document.getElementById(
        previewImg.targetId ? previewImg.targetId : 'image-preview'
    );

    // When user uploads the image this event will get triggered
    input.addEventListener('change', ()=>{
        // Getting image file object from the input variable
        const img_data = input.files[0]
        // createObjectURL() static method creates a DOMString containing a URL representing the object given in the parameter.
        // The new object URL represents the specified File object or Blob object.
        const url = URL.createObjectURL(img_data)

        $("#cropModal").modal('show');

        // Creating a image tag inside imagebox which will hold the cropping view image(uploaded file) to it using the url created before.
        imagebox.innerHTML = `<img src="${url}" id="image" style="width:100%;">`

        // Storing that cropping view image in a variable
        const image = document.getElementById('image')

        // Creating a croper object with the cropping view image
        // The new Cropper() method will do all the magic and diplay the cropping view and adding cropping functionality on the website
        // For more settings, check out their official documentation at https://github.com/fengyuanchen/cropperjs
        const cropper = new Cropper(image, {
            autoCropArea: 1,
            viewMode: 1,
            scalable: false,
            zoomable: false,
            movable: false,
            minCropBoxWidth: 200,
            minCropBoxHeight: 200,
            initialAspectRatio: userImageRatio,
            aspectRatio: userImageRatio,
        })

        // When crop button is clicked this event will get triggered
        crop_btn.addEventListener('click', ()=>{
            // This method coverts the selected cropped image on the cropper canvas into a blob object
            cropper.getCroppedCanvas().toBlob((blob)=>{

                // Gets the original image data
                let fileInputElement = input;
                // Make a new cropped image file using that blob object, image_data.name will make the new file name same as original image
                let file = new File([blob], img_data.name,{type:"image/*", lastModified:new Date().getTime()});
                // Create a new container
                let container = new DataTransfer();
                // Add the cropped image file to the container
                container.items.add(file);
                // Replace the original image file with the new cropped image file
                fileInputElement.files = container.files;


                if (previewImg) {
                    const previewUrl = URL.createObjectURL(file)
                    var previewImgWidth = previewImg.width ? previewImg.width : '100px';
                    imagePreview.innerHTML = `<img src="${previewUrl}" id="img_preview" style="width:${previewImgWidth}; height:${previewImg.height}; border-radius: ${previewImg.rounded}">`
                }

                // Hide the cropper modal
                $("#cropModal").modal('hide');

            });
        });
    });
}
