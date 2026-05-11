
@extends('layouts.app')

@section('title', 'New Sale - Grocery Stock Manager')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <h3 class="mb-4"><i class="bi bi-cart-plus"></i> New Sale</h3>

        <form method="POST" action="{{ route('sales.store') }}" id="saleForm">
            @csrf

            <div class="card mb-3">
                <div class="card-header"><strong>Customer Information</strong></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Customer Name</label>
                            <input type="text" class="form-control" name="customer_name" placeholder="Walk-in Customer">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="customer_phone" placeholder="Optional">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Items</strong>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addItem()">
                        <i class="bi bi-plus"></i> Add Item
                    </button>
                </div>
                <div class="card-body">
                    <div id="itemsContainer">
                        <div class="item-row border rounded p-3 mb-3" data-index="0">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-5">
                                    <label class="form-label">Product</label>
                                    <select class="form-select product-select" name="items[0][product_id]" required onchange="updatePrice(this)">
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}"
                                                    data-price="{{ $product->price }}"
                                                    data-stock="{{ $product->current_stock }}"
                                                    data-unit="{{ $product->unit }}">
                                                {{ $product->name }} ({{ $product->current_stock }} {{ $product->unit }} in stock)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Qty</label>
                                    <input type="number" class="form-control qty-input" name="items[0][quantity]" min="1" value="1" required onchange="updateSubtotal(this)">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Price</label>
                                    <input type="text" class="form-control price-display" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Subtotal</label>
                                    <input type="text" class="form-control subtotal-display" readonly>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(this)" style="display:none;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <h4>Total: <span id="grandTotal">Rs. 0.00</span></h4>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <label class="form-label">Notes</label>
                    <textarea class="form-control" name="notes" rows="2" placeholder="Optional notes..."></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Complete Sale</button>
            </div>
        </form>
    </div>
</div>


@section('scripts')
<script>
let itemIndex = 1;

function addItem() {
    const container = document.getElementById('itemsContainer');
    const firstRow = container.querySelector('.item-row');
    const newRow = firstRow.cloneNode(true);

    newRow.dataset.index = itemIndex;
    newRow.querySelectorAll('[name]').forEach(el => {
        el.name = el.name.replace('[0]', '[' + itemIndex + ']');
    });
    newRow.querySelector('.product-select').value = '';
    newRow.querySelector('.qty-input').value = 1;
    newRow.querySelector('.price-display').value = '';
    newRow.querySelector('.subtotal-display').value = '';
    newRow.querySelector('.btn-danger').style.display = 'block';

    container.appendChild(newRow);
    itemIndex++;
}

function removeItem(btn) {
    btn.closest('.item-row').remove();
    updateGrandTotal();
}

function updatePrice(select) {
    const row = select.closest('.item-row');
    const option = select.options[select.selectedIndex];
    const price = option.dataset.price || 0;
    const stock = option.dataset.stock || 0;
    const unit = option.dataset.unit || '';

    row.querySelector('.price-display').value = 'Rs. ' + parseFloat(price).toFixed(2);
    row.querySelector('.qty-input').max = stock;
    updateSubtotal(row.querySelector('.qty-input'));
}

function updateSubtotal(input) {
    const row = input.closest('.item-row');
    const select = row.querySelector('.product-select');
    const option = select.options[select.selectedIndex];
    const price = parseFloat(option.dataset.price) || 0;
    const qty = parseInt(input.value) || 0;
    const subtotal = price * qty;

    row.querySelector('.subtotal-display').value = 'Rs. ' + subtotal.toFixed(2);
    updateGrandTotal();
}


