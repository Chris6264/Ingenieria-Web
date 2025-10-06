<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Receta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <h2 class="mb-4 text-center">Receta</h2>

        @if(isset($error))
            <div class="alert alert-danger text-center">
                <strong>Error:</strong> {{ $error }}
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('medicine_home') }}" class="btn btn-primary">
                    Volver al formulario
                </a>
            </div>

        @elseif(isset($prescription))
            <div class="card shadow p-4">
                <h4 class="mb-3">Detalles de la receta:</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID receta</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $prescription->getIdPrescription() }}</td>
                            <td>{{ $prescription->getDescription() }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-4">
                    <h5>Información adicional:</h5>
                    <ul>
                        <li><strong>Farmacia:</strong> {{ $pharmacyName ?? 'N/A' }}</li>
                        <li><strong>Sucursal:</strong> {{ $branchName ?? 'N/A' }}</li>
                        <li><strong>ID Sucursal:</strong> {{ $branchId ?? 'N/A' }}</li>
                        <li><strong>Farm:</strong> {{ $branchFarm ?? 'N/A' }}</li>
                    </ul>
                </div>

                <div class="mt-4">
                    <h5>Medicamentos procesados:</h5>
                    @if(!empty($medications))
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($medications as $med)
                                    <tr>
                                        <td>{{ $med['name'] }}</td>
                                        <td>{{ $med['units'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No se registraron medicamentos.</p>
                    @endif
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('medicine_home') }}" class="btn btn-primary">
                        Volver al formulario
                    </a>
                </div>
            </div>

        @else
            <div class="alert alert-warning text-center">
                No se pudo procesar la receta. Intentelo nuevamente.
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('medicine_home') }}" class="btn btn-primary">
                    Volver al formulario
                </a>
            </div>
        @endif
    </div>

</body>
</html>
