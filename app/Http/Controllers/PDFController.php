<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artista;
use Codedge\Fpdf\Fpdf\Fpdf;

class PDFController extends Controller
{
    public function index(){
        //crear objeto pdf
        $pdf = new Fpdf();
        //Añadir página
        $pdf -> AddPage();
        //Establecer coordenadas para comenzar a pintar
        $pdf->SetXY(10,10);
        //Establecer tipo de letra, fuente, tamaño
        $pdf->SetFont('Arial', 'B', 14);
        //Establecer contenido (Una celda con un apalabra, bordes )
        $pdf->Cell(120,10,utf8_decode("Nombre artísta"), 1, 0, 'C');
        $pdf->Cell(50,10,utf8_decode("Número de álbumes"), 1, 1, 'C');
        $pdf->SetTextColor(2,100,213);

        //Recorrer arreglo artista 
        $artistas = Artista::all();
        $pdf->SetFont('Arial','I', 12);
            foreach ($artistas as $a) {
                $pdf->Cell(120,10,substr(utf8_decode($a->Name),0,50), 1, 0, 'C');
                $pdf->Cell(50,10,$a->albumes()->count(), 1, 1, 'C');
            }

        //Sacar pdf al navegador

        //Utilizar objeto responde
        $response = response($pdf->Output());
        //definir tipo mime
        $response->header("Content-Type", 'application/pdf');
        //Retornar ewapuesta del navegador
        return $response;
    }
}