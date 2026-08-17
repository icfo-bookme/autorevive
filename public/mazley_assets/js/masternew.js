
function collapse(id) {
    //e.preventDefault();

    var varClass = "#collapseLi"+id;

   

    if ($(varClass).hasClass("activado")) {
        $(varClass).removeClass("activado");
        $(varClass)
            .children("ul")
            .slideUp();
    } else {
        $(".menu li ul").slideUp();
        $(".menu li").removeClass("activado");
        $(varClass).addClass("activado");
        $(varClass)
            .children("ul")
            .slideDown();
    }
}

function searchProductByCategory(id) {

    $.ajax({
        url: '{{url("searchProductByCategory")}}',
        type: 'get',
        data: {
            "_token": "{{ csrf_token() }}",
            id: id
        },
        success: function (data) {

            $('#allProducts').empty();
            $('#pregination').empty();
            $('#allProducts').html(data);
        },

        error: function () {
            alert("error");
        }
    });
}