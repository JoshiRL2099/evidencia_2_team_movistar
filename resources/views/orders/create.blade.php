@extends('layouts.app')

@section('content')

    @php
        $productsForJs = $products->map(function ($product) {
            return [
                'product_id' => $product->product_id,
                'name' => $product->name,
                'unit' => $product->unit,
            ];
        })->values();
    @endphp

    <div class="container">
        <h2>Nueva Orden</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            <h4>Datos de la orden</h4>

            <div class="mb-3">
                <label class="form-label">Número de Factura</label>
                <input type="text" name="invoice_number" class="form-control" value="{{ old('invoice_number') }}"
                    placeholder="FAC-2026-001" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Cliente</label>
                <select name="customer_id" class="form-control" required>
                    <option value="">Seleccione un cliente</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->customer_id }}" {{ old('customer_id') == $customer->customer_id ? 'selected' : '' }}>
                            {{ $customer->customer_number }} - {{ $customer->display_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha y Hora</label>
                <input type="datetime-local" name="order_datetime" class="form-control" value="{{ old('order_datetime') }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Notas</label>
                <textarea name="notes" class="form-control" rows="3"
                    placeholder="Entregar entre 6am y 6pm...">{{ old('notes') }}</textarea>
            </div>

            <hr>

            <h4>Dirección de entrega</h4>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Calle</label>
                    <input type="text" name="street" class="form-control" value="{{ old('street') }}" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Número exterior</label>
                    <input type="text" name="ext_number" class="form-control" value="{{ old('ext_number') }}" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Número interior</label>
                    <input type="text" name="int_number" class="form-control" value="{{ old('int_number') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Colonia</label>
                    <input type="text" name="neighborhood" class="form-control" value="{{ old('neighborhood') }}" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Ciudad</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Estado</label>
                    <input type="text" name="state" class="form-control" value="{{ old('state') }}" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Código Postal</label>
                    <input type="text" name="zip" class="form-control" value="{{ old('zip') }}" required>
                </div>

                <div class="col-md-9 mb-3">
                    <label class="form-label">Referencias</label>
                    <input type="text" name="references" class="form-control" value="{{ old('references') }}">
                </div>
            </div>

            <hr>

            <h4>Material del pedido</h4>

            <table class="table" id="items-table">
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>Precio Unitario</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="items[0][product_id]" class="form-control product-select" required>
                                <option value="">Seleccione un material</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->product_id }}" data-unit="{{ $product->unit }}">
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <input type="number" step="0.01" min="0.01" name="items[0][quantity]" class="form-control"
                                required>
                        </td>

                        <td>
                            <input type="text" name="items[0][unit]" class="form-control unit-input" readonly>
                        </td>

                        <td>
                            <input type="number" step="0.01" min="0" name="items[0][unit_price]" class="form-control">
                        </td>

                        <td>
                            <button type="button" class="btn btn-danger" onclick="removeRow(this)">X</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="button" onclick="addRow()" class="btn btn-primary">
                Agregar material
            </button>

            <button type="submit" class="btn btn-success">
                Guardar Orden
            </button>

            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </form>
    </div>

    <script>
        let rowIndex = 1;

        const products = @json($productsForJs);

        function buildProductOptions() {
            let options = '<option value="">Seleccione un material</option>';

            products.forEach(product => {
                options += `<option value="${product.product_id}" data-unit="${product.unit}">${product.name}</option>`;
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
                    <input type="number" step="0.01" min="0.01" name="items[${rowIndex}][quantity]" class="form-control" required>
                </td>
                <td>
                    <input type="text" name="items[${rowIndex}][unit]" class="form-control unit-input" readonly>
                </td>
                <td>
                    <input type="number" step="0.01" min="0" name="items[${rowIndex}][unit_price]" class="form-control">
                </td>
                <td>
                    <button type="button" class="btn btn-danger" onclick="removeRow(this)">X</button>
                </td>
            `;

            tableBody.appendChild(row);
            rowIndex++;
        }

        function removeRow(button) {
            const rows = document.querySelectorAll('#items-table tbody tr');
            if (rows.length > 1) {
                button.closest('tr').remove();
            }
        }

        document.addEventListener('change', function (event) {
            if (event.target.classList.contains('product-select')) {
                const selectedOption = event.target.options[event.target.selectedIndex];
                const unit = selectedOption.getAttribute('data-unit') || '';
                const row = event.target.closest('tr');
                const unitInput = row.querySelector('.unit-input');

                unitInput.value = unit;
            }
        });
    </script>

@endsection