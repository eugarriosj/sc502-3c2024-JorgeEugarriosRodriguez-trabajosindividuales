<?php

$transacciones = [];

function registrarTransaccion($id, $descripcion, $monto) {
    global $transacciones;

    $transaccion = [
        "id" => $id,
        "descripcion" => $descripcion,
        "monto" => $monto
    ];

    array_push($transacciones, $transaccion);
}

function generarEstadoDeCuenta() {
    global $transacciones;

    $totalContado = 0;

    foreach ($transacciones as $transaccion) {
        $totalContado += $transaccion["monto"];
    }

    $interes = $totalContado * 0.026;
    $totalConInteres = $totalContado + $interes;

    $cashback = $totalContado * 0.001;

    $totalPagar = $totalConInteres - $cashback;

    $estadoCuenta = "";

    $estadoCuenta .= "========================================\n";
    $estadoCuenta .= "          ESTADO DE CUENTA\n";
    $estadoCuenta .= "========================================\n\n";

    $estadoCuenta .= "DETALLE DE TRANSACCIONES\n";
    $estadoCuenta .= "----------------------------------------\n";

    foreach ($transacciones as $transaccion) {
        $estadoCuenta .= "ID: " . $transaccion["id"] . "\n";
        $estadoCuenta .= "Descripcion: " . $transaccion["descripcion"] . "\n";
        $estadoCuenta .= "Monto: ₡" . number_format($transaccion["monto"], 2) . "\n";
        $estadoCuenta .= "----------------------------------------\n";
    }

    $estadoCuenta .= "\nRESUMEN DE CUENTA\n";
    $estadoCuenta .= "Total de contado: ₡" . number_format($totalContado, 2) . "\n";
    $estadoCuenta .= "Interes (2.6%): ₡" . number_format($interes, 2) . "\n";
    $estadoCuenta .= "Total con interes: ₡" . number_format($totalConInteres, 2) . "\n";
    $estadoCuenta .= "Cashback (0.1%): ₡" . number_format($cashback, 2) . "\n";
    $estadoCuenta .= "----------------------------------------\n";
    $estadoCuenta .= "TOTAL A PAGAR: ₡" . number_format($totalPagar, 2) . "\n";
    $estadoCuenta .= "========================================\n";

    file_put_contents("estado_cuenta.txt", $estadoCuenta);

    echo "<pre>";
    echo htmlspecialchars($estadoCuenta);
    echo "</pre>";
}

registrarTransaccion(1, "Compra en supermercado", 25000);
registrarTransaccion(2, "Compra de gasolina", 18000);
registrarTransaccion(3, "Compra de ropa", 35000);
registrarTransaccion(4, "Suscripcion a servicios", 8000);
registrarTransaccion(5, "Compra en restaurante", 12000);

generarEstadoDeCuenta();

?>