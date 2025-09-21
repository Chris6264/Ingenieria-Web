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

                <div class="row mb-3 align-items-center">
                    <div class="col-6 fs-4 d-flex justify-content-end">Número:</div>
                    <div class="col-6">
                        <input type="number" min="0" class="form-control fs-3 w-75" id="numberInput" 
                               placeholder="0" name="number" value="{{ $operation->number ?? '0' }}">
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <div class="col-6 fs-4 d-flex justify-content-end">Resultado:</div>
                    <div class="col-6">
                        <input type="text" class="form-control fs-3 w-75" value="{{ $operation->result ?? '' }}" 
                               id="resultOutput" readonly/>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-6 d-flex justify-content-end">
                        <button type="submit" class="btn btn-dark btn-lg w-75 py-3" 
                                name="option" value="factorial">Factorial</button>
                    </div>
                    <div class="col-6 d-flex justify-content-start">
                        <button type="submit" class="btn btn-dark btn-lg w-75 py-3" 
                                name="option" value="fibonacci">Fibonacci</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 d-flex justify-content-end">
                        <button type="submit" class="btn btn-dark btn-lg w-75 py-3" 
                                name="option" value="ackermann">Ackermann</button>
                    </div>
                    <div class="col-6 d-flex justify-content-start">
                        <button type="submit" class="btn btn-dark btn-lg w-75 py-3" 
                                name="option" value="limpiar">Limpiar</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</body>
</html>