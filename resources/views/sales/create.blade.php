@extends('layouts.app')

@section('title', 'POS Sale - Grocery Stock Manager')

@section('content')
<div class="row">
    <!-- Left Column: POS Items -->
    <div class="col-lg-7 mb-4">
        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-cart3 me-2"></i> Point of Sale</h5>
                <span class="badge bg-light text-primary rounded-pill fs-6 px-3" id="cartItemCount">0 Items</span>
            </div>
            <div class="card-body d-flex flex-column bg-body-tertiary p-4">
                <!-- Search Bar and Dropdown -->
                <div class="row g-2 mb-3">
                    <div class="col-md-7 position-relative">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" id="productSearch" class="form-control form-control-lg" placeholder="Search by Product Name or SKU..." autocomplete="off">
                        </div>
                        <ul id="searchResults" class="list-group position-absolute w-100 shadow-sm" style="z-index: 1050; display: none; max-height: 250px; overflow-y: auto;">
                            <!-- Results injected here via JS -->
                        </ul>
                    </div>
                    <div class="col-md-5">
                        <select id="productDropdown" class="form-select form-select-lg" onchange="addFromDropdown(this)">
                            <option value="">-- Or Select Product --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                        data-product='{"id":{{ $product->id }},"name":"{{ $product->name }}","price":{{ $product->price }},"current_stock":{{ $product->current_stock }},"sku":"{{ $product->sku }}"}'>
                                    {{ $product->name }} ({{ $product->current_stock }} in stock)
                                </option>
                            @endforeach
                        </select>
                    </div>
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

            <div class="card shadow-sm mb-4 border-0 rounded-4">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="mb-0 fw-bold text-uppercase text-muted"><i class="bi bi-person-lines-fill me-2"></i>Customer Info</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="row g-3">
                        <div class="col-12">
                            <input type="text" class="form-control form-control-lg bg-light border-0" name="customer_name" placeholder="Customer Name (Walk-in)">
                        </div>
                        <div class="col-12">
                            <input type="text" class="form-control form-control-lg bg-light border-0" name="customer_phone" placeholder="Phone Number (Optional)">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4 border-0 rounded-4">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="mb-0 fw-bold text-uppercase text-muted"><i class="bi bi-receipt me-2"></i>Order Summary</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-secondary fs-5">Subtotal</span>
                        <strong class="fs-5" id="summarySubtotal">Rs. 0.00</strong>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-secondary">Tax (Rs.)</span>
                        <div class="input-group w-50">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-plus-slash-minus"></i></span>
                            <input type="number" step="0.01" min="0" class="form-control text-end bg-light border-0" name="tax_amount" id="taxInput" value="0" onchange="calculateTotals()">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-secondary">Discount (Rs.)</span>
                        <div class="input-group w-50">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-percent"></i></span>
                            <input type="number" step="0.01" min="0" class="form-control text-end bg-light border-0" name="discount_amount" id="discountInput" value="0" onchange="calculateTotals()">
                        </div>
                    </div>
                    
                    <hr class="text-muted opacity-25 my-4">
                    
                    <div class="d-flex justify-content-between align-items-center p-3 bg-primary bg-opacity-10 rounded-3">
                        <h4 class="mb-0 fw-bold text-primary">Total</h4>
                        <h2 class="mb-0 fw-bold text-primary" id="summaryTotal">Rs. 0.00</h2>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4 border-0 rounded-4">
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted text-uppercase mb-3">Payment Method</label>
                        <div class="d-flex gap-2">
                            <input type="radio" class="btn-check" name="payment_method" id="payCash" value="cash" checked required>
                            <label class="btn btn-outline-primary flex-fill py-3" for="payCash"><i class="bi bi-cash-stack fs-4 d-block mb-1"></i> Cash</label>

                            <input type="radio" class="btn-check" name="payment_method" id="payCard" value="card">
                            <label class="btn btn-outline-primary flex-fill py-3" for="payCard"><i class="bi bi-credit-card fs-4 d-block mb-1"></i> Card</label>

                            <input type="radio" class="btn-check" name="payment_method" id="payMobile" value="mobile">
                            <label class="btn btn-outline-primary flex-fill py-3" for="payMobile"><i class="bi bi-phone fs-4 d-block mb-1"></i> Mobile</label>
                        </div>
                    </div>
                    <div>
                        <textarea class="form-control bg-light border-0" name="notes" rows="2" placeholder="Add optional order notes here..."></textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-lg w-100 shadow py-3 fw-bold fs-5 rounded-pill" id="checkoutBtn" disabled>
                <i class="bi bi-check2-circle me-2"></i> Complete Sale
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

    function addFromDropdown(selectElement) {
        if (!selectElement.value) return;
        
        const option = selectElement.options[selectElement.selectedIndex];
        const productData = JSON.parse(option.getAttribute('data-product'));
        
        addToCart(productData);
        
        // Reset dropdown
        selectElement.value = '';
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
                tr.className = 'bg-white shadow-sm rounded-3 mb-2 d-table-row border-bottom-0';
                tr.style.transition = 'all 0.2s';
                
                const itemSubtotal = item.price * item.qty;
                
                tr.innerHTML = `
                    <td class="ps-3 border-0 py-3 rounded-start">
                        <div class="fw-bold text-dark fs-6">${item.name}</div>
                        <div class="text-muted small"><i class="bi bi-box me-1"></i>Stock: ${item.stock}</div>
                    </td>
                    <td class="border-0 align-middle">Rs. ${item.price.toFixed(2)}</td>
                    <td class="border-0 align-middle">
                        <div class="input-group input-group-sm w-100" style="min-width: 100px;">
                            <button class="btn btn-outline-secondary px-2" type="button" onclick="updateQty(${item.id}, ${item.qty - 1})">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="text" class="form-control text-center px-1" value="${item.qty}" 
                                   onchange="updateQty(${item.id}, this.value)">
                            <button class="btn btn-outline-secondary px-2" type="button" onclick="updateQty(${item.id}, ${item.qty + 1})">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </td>
                    <td class="border-0 align-middle"><strong class="text-primary">Rs. ${itemSubtotal.toFixed(2)}</strong></td>
                    <td class="border-0 align-middle pe-3 rounded-end">
                        <button type="button" class="btn btn-sm btn-light text-danger rounded-circle p-2" onclick="removeFromCart(${item.id})">
                            <i class="bi bi-trash-fill"></i>
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
        
        // Update item count badge
        document.getElementById('cartItemCount').textContent = cart.length + (cart.length === 1 ? ' Item' : ' Items');
        
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
