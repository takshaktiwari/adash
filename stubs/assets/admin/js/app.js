$('.toast').toast('show');
$("select[multiple]").select2();
$("select.select2").select2();

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
    if ($("body").hasClass('vertical-collpsed')) {
        localStorage.setItem("sidebar", "show");
    }else{
        localStorage.setItem("sidebar", "hidden");
    }
});


$(".btn-loader:not(.delete-alert)").click(function(event) {

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

function imageCropper(userImageRatio=16/9){
    // image-box is the id of the div element that will store our cropping image preview
    const imagebox = document.getElementById('image-box')
        // crop-btn is the id of button that will trigger the event of change original file with cropped file.
    const crop_btn = document.getElementById('crop-btn')
    // id_image is the id of the input tag where we will upload the image
    const input = document.getElementById('crop-image')

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

                // Hide the cropper modal
                $("#cropModal").modal('hide');

            });
        });
    }); 
} 

! function(t) {
    "use strict";

    function e() {
        document.webkitIsFullScreen || document.mozFullScreen || document.msFullscreenElement || (console.log("pressed"), t("body").removeClass("fullscreen-enable"))
    }
    t("#side-menu").metisMenu(), t("#vertical-menu-btn").on("click", function(e) {
            e.preventDefault(), t("body").toggleClass("sidebar-enable"), 992 <= t(window).width() ? t("body").toggleClass("vertical-collpsed") : t("body").removeClass("vertical-collpsed")
        }), t("#sidebar-menu a").each(function() {
            var e = window.location.href.split(/[?#]/)[0];
            this.href == e && (t(this).addClass("active"), t(this).parent().addClass("mm-active"), t(this).parent().parent().addClass("mm-show"), t(this).parent().parent().prev().addClass("mm-active"), t(this).parent().parent().parent().addClass("mm-active"), t(this).parent().parent().parent().parent().addClass("mm-show"), t(this).parent().parent().parent().parent().parent().addClass("mm-active"))
        }), t(".navbar-nav a").each(function() {
            var e = window.location.href.split(/[?#]/)[0];
            this.href == e && (t(this).addClass("active"), t(this).parent().addClass("active"), t(this).parent().parent().addClass("active"), t(this).parent().parent().parent().addClass("active"), t(this).parent().parent().parent().parent().addClass("active"))
        }), t('[data-toggle="fullscreen"]').on("click", function(e) {
            e.preventDefault(), t("body").toggleClass("fullscreen-enable"), document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement ? document.cancelFullScreen ? document.cancelFullScreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitCancelFullScreen && document.webkitCancelFullScreen() : document.documentElement.requestFullscreen ? document.documentElement.requestFullscreen() : document.documentElement.mozRequestFullScreen ? document.documentElement.mozRequestFullScreen() : document.documentElement.webkitRequestFullscreen && document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT)
        }), document.addEventListener("fullscreenchange", e), document.addEventListener("webkitfullscreenchange", e), document.addEventListener("mozfullscreenchange", e), t(".right-bar-toggle").on("click", function(e) {
            t("body").toggleClass("right-bar-enabled")
        }), t(document).on("click", "body", function(e) {
            0 < t(e.target).closest(".right-bar-toggle, .right-bar").length || t("body").removeClass("right-bar-enabled")
        }), t(".dropdown-menu a.dropdown-toggle").on("click", function(e) {
            return t(this).next().hasClass("show") || t(this).parents(".dropdown-menu").first().find(".show").removeClass("show"), t(this).next(".dropdown-menu").toggleClass("show"), !1
        }), t(function() {
            t('[data-toggle="tooltip"]').tooltip()
        }), t(function() {
            t('[data-toggle="popover"]').popover()
        }),
        t(window).on("load", function() {
            t("#status").fadeOut(), t("#preloader").delay(350).fadeOut("slow")
        }), Waves.init()
}(jQuery);