@extends('layouts.app')
@section('title', 'Crear Venta')

@section('content')
<h1 class="h4 mb-3">Crear Venta</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('ventas.store') }}" method="post">
    @csrf
    <div class="mb-3">
        <label for="cliente" class="form-label">Cliente: </label>
        <select name="cliente" id="cliente" class="form-select" required>
            <option value="" disabled selected>Seleccione un cliente</option>
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->cedula }}" {{ old('cliente') == $usuario->cedula ? 'selected' : '' }}>
                    {{ $usuario->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="fecha" class="form-label">Fecha: </label>
        <input type="date" class="form-control" id="fecha" name="fecha_venta" value="{{ old('fecha_venta') }}" required>
    </div>

    <div class="mb-3">
        <label for="estado" class="form-label">Estado: </label>
        <select name="estado" id="estado" class="form-select" required>
            <option value="" disabled selected>Seleccione un estado</option>
            <option value="PENDIENTE" {{ old('estado') == 'PENDIENTE' ? 'selected' : '' }}>Pendiente</option>
            <option value="REALIZADA" {{ old('estado') == 'REALIZADA' ? 'selected' : '' }}>Realizada</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="descuento" class="form-label">Descuento: </label>
        <input type="number" step="0.01" class="form-control" id="descuento" name="descuento" value="{{ old('descuento', 0) }}">
    </div>

    <h4>Productos</h4>
    <table class="table" id="productos-table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Valor Unitario</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
    @if(old('productos'))
        @foreach(old('productos') as $i => $prod)
            <tr>
                <td>
                    <select name="productos[{{ $i }}][producto_id]" class="form-select producto" required>
                        <option value="" disabled>Seleccione</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}"
                                {{ ($prod['producto_id'] ?? null) == $producto->id ? 'selected' : '' }}>
                                {{ $producto->nombre_producto }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="productos[{{ $i }}][cantidad]"
                        class="form-control cantidad"
                        min="1"
                        value="{{ $prod['cantidad'] ?? 1 }}" required>
                </td>
                <td>
                    <input type="number" name="productos[{{ $i }}][valor_unitario]"
                        class="form-control valor_unitario"
                        step="0.01"
                        value="{{ $prod['valor_unitario'] ?? '' }}" readonly>
                </td>
                <td>
                    <input type="number" name="productos[{{ $i }}][subtotal]"
                        class="form-control subtotal"
                        value="{{ $prod['subtotal'] ?? '' }}" readonly>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm eliminar">X</button>
                </td>
            </tr>
        @endforeach
    @endif
</tbody>
    </table>
    <button type="button" class="btn btn-success" id="add-producto">+ Agregar Producto</button>

    <div class="mb-3 mt-3">
        <label for="total" class="form-label">Total: </label>
        <input type="number" step="0.01" class="form-control" id="total" name="total" readonly>
    </div>

    <button type="submit" class="btn btn-primary">Crear Venta</button>
    <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection

<script>
document.addEventListener("DOMContentLoaded", function () {
    let tableBody = document.querySelector("#productos-table tbody");
    let addBtn = document.getElementById("add-producto");
    let totalInput = document.getElementById("total");
    let descuentoInput = document.getElementById("descuento");
    let productos = @json($productos->mapWithKeys(fn($p) => [$p->id => $p->valor_unitario]));
    let rowIndex = tableBody.querySelectorAll("tr").length;

    addBtn.addEventListener("click", function () {
        let row = document.createElement("tr");
        row.innerHTML = `
            <td>
                <select name="productos[${rowIndex}][producto_id]" class="form-select producto" required>
                    <option value="" disabled selected>Seleccione</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}">{{ $producto->nombre_producto }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="productos[${rowIndex}][cantidad]" class="form-control cantidad" min="1" value="1" required></td>
            <td><input type="number" name="productos[${rowIndex}][valor_unitario]" class="form-control valor_unitario" step="0.01" readonly></td>
            <td><input type="number" name="productos[${rowIndex}][subtotal]" class="form-control subtotal" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm eliminar">X</button></td>
        `;
        tableBody.appendChild(row);
        rowIndex++;
        actualizarEventos();
    });

    function actualizarEventos() {
        document.querySelectorAll(".producto").forEach(select => {
            select.onchange = function () {
                let productoId = this.value;
                let precio = productos[productoId]?.valor_unitario || productos[productoId] || 0;
                let row = this.closest("tr");
                row.querySelector(".valor_unitario").value = precio;
                calcularTotales();
            };
        });
        document.querySelectorAll(".cantidad").forEach(input => {
            input.oninput = function () {
                let row = this.closest("tr");
                let productoId = row.querySelector('.producto').value;
                let cantidadSolicitada = parseInt(this.value) || 0;
                let inventarioDisponible = productos[productoId]?.inventario ?? Infinity;
                if (cantidadSolicitada > inventarioDisponible) {
                    mostrarAlerta('La cantidad solicitada supera el inventario disponible.');
                    this.value = inventarioDisponible;
                }
                calcularTotales();
            };
        });
        document.querySelectorAll(".eliminar").forEach(btn => {
            btn.onclick = function () {
                this.closest("tr").remove();
                calcularTotales();
            };
        });
        if(descuentoInput) descuentoInput.oninput = calcularTotales;
    }

    function mostrarAlerta(mensaje) {
        let alerta = document.createElement('div');
        alerta.className = 'alert alert-warning alert-dismissible fade show';
        alerta.role = 'alert';
        alerta.innerHTML = mensaje + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        document.querySelector('form').prepend(alerta);
        setTimeout(() => { alerta.remove(); }, 4000);
    }

    function calcularTotales() {
        let total = 0;
        document.querySelectorAll("#productos-table tbody tr").forEach(row => {
            let cantidad = parseFloat(row.querySelector(".cantidad").value) || 0;
            let precio = parseFloat(row.querySelector(".valor_unitario").value) || 0;
            let subtotal = cantidad * precio;
            row.querySelector(".subtotal").value = subtotal.toFixed(2);
            total += subtotal;
        });
        let descuento = parseFloat(descuentoInput?.value) || 0;
        totalInput.value = (total - descuento).toFixed(2);
    }

    actualizarEventos();
});
</script>