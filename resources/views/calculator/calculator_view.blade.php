<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card shadow-lg p-4" style="max-width: 700px; width: 100%; border-radius: 20px;">
        <h2 class="text-center mb-4">Calculadora</h2>
        <div class="container">
            <form action="{{ route('calculator_process') }}" method="POST" name="form">
                @csrf

                <x-input-field label="Número:" type="number" name="number" id="numberInput" placeholder="0"
                    value="{{ $operation->number ?? 0 }}" min="0" />

                <x-input-field label="Resultado:" type="text" id="resultOutput"
                    value="{{ $operation->result ?? '' }}" readonly />

                <div class="row mb-3">
                    <x-custom-button value="factorial" align="right">Factorial</x-calc-button>
                    <x-custom-button value="fibonacci" align="left">Fibonacci</x-calc-button>
                </div>

                <div class="row">
                    <x-custom-button value="ackermann" align="right">Ackermann</x-calc-button>
                    <x-custom-button value="limpiar" align="left">Limpiar</x-calc-button>
                </div>

            </form>
        </div>
    </div>
</body>

</html>