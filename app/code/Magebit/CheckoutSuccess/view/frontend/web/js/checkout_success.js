window.onload = function () {
    var span = document.querySelector('.checkout-success span');
    var orderNumber = span.textContent;
    var orderID = span.textContent;
    alert(orderID)
    gtag("event", "purchase", {
        transaction_id: orderID,
        items: [
            // If someone purchases more than one item,
            // you can add those items to the items array
            {
                item_name: "Test Name",
        }]
    });
}

