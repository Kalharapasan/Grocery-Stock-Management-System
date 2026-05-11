@extends('layouts.app')

@section('title', 'POS Sale - Grocery Stock Manager')

@section('content')
<div class="row">
    <!-- Left Column: POS Items -->
    <div class="col-lg-7 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-cart"></i> Point of Sale</h5>
            </div>
            <div class="card-body d-flex flex-column">
                <!-- Search Bar -->
                <div class="position-relative mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" id="productSearch" class="form-control form-control-lg" placeholder="Search by Product Name or SKU..." autocomplete="off">
                    </div>
                    <ul id="searchResults" class="list-group position-absolute w-100 shadow-sm" style="z-index: 1050; display: none; max-height: 250px; overflow-y: auto;">
                        <!-- Results injected here via JS -->
                    </ul>
                </div>

                <!-- Cart Table -->
                <div class="table-responsive flex-grow-1" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-hover align-middle">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Product</th>
                                <th width="120">Price</th>
                                <th width="130">Qty</th>
                                <th width="120">Subtotal</th>
                                <th width="50"></th>
                            </tr>
                        </thead>
                        <tbody id="cartTableBody">
                            <tr id="emptyCartRow">
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="bi bi-cart-x fs-1 d-block mb-2"></i>
                                    Cart is empty. Search for products to add.
                                </td>
                            </tr>
                            <!-- Cart items injected via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Checkout -->
    <div class="col-lg-5 mb-4">
        <form method="POST" action="{{ route('sales.store') }}" id="saleForm">
            @csrf
            <!-- Hidden inputs container for cart items -->
            <div id="hiddenItemsContainer"></div>

            <div class="card shadow-sm mb-3">
                <div class="card-header bg-light"><strong><i class="bi bi-person"></i> Customer Info</strong></div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-12">
                            <input type="text" class="form-control" name="customer_name" placeholder="Customer Name (Walk-in)">
                        </div>
                        <div class="col-12">
                            <input type="text" class="form-control" name="customer_phone" placeholder="Phone Number (Optional)">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-header bg-light"><strong><i class="bi bi-calculator"></i> Order Summary</strong></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <strong id="summarySubtotal">Rs. 0.00</strong>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Tax (Rs.)</span>
                        <input type="number" step="0.01" min="0" class="form-control form-control-sm w-25 text-end" name="tax_amount" id="taxInput" value="0" onchange="calculateTotals()">
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Discount (Rs.)</span>
                        <input type="number" step="0.01" min="0" class="form-control form-control-sm w-25 text-end" name="discount_amount" id="discountInput" value="0" onchange="calculateTotals()">
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Total</h4>
                        <h3 class="mb-0 text-primary" id="summaryTotal">Rs. 0.00</h3>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-select form-select-lg" required>
                            <option value="cash">💵 Cash</option>
                            <option value="card">💳 Card</option>
                            <option value="mobile">📱 Mobile Pay</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="2" placeholder="Optional notes..."></textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-lg w-100 shadow" id="checkoutBtn" disabled>
                <i class="bi bi-check-circle"></i> Complete Sale
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let cart = [];
    
    // Search elements
    const searchInput = document.getElementById('productSearch');
    const searchResults = document.getElementById('searchResults');
    
    // UI Elements
    const cartTableBody = document.getElementById('cartTableBody');
    const emptyCartRow = document.getElementById('emptyCartRow');
    const summarySubtotal = document.getElementById('summarySubtotal');
    const summaryTotal = document.getElementById('summaryTotal');
    const taxInput = document.getElementById('taxInput');
    const discountInput = document.getElementById('discountInput');
    const hiddenItemsContainer = document.getElementById('hiddenItemsContainer');
    const checkoutBtn = document.getElementById('checkoutBtn');

    // Handle Search input
    let searchTimeout = null;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch(`/sales/search?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    searchResults.innerHTML = '';
                    if (data.length === 0) {
                        searchResults.innerHTML = '<li class="list-group-item text-muted">No products found.</li>';
                    } else {
                        data.forEach(product => {
                            const li = document.createElement('li');
                            li.className = 'list-group-item list-group-item-action cursor-pointer d-flex justify-content-between align-items-center';
                            li.innerHTML = `
                                <div>
                                    <strong>${product.name}</strong> <small class="text-muted">(${product.sku})</small>
                                </div>
                                <div class="text-end">
                                    <span class="d-block text-primary">Rs. ${parseFloat(product.price).toFixed(2)}</span>
                                    <small class="text-muted">Stock: ${product.current_stock}</small>
                                </div>
                            `;
                            li.onclick = () => addToCart(product);
                            searchResults.appendChild(li);
                        });
                    }
                    searchResults.style.display = 'block';
                });
        }, 300);
    });

    // Close search results on click outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });

    function addToCart(product) {
        // Check if item already exists in cart
        const existingItemIndex = cart.findIndex(item => item.id === product.id);
        
        if (existingItemIndex !== -1) {
            if (cart[existingItemIndex].qty < product.current_stock) {
                cart[existingItemIndex].qty += 1;
            } else {
                alert('Not enough stock available!');
                return;
            }
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: parseFloat(product.price),
                stock: product.current_stock,
                qty: 1
            });
        }

        searchInput.value = '';
        searchResults.style.display = 'none';
        renderCart();
    }

    function updateQty(id, newQty) {
        const item = cart.find(i => i.id === id);
        if(!item) return;

        let parsedQty = parseInt(newQty);
        if (isNaN(parsedQty) || parsedQty < 1) parsedQty = 1;
        
        if (parsedQty > item.stock) {
            alert(`Only ${item.stock} items available in stock!`);
            parsedQty = item.stock;
        }

        item.qty = parsedQty;
        renderCart();
    }

    function removeFromCart(id) {
        cart = cart.filter(item => item.id !== id);
        renderCart();
    }

    function renderCart() {
        if (cart.length === 0) {
            cartTableBody.innerHTML = '';
            cartTableBody.appendChild(emptyCartRow);
            checkoutBtn.disabled = true;
        } else {
            checkoutBtn.disabled = false;
            cartTableBody.innerHTML = '';
            hiddenItemsContainer.innerHTML = '';

            cart.forEach((item, index) => {
                const tr = document.createElement('tr');
                const itemSubtotal = item.price * item.qty;
                
                tr.innerHTML = `
                    <td>
                        <strong>${item.name}</strong>
                        <div class="text-muted small">Max: ${item.stock}</div>
                    </td>
                    <td>Rs. ${item.price.toFixed(2)}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm text-center" 
                               value="${item.qty}" min="1" max="${item.stock}" 
                               onchange="updateQty(${item.id}, this.value)">
                    </td>
                    <td><strong>Rs. ${itemSubtotal.toFixed(2)}</strong></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-danger border-0" onclick="removeFromCart(${item.id})">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </td>
                `;
                cartTableBody.appendChild(tr);

                // Add hidden inputs for form submission
                hiddenItemsContainer.innerHTML += `
                    <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][quantity]" value="${item.qty}">
                `;
            });
        }
        calculateTotals();
    }

    function calculateTotals() {
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        summarySubtotal.textContent = `Rs. ${subtotal.toFixed(2)}`;

        const tax = parseFloat(taxInput.value) || 0;
        const discount = parseFloat(discountInput.value) || 0;

        const total = subtotal + tax - discount;
        summaryTotal.textContent = `Rs. ${Math.max(0, total).toFixed(2)}`;
    }

    // Initialize
    calculateTotals();
</script>
<style>
    .cursor-pointer { cursor: pointer; }
    #searchResults .list-group-item:hover { background-color: #f8f9fa; }
</style>
@endsection
