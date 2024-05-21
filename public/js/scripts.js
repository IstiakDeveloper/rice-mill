
//For modal Open Close
function openModal() {
    document.getElementById('entryModal').classList.remove('hidden');
}
function closeModal() {
    document.getElementById('entryModal').classList.add('hidden');
}
//For modal Open End

//For Bosta price
document.getElementById('bag_size').addEventListener('change', function () {
    var selectedSize = this.value;
    var perBagPriceInput = document.getElementById('per_bag_price');

    // Set the corresponding price based on the selected bag size
    if (selectedSize === 'feed') {
        perBagPriceInput.value = '30'; // Set the price for small size
    } else if (selectedSize === 'gom') {
        perBagPriceInput.value = '40'; // Set the price for medium size
    } else if (selectedSize === 'vushi') {
        perBagPriceInput.value = '45'; // Set the price for large size
    } else if (selectedSize === 'gom l') {
        perBagPriceInput.value = '50';
    } else {
        perBagPriceInput.value = ''; // Clear the price if no size is selected
    }
});
//Bosta price end




//For Entry form
function checkCustomer(value) {
    $.ajax({
        url: '/api/customers',
        method: 'GET',
        data: { name: value },
        success: function(response) {
            let customerList = $('#customer_list');
            customerList.empty().removeClass('hidden');
            if (response.customers.length > 0) {
                response.customers.forEach(customer => {
                    customerList.append(`<div class="p-2 bg-gray-200 cursor-pointer" onclick="selectCustomer(${customer.id}, '${customer.name}', '${customer.area}', '${customer.phone_number}', '${customer.image}', ${customer.season_id})">${customer.name}</div>`);
                });
            } else {
                $('#customer_list').addClass('hidden');
                $('#customer_fields').removeClass('hidden');
            }
        }
    });
}

function selectCustomer(id, name, area, phone_number, image, season_id) {
    $('#customer_id').val(id); // Set the hidden input with the customer ID
    $('#customer_name').val(name);
    $('#area').val(area).parent().removeClass('hidden');
    $('#phone_number').val(phone_number).parent().removeClass('hidden');
    $('#image').parent().removeClass('hidden');
    $('#customer_list').addClass('hidden');
}

$('#entryForm').submit(function(event) {
    event.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            closeModal();
            // Optionally, refresh the page or update the dashboard
        },
        error: function(response) {
            console.log(response);
            // Handle errors here
        }
    });
});

//entry end



// Payment Entry Start
function openPaymentModal() {
    $('#paymentModal').removeClass('hidden');
    $.ajax({
        url: '/api/customers',
        method: 'GET',
        data: { name: $('#customer_name').val() },
        success: function(response) {
            if (response.customers.length > 0) {
                populateCustomersDropdown(response.customers);
                console.log('customer found');
            } else {
                console.error('No customers found with the provided name.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Failed to fetch customers: ', error);
        }
    });
}

function closePaymentModal() {
    $('#paymentModal').addClass('hidden');
}

function populateCustomersDropdown(customers) {
    var customerDropdown = document.getElementById('customer_id2');
    customerDropdown.innerHTML = '<option value="">Select Customer</option>'; // Clear existing options
    customers.forEach(function(customer) {
        var option = document.createElement('option');
        option.value = customer.id;
        option.textContent = customer.name;
        option.dataset.total = customer.total; // Set the data-total attribute
        option.dataset.remainingBalance = customer.remaining_balance; // Add remaining balance data attribute
        customerDropdown.appendChild(option);
    });
}

// Function to update input value with remaining balance
function updateRemainingBalance(customerId) {
    var selectedCustomer = document.getElementById('customer_id2').querySelector('option[value="' + customerId + '"]');
    if (selectedCustomer && selectedCustomer.dataset.remainingBalance) {
        document.getElementById('customer_total').textContent = selectedCustomer.dataset.remainingBalance;
    } else {
        console.error('Failed to fetch customer remaining balance.');
        document.getElementById('customer_total').textContent = '';
    }
}


//Payment Entry End
