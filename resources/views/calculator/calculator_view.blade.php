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

                <x-calculator-input label="Número" type="number" name="number" id="numberInput"
                    :value="$operation->number ?? 0" min="0" step='any' oninput="this.value=this.value.replace(/[^0-9.]/g,'')"/>

                <x-calculator-input label="Resultado" type="text" id="resultOutput" :value="$operation->result ?? ''"
                    :readonly="true" />

                <div class="row mb-3">
                    <x-calculator-button text="Factorial" value="factorial" position="end" />

                    <x-calculator-button text="Fibonacci" value="fibonacci" position="start" />
                </div>

                <div class="row">
                    <x-calculator-button text="Ackermann" value="ackermann" position="end" />

                    <x-calculator-button text="Limpiar" value="limpiar" position="start"/>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
