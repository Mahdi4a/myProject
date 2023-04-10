<script>
    let imageNumber = 0;
    let input_id;
    let preview_id;

    $("#add_product_image").click(function (event) {
        event.preventDefault();
        let attributesSection = $("#mainImageDiv");
        let temp = document.getElementById('imageTemplate').cloneNode(true);
        temp.id = "";
        let elements = temp.querySelectorAll('img,input');
        for (let i = 0; i < elements.length; i++) {
            elements[i].setAttribute('id', elements[i].getAttribute('id') + (imageNumber));
            if (elements[i].getAttribute('type') === 'text') elements[i].value = "";
            else elements[i].src = "/default/notFound.jpeg";
        }
        attributesSection.append(temp);
        deleteDiv(".deleteImageDiv", ".imageDiv");
        addFileManager();
        imageNumber++;

    })

    function deleteDiv(element = '.deleteAttributeDiv', parentClass = ".row") {
        $(element).click(function (e) {
            let element = $(this);
            let parent = element.closest(parentClass);
            if (parent[0].id !== 'imageTemplate') {
                parent.remove();
                imageNumber--;
            }
        })
    }


    function addFileManager(element = ".button-image") {
        $(element).click((event) => {
            event.preventDefault();
            let item = event.target.closest('.imageDiv').querySelectorAll('input,img');
            console.log(item)
            input_id = item[0].id;
            preview_id = item[1].id;
            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    }

    document.addEventListener("DOMContentLoaded", function () {

        $(".button-image").click((event) => {
            event.preventDefault();
            let item = event.target.closest('.imageDiv').querySelectorAll('input,img');
            console.log(item)
            input_id = item[0].id;
            preview_id = item[1].id;
            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });


    // set file link
    function fmSetLink($url) {
        document.getElementById(input_id).value = $url;
        document.getElementById(preview_id).src = $url;
    }
</script>
