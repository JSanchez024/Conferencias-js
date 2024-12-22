<?php

namespace Controllers;

use MVC\Router;
use Model\Ponente;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController {

    public static function index(Router $router){
        $router->render('admin/ponentes/index',[
            'titulo' => 'Ponentes / Conferencistas'
        ]);
    }
    public static function crear(Router $router){
        $alertas = [];
        $ponente = new Ponente;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //leer imagen
            if(!empty($_FILES['imagen']['tmp_name'])){
                
                $carpeta_imagenes = '../public/img/speakers';

                //Crear la carpeta si no existe
                if(!is_dir($carpeta_imagenes)){
                    mkdir($carpeta_imagenes, 0777, true);
                }

                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);

                $nombre_imagen = md5(uniqid( rand(), true));

                $_POST['imagen'] = $nombre_imagen;

            }

            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
        
            $ponente->sincronizar($_POST);
            debuguear($ponente);
            
            //debuguear(json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES));
            //validar
            $alertas = $ponente->validar();

            //Guardar el registro
            if(empty($alertas)){
                //Guardar las imagenes
                $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");

                //Guardar en la BD
                $resultado = $ponente->guardar();

                if($resultado){
                    header('location: /admin/ponentes');
                }
            }
        }


        $router->render('admin/ponentes/crear',[
            'titulo' => 'Registrar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente
        ]);
    }
}