var pathname;
$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document.head.querySelector("meta[name='csrf-token']").content,
            'Content-Type': 'application/json'
        }
    })
    pathname = window.location.pathname;
    $('.selectSearch').select2({
        dir: "rtl",
        'placeholder': 'یکی از آیتم ها را انتخاب کنید',
        "language": {
            "noResults": function () {
                return "آیتمی یافت نشد";
            }
        },
    });

    function GetValueOnChange(element = '.attribute-select') {
        $(element).change(function (e) {
            let element = $(this);
            $.ajax({
                type: "get",
                url: "/admin/attribute/value",
                data: {
                    id: element.val()
                },
                success: (data) => {
                    element.closest('.col-2').nextAll('div').first().find('select').html(data)
                },
            });
        })
    }

    function deleteDiv(element = '.deleteAttributeDiv', parentClass = ".row") {
        $(element).click(function (e) {
            let element = $(this);
            let parent = element.closest(parentClass);
            if (parent[0].id !== 'imageTemplate' && parent[0].id !== 'attributeTemplate')
                parent.remove()
        })
    }

    function addSelect2(element = ".tag-select") {
        $(element).select2({dir: "rtl", tags: true});
    }

    function removeSelect2(element = ".tag-select") {
        $(element).select2('destroy');
    }

    $("#add_product_attribute").click(function (event) {
        event.preventDefault();
        let attributesSection = $("#attribute_section");
        // let id = attributesSection.children().length;
        let temp = document.getElementById('attributeTemplate').cloneNode(true);
        temp.id = "";
        let elements = temp.querySelectorAll('select,input');
        let select = temp.querySelectorAll('.select2-container--default');
        for (let i = 0; i < select.length; i++) {
            select[i].remove();
        }
        for (let i = 0; i < elements.length; i++) {
            elements[i].value = "";
        }
        attributesSection.append(temp);
        removeSelect2();
        addSelect2();
        GetValueOnChange();
        deleteDiv();
    })

    addSelect2();
    GetValueOnChange();
    deleteDiv();
    deleteDiv(".deleteImageDiv", ".imageDiv");
});





