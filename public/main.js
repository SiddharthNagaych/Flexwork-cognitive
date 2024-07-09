const menuButton = document.getElementById('menu-button');
const menu = document.getElementById('menu');
menuButton.addEventListener('click', () => {
    menu.classList.toggle('hidden');
});

document.addEventListener('DOMContentLoaded', () => {
    const stripe = Stripe('YOUR_STRIPE_PUBLISHABLE_KEY');
    const paymentForm = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const formSubmitButton = document.getElementById('form-submit');
    const agreementCheckbox = document.getElementById('agreement');

    agreementCheckbox.addEventListener('change', (event) => {
        if (event.target.checked) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
            formSubmitButton.disabled = true;
        }
    });

    submitButton.addEventListener('click', async (event) => {
        event.preventDefault();

        const response = await fetch('/create-payment-intent', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ amount: 50000 }) // Rs. 500 in smallest currency unit
        });

        const { clientSecret } = await response.json();

        const result = await stripe.confirmCardPayment(clientSecret, {
            payment_method: {
                card: {
                    // Provide card details here or use Elements
                },
                billing_details: {
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                },
            },
        });

        if (result.error) {
            console.error(result.error.message);
        } else {
            if (result.paymentIntent.status === 'succeeded') {
                formSubmitButton.disabled = false;
            }
        }
    });
});
function enableSubmit() {
    var agreementCheckbox = document.getElementById('agreement');
    var submitButton = document.getElementById('submitBtn');

    if (agreementCheckbox.checked) {
        submitButton.disabled = false;
    } else {
        submitButton.disabled = true;
    }
}