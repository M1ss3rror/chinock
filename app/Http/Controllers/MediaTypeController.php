<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\MediaType;

use function PHPSTORM_META\type;

class MediaTypeController extends Controller
{
    public function showmass(){
    //Mostar la vista de carga masiva
    return view('media-types.insert-mass');
    }
    public function storemass(Request $r){
        //Reglas de validación (En un arreglo)
        $reglas = [
            'media-types' => 'required|mimes:csv,txt'
        ];

        //Crear validador
        $validador = Validator::make($r->all() , $reglas);

        //Validar
        if ($validador->fails()) {
                /*return "Error al subir archivo. Tipo no válido";
                return $validador->errors()->first('media-types');*/
            //Enviar mensaje de eeror de vaidación a la vista
            return redirect('media-types/insert')->withErrors($validador);
        } else {

            //Trasladar el archivo cargado al Storage
            $r->file('media-types')->storeAs('media-types', $r->file('media-types')->getClientOriginalName());

            //return "Tipo válido";
            $ruta = base_path(). '\storage\app\media-types\\'. $r->file('media-types')->getClientOriginalName();

            //Abrir archivo almacenado
            if(($puntero = fopen($ruta, 'r')) !== false){
                //$puntero recorre el archivo
                //base_path Trae la ruta del arrchivo
                //getClientOriginalName() Trae el nombre del archivo

                //Variable a contar veces que seinsertan
                $contadora = 0;

                //Recorrer cada linea del csv
                while ( ($linea = fgetcsv($puntero)) !==false){
                        //var_dump($linea);

                    //Verificar si ya está en la base de datos
                    $conteo = MediaType::where('Name', '=', $linea[0])->get()->count();//Cuantos ya están
                    //Si no hay registros en MedyaType que se llamen igual
                    if($conteo ==0){

                    //Crear objeto MediaType()
                    $m = new MediaType();

                    //Asignar el nombre del media-type
                    $m ->Name = $linea[0];

                    //grabar en sqlite el nuevo media-type
                    $m ->save();

                    //Aumentar a 1 el contadora
                    $contadora++;
                    }else { //hay registros del medyatype
                        //agregar casilla al arreglo repetidos
                        $repetidos[] = $linea[0];
                    }
                }
                //Todo: Poner mensaje de grabación de carga masiva en la vista
                //Si hubieron repetidos
                if(count($repetidos ) == 0){
                return redirect('media-types/insert')
                ->with('exito', "Carga masiva realizada, Registros ingresados: $contadora " );
                }else{
                    return redirect('media-types/insert')
                    ->with('exito', "Carga masiva realizada con las siguientes excepciones: " )
                    ->with("repetidos", $repetidos );
                }
            } 

        }
        
        
        


       /* //verificar el archivo cargado
        echo"<pre>";
        var_dump($r->file("media-types"));
        echo"<pre>";
        //Trasladar el archivo a la sección Storange
        $r->file("media-types")->storeAs("media-types", $r->file("media-types")->getClientOriginalName());
        */
    }


    /*public function storemass(Request $request){
        //Almacena el archivo en storage/app/media-types, con el nombre
        //media-types.csv
     $path = $request->file('media-types')->storeAs("media-types", "mediatypes.csv");
         //Abre el archivo para lectura, utilizando fopen.
         
     //Validación Archivo CSV 
     //($_FILES['fichero_usuario']['type'], 'photo' => 'mimes:jpeg,bmp,png')


        if (($handle = fopen(base_path() .'\storage\app\media-types\mediatypes.csv', 'r')) !== false){
        //Recorre cada fila del archivo
         while (($row = fgetcsv($handle, 1000, ',')) !== false){
        //Crea un objeto Modelo MediaType, para insertar
         $mediatype = new MediaType();
         $mediatype->Name = $row[0];
         $mediatype->save();
         }
         }else{
         echo "error";
         }
         return redirect()->route('media-types/insert');
         }*/
        
}