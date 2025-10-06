<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Receta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/app.js'])
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow" style="width: 50rem;">
        <div class="card-header text-center fw-bold">
            <h2>Generar Receta</h2>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('medicine_process') }}" id="prescriptionForm" enctype="multipart/form-data">
                @csrf

                <!-- Primera fila: Farmacia y Sucursal -->
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6">
                        <label for="pharmacy" class="form-label">Farmacia</label>
                        <input type="text" class="form-control" id="pharmacy" name="pharmacy" placeholder="Escribe la farmacia" value="{{ old('pharmacy') }}">
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="branch" class="form-label">Sucursal</label>
                        <input type="text" class="form-control" id="branch" name="branch" placeholder="Escribe la sucursal" value="{{ old('branch') }}" disabled>
                    </div>
                </div>

                <!-- Segunda fila: Num Sucursal y Farmacia (ID) -->
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6">
                        <label for="branchId" class="form-label">Num Sucursal</label>
                        <input type="text" class="form-control bg-light" id="branchId" name="branchId" placeholder="Número de sucursal" readonly value="{{ old('branchId') }}">
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="branchFarmDisplay" class="form-label">Farmacia (ID)</label>
                        <input type="text" class="form-control bg-light" id="branchFarmDisplay" placeholder="ID de farmacia" readonly>
                        <input type="hidden" id="branchFarm" name="branchFarm">
                    </div>
                </div>

                <!-- Tercera fila: Medicamento, Número de Unidades, En existencia -->
                <div class="row g-3 mb-3 align-items-end">
                    <div class="col-12 col-md-4">
                        <label for="medication" class="form-label">Medicamento</label>
                        <input type="text" class="form-control" id="medication" placeholder="Escribe el medicamento" disabled>
                    </div>

                    <div class="col-12 col-md-2">
                        <label for="quantity" class="form-label">Número de Unidades</label>
                        <input type="number" class="form-control" id="quantity" placeholder="0" value="0"  disabled>
                    </div>

                    <div class="col-12 col-md-2">
                        <label for="inStock" class="form-label">En existencia</label>
                        <input type="text" class="form-control bg-light" id="inStock" value="0" readonly>
                    </div>

                    <div class="col-12 col-md-4 d-flex justify-content-center">
                        <button type="button" class="btn btn-success" id="btnAgregar" disabled>Agregar</button>
                    </div>
                </div>

                <!-- Botón Agregar (ya está en la fila anterior) -->

                <!-- Sección Descripción de la Receta como tabla -->
                <div class="card bg-light border-secondary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Descripción de la Receta</h5>
                        <table class="table table-bordered table-hover">
                            <thead class="table-secondary">
                                <tr>
                                    <th>#</th>
                                    <th>Medicamento</th>
                                    <th>Unidades</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="prescriptionDescription">
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No hay medicamentos agregados</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Campo oculto para contar medicamentos -->
                <input type="hidden" name="medications_count" id="medications_count" value="0">

                <!-- Botón Generar -->
                <button type="submit" class="btn btn-primary w-100 mt-3" id="btnGenerar" disabled>Generar</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
</body>
</html>