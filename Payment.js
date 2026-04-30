document.getElementById('payment-form').onsubmit = function(e){
e.preventDefault();
    var options = {
        "key": "rzp_test_UtVxBNGPOuf0NL", // Enter the Key ID generated from the Dashboard
        "amount": "50000", // Amount is in currency subunits. 
        "currency": "INR",
        "name": "Wordpress-Payment-Gateway", //your business name
        "description": "Testing",
        "callback_url": "http://localhost/Assignment-Payment-gateway/payment-success/",
        "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
            "name": document.getElementById("name").value, //your customer's name
            "email": document.getElementById("email").value,
            "contact": document.getElementById("phone").value //Provide the customer's phone number for better conversion rates 
        },
        "handler": function(res){
            alert("Your Payment is Successful!, Payment ID : "+res.razorpay_payment_id);
            document.getElementById("payment_id").value = res.razorpay_payment_id;
            document.getElementById("payment-form").submit();
            // window.location.href = "http://localhost/Assignment-Payment-gateway/payment-success/";
        },
        "theme": {
            "color": "#3399cc"
        }
};
var rzp1 = new Razorpay(options);
    rzp1.open();
    e.preventDefault();
}