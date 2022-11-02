$(function () {
    $('#post1').jpostal({
        click : '#address_btn',
        postcode : [
            '#post1'
        ],
        address : {
            '#address1' : '%3',
            '#address2' : '%4',
            '#address3' : '%5'
        }
    });
});
//複数用
$(function () {
    $('#post12').jpostal({
        click : '#address_btn2',
        postcode : [
            '#post12'
        ],
        address : {
            '#address12' : '%3',
            '#address22' : '%4',
            '#address32' : '%5'
        }
    });
});