@extends('layouts.app')
@section('title', 'Editar Venta')

@section('content')
<div class="container">
    <h1>Editar Venta</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ventas.update', $venta->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-select" required>
                <option value="">Seleccione un cliente</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->cedula }}" {{ $venta->cliente_id == $usuario->cedula ? 'selected' : '' }}>
                        {{ $usuario->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha_venta" class="form-label">Fecha</label>
            <input type="date" name="fecha_venta" id="fecha_venta" class="form-control" value="{{ $venta->fecha_venta }}" required>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" id="estado" class="form-select" required>
                <option value="PENDIENTE" {{ $venta->estado == 'PENDIENTE' ? 'selected' : '' }}>Pendiente</option>
                <option value="REALIZADA" {{ $venta->estado == 'REALIZADA' ? 'selected' : '' }}>Realizada</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="descuento" class="form-label">Descuento</label>
            <input type="number" step="0.01" name="descuento" id="descuento" class="form-control" value="{{ $venta->descuento }}">
        </div>

        <h4>Productos</h4>
        <table class="table" id="productos-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Valor Unitario</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venta->detalles as $i => $detalle)
                    <tr>
                        <td>
                            <select name="productos[{{ $i }}][producto_id]" class="form-select producto" required>
                                <option value="">Seleccione</option>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}"
                                        {{ $detalle->producto_id == $producto->id ? 'selected' : '' }}>
                                        {{ $producto->nombre_producto }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="productos[{{ $i }}][cantidad]" class="form-control cantidad" min="1" value="{{ $detalle->cantidad }}" required>
                        </td>
                        <td>
                            <input type="number" name="productos[{{ $i }}][valor_unitario]" class="form-control valor_unitario" step="0.01" value="{{ $detalle->valor_unitario }}" readonly>
                        </td>
                        <td>
                            <input type="number" name="productos[{{ $i }}][subtotal]" class="form-control subtotal" step="0.01" value="{{ $detalle->subtotal }}" readonly>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm eliminar">X</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="button" class="btn btn-success mb-3" id="add-producto">+ Agregar Producto</button>

        <div class="mb-3">
            <label for="total" class="form-label">Total</label>
            <input type="number" step="0.01" name="total" id="total" class="form-control" value="{{ $venta->total }}" required readonly>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Venta</button>
        <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

<script>
document.addEventListener("DOMContentLoaded", function () {
    let productosData = @json($productos->keyBy('id'));
    let tableBody = document.querySelector("#productos-table tbody");
    let addBtn = document.getElementById("add-producto");
    let totalInput = document.getElementById("total");
    let descuentoInput = document.getElementById("descuento");
    let rowIndex = tableBody.querySelectorAll("tr").length;

    addBtn.addEventListener("click", function () {
        let row = document.createElement("tr");
        row.innerHTML = `
            <td>
                <select name="productos[${rowIndex}][producto_id]" class="form-select producto" required>
                    <option value="">Seleccione</option>
                    @foreach ($productos as $producto)
                        <option value="{{ $producto->id }}">{{ $producto->nombre_producto }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="productos[${rowIndex}][cantidad]" class="form-control cantidad" min="1" value="1" required>
            </td>
            <td>
                <input type="number" name="productos[${rowIndex}][valor_unitario]" class="form-control valor_unitario" step="0.01" value="0" readonly>
            </td>
            <td>
                <input type="number" name="productos[${rowIndex}][subtotal]" class="form-control subtotal" step="0.01" value="0" readonly>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm eliminar">X</button>
            </td>
        `;
        tableBody.appendChild(row);
        rowIndex++;
        actualizarEventos();
    });

    function actualizarEventos() {
        document.querySelectorAll(".producto").forEach(select => {
            select.onchange = function () {
                let productoId = this.value;
                let row = this.closest("tr");
                let precio = productosData[productoId]?.valor_unitario || 0;
                row.querySelector(".valor_unitario").value = precio;
                calcularSubtotal(row);
                calcularTotal();
            };
        });
        document.querySelectorAll(".cantidad").forEach(input => {
            input.oninput = function () {
                let row = this.closest("tr");
                let productoId = row.querySelector('.producto').value;
                let cantidadSolicitada = parseInt(this.value) || 0;
                let inventarioDisponible = productosData[productoId]?.inventario ?? Infinity;
                // Sumar la cantidad ya registrada en la venta para ese producto
                let cantidadAnterior = 0;
                @foreach ($venta->detalles as $detalle)
                if ({{ $detalle->producto_id }} == productoId) {
                    cantidadAnterior = {{ $detalle->cantidad }};
                }
                @endforeach
                let maxPermitido = inventarioDisponible + cantidadAnterior;
                if (cantidadSolicitada > maxPermitido) {
                    mostrarAlerta('La cantidad solicitada supera el inventario disponible.');
                    this.value = maxPermitido;
                }
                calcularSubtotal(row);
                calcularTotal();
            };
        });
        document.querySelectorAll(".eliminar").forEach(btn => {
            btn.onclick = function () {
                this.closest("tr").remove();
                calcularTotal();
            };
        });
        if(descuentoInput) descuentoInput.oninput = calcularTotal;
    }

    function mostrarAlerta(mensaje) {
        let alerta = document.createElement('div');
        alerta.className = 'alert alert-warning alert-dismissible fade show';
        alerta.role = 'alert';
        alerta.innerHTML = mensaje + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        document.querySelector('.container').prepend(alerta);
        setTimeout(() => { alerta.remove(); }, 4000);
    }

    function calcularSubtotal(row) {
        let cantidad = parseFloat(row.querySelector(".cantidad").value) || 0;
        let precio = parseFloat(row.querySelector(".valor_unitario").value) || 0;
        let subtotal = cantidad * precio;
        row.querySelector(".subtotal").value = subtotal.toFixed(2);
    }

    function calcularTotal() {
        let total = 0;
        document.querySelectorAll(".subtotal").forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        let descuento = parseFloat(descuentoInput?.value) || 0;
        totalInput.value = (total - descuento).toFixed(2);
    }

    actualizarEventos();
});
</script>