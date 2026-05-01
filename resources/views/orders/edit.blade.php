@extends('layouts.app')

@section('content')

    @php
        $productsForJs = $products->map(function ($product) {
            return [
                'product_id' => $product->product_id,
                'name'       => $product->name,
                'unit'       => $product->unit,
                'price'      => $product->price,
            ];
        })->values();
    @endphp

    <div class="container">
        <h2>Editar Orden</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('orders.update', $order->order_id) }}" method="POST">
            @csrf
            @method('PUT')

            <h4>Datos de la orden</h4>

            <div class="mb-3">
                <label class="form-label">Número de Factura</label>
                <input type="text" name="invoice_number" class="form-control"
                    value="{{ old('invoice_number', $order->invoice_number) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Cliente</label>
                <select name="customer_id" class="form-control" required>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->customer_id }}"
                            {{ old('customer_id', $order->customer_id) == $customer->customer_id ? 'selected' : '' }}>
                            {{ $customer->customer_number }} - {{ $customer->display_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha y Hora</label>
                <input type="datetime-local" name="order_datetime" class="form-control"
                    value="{{ old('order_datetime', \Carbon\Carbon::parse($order->order_datetime)->format('Y-m-d\TH:i')) }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select name="status" class="form-control" required>
                    @foreach(['ORDERED', 'IN_PROCESS', 'IN_ROUTE', 'DELIVERED', 'DELETED'] as $status)
                        <option value="{{ $status }}"
                            {{ old('status', $order->status) == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Notas</label>
                <textarea name="notes" class="form-control">{{ old('notes', $order->notes) }}</textarea>
            </div>

            <hr>

            @if($order->deliveryAddress)
                <h4>Dirección de entrega</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Calle</label>
                        <input type="text" name="street" class="form-control"
                            value="{{ old('street', $order->deliveryAddress->street) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Número exterior</label>
                        <input type="text" name="ext_number" class="form-control"
                            value="{{ old('ext_number', $order->deliveryAddress->ext_number) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Número interior</label>
                        <input type="text" name="int_number" class="form-control"
                            value="{{ old('int_number', $order->deliveryAddress->int_number) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Colonia</label>
                        <input type="text" name="neighborhood" class="form-control"
                            value="{{ old('neighborhood', $order->deliveryAddress->neighborhood) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Ciudad</label>
                        <input type="text" name="city" class="form-control"
                            value="{{ old('city', $order->deliveryAddress->city) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Estado</label>
                        <input type="text" name="state" class="form-control"
                            value="{{ old('state', $order->deliveryAddress->state) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Código Postal</label>
                        <input type="text" name="zip" class="form-control"
                            value="{{ old('zip', $order->deliveryAddress->zip) }}">
                    </div>
                    <div class="col-md-9 mb-3">
                        <label class="form-label">Referencias</label>
                        <input type="text" name="references" class="form-control"
                            value="{{ old('references', $order->deliveryAddress->references) }}">
                    </div>
                </div>
            @endif

            <hr>

            <h4>Material del pedido</h4>

            <table class="table" id="items-table">
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>Precio Unitario</th>
                        <th>Importe</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $index => $item)
                    <tr>
                        <td>
                            <select name="items[{{ $index }}][product_id]" class="form-control product-select" required>
                                <option value="">Seleccione un material</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->product_id }}"
                                        data-unit="{{ $product->unit }}"
                                        data-price="{{ $product->price }}"
                                        {{ $item->product_id == $product->product_id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text"
                                name="items[{{ $index }}][quantity]"
                                class="form-control quantity-input"
                                value="{{ (int) $item->quantity }}"
                                required>
                        </td>
                        <td>
                            <input type="text"
                                name="items[{{ $index }}][unit]"
                                class="form-control unit-input"
                                value="{{ $item->product->unit ?? '' }}" readonly>
                        </td>
                        <td>
                            <input type="text"
                                name="items[{{ $index }}][unit_price]"
                                class="form-control price-input"
                                value="{{ number_format($item->unit_price, 2) }}" readonly>
                        </td>
                        <td>
                            <input type="text"
                                class="form-control importe-input" readonly
                                value="${{ number_format($item->quantity * $item->unit_price, 2) }}">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger" onclick="removeRow(this)">X</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                        <td colspan="2">
                            <input type="text" id="total-general" class="form-control" readonly value="$0.00">
                        </td>
                    </tr>
                </tfoot>
            </table>

            <button type="button" onclick="addRow()" class="btn btn-primary">
                Agregar material
            </button>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script>
        let rowIndex = {{ $order->items->count() }};
        const products = @json($productsForJs);

        function buildProductOptions() {
            let options = '<option value="">Seleccione un material</option>';
            products.forEach(product => {
                options += `<option value="${product.product_id}"
                    data-unit="${product.unit}"
                    data-price="${product.price}">
                    ${product.name}
                </option>`;
            });
            return options;
        }

        function addRow() {
            const tableBody = document.querySelector('#items-table tbody');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <select name="items[${rowIndex}][product_id]" class="form-control product-select" required>
                        ${buildProductOptions()}
                    </select>
                </td>
                <td>
                    <input type="text"
                        name="items[${rowIndex}][quantity]"
                        class="form-control quantity-input"
                        placeholder="0"
                        required>
                </td>
                <td>
                    <input type="text" name="items[${rowIndex}][unit]"
                        class="form-control unit-input" readonly>
                </td>
                <td>
                    <input type="text"
                        name="items[${rowIndex}][unit_price]"
                        class="form-control price-input" readonly>
                </td>
                <td>
                    <input type="text" class="form-control importe-input" readonly value="$0.00">
                </td>
                <td>
                    <button type="button" class="btn btn-danger" onclick="removeRow(this)">X</button>
                </td>
            `;
            tableBody.appendChild(row);
            rowIndex++;
            attachListeners(row);
        }

        function removeRow(button) {
            const rows = document.querySelectorAll('#items-table tbody tr');
            if (rows.length > 1) {
                button.closest('tr').remove();
                recalcularTotal();
            }
        }

        function recalcularTotal() {
            let total = 0;
            document.querySelectorAll('#items-table tbody tr').forEach(row => {
                const qty   = parseInt(row.querySelector('.quantity-input')?.value) || 0;
                const price = parseFloat(row.querySelector('.price-input')?.value) || 0;
                const importe = qty * price;
                const importeInput = row.querySelector('.importe-input');
                if (importeInput) {
                    importeInput.value = '$' + importe.toFixed(2);
                }
                total += importe;
            });
            document.getElementById('total-general').value = '$' + total.toFixed(2);
        }

        function soloEnteros(input) {
            input.addEventListener('keydown', function (e) {
                if (e.key === '.' || e.key === ',' || e.key === 'e' || e.key === 'E' || e.key === '-') {
                    e.preventDefault();
                }
            });
            input.addEventListener('paste', function (e) {
                e.preventDefault();
                const text = (e.clipboardData || window.clipboardData).getData('text');
                this.value = text.replace(/[^0-9]/g, '');
                recalcularTotal();
            });
            input.addEventListener('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '');
                recalcularTotal();
            });
        }

        function attachListeners(row) {
            const productSelect = row.querySelector('.product-select');
            const quantityInput = row.querySelector('.quantity-input');

            soloEnteros(quantityInput);

            productSelect.addEventListener('change', function () {
                const selected = this.options[this.selectedIndex];
                const unit  = selected.getAttribute('data-unit') || '';
                const price = selected.getAttribute('data-price') || '0';
                row.querySelector('.unit-input').value  = unit;
                row.querySelector('.price-input').value = parseFloat(price).toFixed(2);
                recalcularTotal();
            });

            quantityInput.addEventListener('input', recalcularTotal);
        }

        document.querySelectorAll('#items-table tbody tr').forEach(row => {
            attachListeners(row);
        });

        recalcularTotal();
    </script>

@endsection