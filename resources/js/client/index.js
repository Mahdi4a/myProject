var pathname;
$(document).ready(function () {

    pathname = window.location.pathname;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document.head.querySelector("meta[name='csrf-token']").content,
        }
    })
    if (pathname.includes('single_product')) {
        // $(".openCommentModal").click(function () {
        //     $("#sendComment").modal('toggle')
        //     $("#sendComment").find('input[name="parent_id"]').val($(this).data('id'))
        // })
        //
        // document.querySelector('#commentForm').addEventListener('submit', function (event) {
        //     event.preventDefault();
        //     let data = {
        //         comment: $("#commentForm textarea[name=comment]").val(),
        //         comment_id: $("#commentForm input[name=comment_id]").val(),
        //         comment_type: $("#commentForm input[name=comment_type]").val(),
        //         parent_id: $("#commentForm input[name=parent_id]").val(),
        //     }
        //     if (data.comment.length < 4) {
        //         console.error('pls enter comment more than 4 char');
        //         return;
        //     }
        //     $.ajax({
        //         type: 'post',
        //         url: '',
        //         data: JSON.stringify(data),
        //         success: function (response) {
        //             console.log(response)
        //             $("#sendComment").modal('toggle')
        //             $("#commentForm textarea[name=comment]").val('')
        //         },
        //     })
        //
        // })
        function GetValueOnChange(id = '#attributes') {
            let url;
            if (id === '#attributes') url = "/product/attribute/value";
            else url = "/product/value/details";
            $(id).change(function (e) {
                let element = $(this);
                $.ajax({
                    type: "post",
                    url: url,
                    data: {
                        data: element.val()
                    },
                    success: (data) => {
                        if (id === '#attributes') {
                            $("#values").html(data.view)
                            GetValueOnChange("#values")
                        }
                        $(".cart_value").val(data.id)
                        $(".cart_attribute_id").val(data.attribute_id)
                        $("#item_discounted_price").html(data.price_with_discount)
                        $("#item_price").html(data.price)
                    },
                });
            })
        }


        GetValueOnChange();
        GetValueOnChange("#values");
    }
    $(".order-detail").click(function (e) {
        $("#baseModal").modal('toggle')
        $.ajax({
            type: "get",
            url: "/profile/orders/detail",
            data: {
                data: $(this).data('item')
            },
            success: (data) => {
                console.log(data)
                $("#modalBody").html(data)
            },
        });
    })

})

// external client cart js

var removedItem,
    sum = 0;

$(function () {
    // calculate the values at the start
    calculatePrices();

    // Click to remove an item
    $(document).on("click", "a.remove", function () {
        removeItem.apply(this);
    });

    // Undo removal link click
    $(document).on("click", ".removeAlert a", function () {
        // insert it into the table
        addItemBackIn();
        //remove the removal alert message
        hideRemoveAlert();
    });

    $(document).on("change", "input.quantity", function () {
        var val = $(this).val(),
            pricePer,
            total

        if (val <= "0") {
            removeItem.apply(this);
        } else {
            // reset the prices
            sum = 0;

            // get the price for the item
            pricePer = $(this).parents("td").prev("td").text();
            // set the pricePer to a nice, digestable number
            pricePer = formatNum(pricePer);
            // calculate the new total
            total = parseFloat(val * pricePer).toFixed(0);
            // set the total cell to the new price
            $(this).parents("td").siblings(".itemTotal").text(total + " تومان ");

            // recalculate prices for all items
            calculatePrices();
        }
    });

});


function removeItem() {
    // store the html
    removedItem = $(this).closest("tr").clone();
    // fade out the item row
    $(this).closest("tr").fadeOut(500, function () {
        $(this).remove();
        sum = 0;
        calculatePrices();
    });
    // fade in the removed confirmation alert
    $(".removeAlert").fadeIn();

    // default to hide the removal alert after 5 sec
    setTimeout(function () {
        hideRemoveAlert();
    }, 5000);
}

function hideRemoveAlert() {
    $(".removeAlert").fadeOut(500);
}

function addItemBackIn() {
    sum = 0;
    $(removedItem).prependTo("table.items tbody").hide().fadeIn(500)
    calculatePrices();
}

function updateSubTotal() {
    $("table.items td.itemTotal").each(function () {
        var value = $(this).text();
        // set the pricePer to a nice, digestable number
        value = formatNum(value);

        sum += parseFloat(value);
        $("table.pricing td.subtotal").text(sum.toFixed(0) + " تومان ");
    });
}

function addTax() {
    var tax = parseFloat(sum * 0).toFixed(0);
    $("table.pricing td.tax").text(tax + " تومان ");
}

function calculateTotal() {
    var subtotal = $("table.pricing td.subtotal").text(),
        tax = $("table.pricing td.tax").text(),
        shipping = $("table.pricing td.shipping").text(),
        total;

    subtotal = formatNum(subtotal);
    tax = formatNum(tax);
    shipping = formatNum(shipping);

    total = (subtotal + tax + shipping).toFixed(0);

    $("table.pricing td.orderTotal").text(total + " تومان ");
}

function calculatePrices() {
    updateSubTotal();
    addTax();
    calculateTotal();
}

function formatNum(num) {
    return parseFloat(num.replace(/[^0-9-.]/g, ''));
}
