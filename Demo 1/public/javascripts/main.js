const API_URL = 'http://localhost:81/api/';

$(window).ready(function () {
    $.ajax({
        url: API_URL + 'product',
        method: 'GET',
        success: function (data) {
            renderContent(data);
        },
        error: function (error) {
            console.log('get all err: ' + error)
        }
    })
});

var renderContent = function (products) {
    var tBody = $('#product-list');
    tBody.empty();
    for (let i = 0; i < products.length; i++) {
        let tr = $('<tr>' +
            '<td>' + (i + 1) + '</td>' +
            '<td>' + products[i].productName + '</td>' +
            '<td>' + products[i].productPrice + '</td>' +
            '<td><input type="button" value="Edit" onClick="viewDetail(' + products[i].id + ')"/></td>' +
            '</tr>');
        tBody.append(tr);
    }
}

var viewDetail = function(id){
    $.ajax({
        url: API_URL + 'findById',
        method: 'POST',
        data:{
            'id': id
        },
        success: function (data) {
            console.log(data);
            renderContent(data);
        },
        error: function (error) {
            console.log('get all err: ' + error)
        }
    })
}
