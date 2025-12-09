<?php
/*
Este archivo web.php es el archivo de rutas de un proyecto Laravel, y define todas las rutas que el proyecto puede manejar, así como los controladores y métodos asociados para manejar esas rutas. 
*/

## Uso de los Facades
/**Illuminate\Support\Facades\Route: Laravel ofrece facades, que son clases que proporcionan una interfaz estática a las clases subyacentes del sistema de Laravel. Route es el facade específico que se encarga de gestionar todas las rutas de la aplicación. Este Route se utiliza para definir las rutas HTTP (GET, POST, PUT, DELETE, etc.) que controlan cómo las solicitudes son dirigidas dentro de la aplicación. */
use Illuminate\Support\Facades\Route;

## Importación de Controladores
use App\Http\Controllers\{
    MuestrasController,
    Encuesta20Controller,
    Enc16ActController,
    Encuesta22Controller,
    CorreosController,
    TelefonosController,
    OpcionesController,
    ReactivosController,
    RecadosController,
    EncuestasController,
    LlamadasController,
    HomeController,
    ReportController,
    FastPollController,
    ConfigController,
    EmpresasController,
    PosgradoController,
    UserController
};

Route::get('/', function () {
    return redirect(route('login'));
});
Auth::routes();
Route::get('/hashing/{arg}', [App\Http\Controllers\Auth\RegisterController::class, 'hashea'])->name('hashea');

## Grupo de rutas con middleware auth
/*Este grupo de rutas solo es accesible para usuarios autenticados.
*/
Route::group(['middleware' => ['auth']], function(){

    /**Función: Estas rutas generan automáticamente las rutas CRUD
     * (Create, Read, Update, Delete) para manejar las acciones 
     * relacionadas con muestras, reactivos, opciones, encuestas y correos. */
    Route::resource('muestras', MuestrasController::class);
    Route::resource('reactivos', ReactivosController::class);
    Route::resource('options', OpcionesController::class);
    Route::resource('encuestas', EncuestasController::class);
    Route::resource('correos', CorreosController::class);

    /**Rutas relacionadas con encuestas 
     * Manejo de encuestas de los años 2014 y 2020: Estas rutas manejan el listado de muestras del año 2014 y 2020. 
    */
    Route::controller(MuestrasController::class)->group(function(){
        
        Route::get('muestras20/index/{id}','index_20')->name('muestras20.index');
        Route::get('muestras22/index/{id}','index_22')->name('muestras22.index');
      
        Route::get('muestras20/show/{carrera}/{plantel}','show_20')->name('muestras20.show');
        Route::get('muestras22/show/{carrera}/{plantel}','show_22')->name('muestras22.show22');//SHOW DEL 22


        Route::get('muestras{gen}/index/{id}', 'index_general')->name('muestras.index_general');//GENERAL PARA LAS ENCUESTAS DE SEGUIMIENTO 2020, ACTUALIZACIÓN 2016 Y SEGUIMIENTO 2022
        Route::get('muestras{gen}/planteles/','plantel_index')->name('muestras.plantel_index');//GENERAL PARA LAS ENCUESTAS DE SEGUIMIENTO 2020, ACTUALIZACIÓN 2016 Y SEGUIMIENTO 2022
        //Route::get('muestras{gen}/indexgeneral/{id}', 'index_general')->name('muestras.index_general');//GENERAL PARA LAS ENCUESTAS DE SEGUIMIENTO 2020, ACTUALIZACIÓN 2016 Y SEGUIMIENTO 2022
        
        //encuesta de act 2016
        Route::get('muestras16/show/{carrera}/{plantel}','show_16')->name('muestras16.show');
        
        Route::get('muestras16/index/{id}','index_16')->name('muestras16.index');

        Route::get('revisiones','revisiones_index')->name('revisiones.index');//prueba
        Route::get('revision','revision')->name('muestras.seg20.revision');
        
        //encuesta de act 16
        Route::get('revision16','revision16')->name('muestras.act16.revision');

        //encuesta de seguimiento 2022
        Route::get('revision22', 'revision22')->name('muestras.seg20.revision22');

        //completar encuesta
        Route::get('completar_encuesta/{id}','completar_encuesta')->name('completar_encuesta');


        //encuesta de posgrado
        Route::get('muestra_posgrado/programas/','programas_index')->name('posgrado.programas_index');

        Route::get('showmuestra_posgrado/{programa}','index_posgrado')->name('muestrasposgrado.index');


        Route::get('muestra_posgrado/show/{programa}/{plan}','show_posgrado')->name('muestrasposgrado.show');

        
        //encuetsa de seguimiento 2022
        Route::get('muestras22/planteles/','plantel_index')->name('muestras22.plantel_index');
        //Route::get('muestras22/index/{id}','index_20')->name('muestras22.index');


    });

   /**Actualización 2016:
     * Estas rutas permiten actualizar los datos de las encuestas 
     */
    Route::controller(Enc16ActController::class)->group(function(){

        Route::get('/comenzar_encuesta_2016/{correo}/{cuenta}/{carrera}', 'comenzar')->name('comenzar_encuesta_2016');
        Route::get('/encuestas_2016/edit/{id}', 'edit')->name('edit_16');
        Route::post('/encuestas/2016/update/{id}', 'update')->name('encuesta16.update');
        Route::get('/encuestas/2016/guardar_inconclusa/{id}', 'guardar_incompleta')->name('incomplete');
    });
    /**Actualización de encuestas:
     * Estas rutas permiten actualizar los datos de las encuestas 
     */
    Route::controller(Encuesta20Controller::class)->group(function(){
        Route::post('/encuestas/2020/real_update/{id}', 'update2')->name('encuestas.real_update');
        Route::post('/encuestas/2020/A_update/{id}', 'updateA')->name('encuestas.real_update.A');
        Route::post('/encuestas/2020/C_update/{id}', 'updateC')->name('encuestas.real_update.C');
        Route::post('/encuestas/2020/D_update/{id}', 'updateD')->name('encuestas.real_update.D');
        Route::post('/encuestas/2020/E_update/{id}', 'updateE')->name('encuestas.real_update.E');
        Route::post('/encuestas/2020/F_update/{id}', 'updateF')->name('encuestas.real_update.F');
        Route::post('/encuestas/2020/G_update/{id}', 'updateG')->name('encuestas.real_update.G');
        Route::get('/encuestas/2020/terminar/{id}', 'terminar')->name('terminar');
        Route::get('/comenzar_encuesta_2020/{correo}/{cuenta}/{carrera}', 'comenzar')->name('comenzar_encuesta_2020');
        Route::get('/encuestas_2020/edit/{id}/{section}', 'edit')->name('edit_20');
        Route::post('/encuestas/real_update/{id}', 'update2')->name('encuestas.real_update');
        Route::get('/2020', 'encuesta_2020')->name('2020');
        Route::get('/encuestas_2020/render/{id}/{section}', 'render')->name('render_20');
    });


    //Rutas para el controlador de la encuesta 22
    Route::controller(Encuesta22Controller::class)->group(function(){
        Route::get('/comenzar_encuesta_2022/{correo}/{cuenta}/{carrera}', 'comenzar')->name('comenzar_encuesta_2022');
        Route::get('/encuestas_22/edit/{id}/{section}', 'edit_22')->name('edit_22');
        Route::post('/encuestas/2022/update/{id}/{section}', 'update')->name('encuesta22.update');
         Route::get('/encuestas/2022/terminar/{id}', 'terminar22')->name('terminar22');

    });
    
    /** Telefonos */
    Route::controller(TelefonosController::class)->group(function(){
        Route::get('/agregar_telefono/{cuenta}/{carrera}/{encuesta?}/{telefono_id?}', 'create')->name('agregar_telefono');
        Route::get('/editar_telefono/{id}/{carrera}/{encuesta?}/{telefono_id?}', 'edit')->name('editar_telefono');
        Route::post('/guardar_telefono/{cuenta}/{carrera}/{encuesta?}/{telefono_id?}', 'store')->name('guardar_telefono');
        Route::post('/actualizar_telefono/{id}/{carrera}/{encuesta?}/{telefono_id?}', 'update')->name('actualizar_telefono');
    });

    /**Encuestas */ //Qué tipo de encuestas? 2014/2019?
        Route::controller(EncuestasController::class)->group(function(){
        Route::get('/encuestas/2014/show/{id}', 'show_14')->name('encuestas.show_14');
        Route::get('/encuestas/json/{id}', 'json')->name('encuestas.json');
        Route::get('/enc2019_make', 'index')->name('encuestas.make19');
        Route::get('/encuestas/verify/{id}', 'verificar')->name('encuestas.verificar');
        Route::post('/encuestas/2014/real_update/{id}', 'update14')->name('encuestas14.real_update');
    });
    
    /** Recados */
    Route::controller(RecadosController::class)->group(function(){
        Route::get('recados', 'index')->name('recados.index');
        Route::delete('recados/delete/{id}', 'destroy')->name('recados.destroy');
        Route::delete('recados/posgrado/delete/{id}', 'destroyP')->name('recados.destroyP');
        Route::get('/encuestas/2014/recados/{id}', 'recado_14')->name('encuestas.recado_14');
        Route::post('/encuestas/2014/marcar/{id}', 'marcar_14')->name('marcar_14');
        Route::post('/encuestas/2020/marcar/{telid}/{egid}', 'marcar_20')->name('marcar_20');
        Route::post('/encuestaPosgrado/marcar/{telid}/{egid}', 'marcar_posgrado')->name('marcar_posgrado');
    });

    /**Correos */
    Route::controller(CorreosController::class)->group(function(){
        Route::get('/agregar_correo/{cuenta}/{carrera}/{encuesta?}/{telefono_id?}', 'create')->name('agregar_correo');
        Route::get('/editar_correo/{id}/{carrera}/{encuesta?}/{telefono_id?}', 'edit')->name('editar_correo');
        Route::post('/guardar_correo/{cuenta}/{carrera}/{encuesta?}/{telefono_id?}', 'store')->name('guardar_correo');
        Route::post('/actualizar_correo/{id}/{carrera}/{encuesta?}/{telefono_id?}',  'update')->name('actualizar_correo');
        Route::get('direct_send/{id}',  'direct_send')->name('direct_send');
    });
    
    /** Pantalla de inicio */
    Route::controller(HomeController::class)->group(function(){
        Route::get('/stats', 'stats')->name('stats');
        Route::get('/links', 'links')->name('links');
        Route::get('/home', 'index')->name('home');
        Route::get('/2014_act', '2014_act')->name('2014_act');
        Route::get('/2019', 'encuesta_2019')->name('2019');
        /**Avisos */
        Route::get('/links', 'links')->name('links');
        Route::get('/home', 'index')->name('home');
        Route::get('/2014_act', '2014_act')->name('2014_act');
        Route::get('/2019', 'encuesta_2019')->name('2019');
        Route::get('/buscar', 'buscar')->name('buscar');
        Route::post('/resultado', 'resultado')->name('resultado');
        Route::post('/resultado_fonetico', 'resultado_fonetico')->name('resultado_fonetico');
        /**Avisos */
        Route::get('/aviso', 'aviso')->name('aviso');
        Route::post('/enviar_aviso', 'enviar_aviso')->name('enviar_aviso');
        /**Invitaciones */
        Route::get('/invitacion', 'invitacion')->name('invitacion');
        Route::get('/invitacion14/{registro}', 'invitacion')->name('invitacion14');
        Route::get('/invitacion19/{id}', 'invitacion19')->name('invitacion19');
        Route::post('/enviar_invitacion', 'enviar_invitacion')->name('enviar_invitacion');
        Route::get('/enviar_encuesta/{id_correo}/{id_egresado}/{telefono}', 'enviar_encuesta')->name('enviar_encuesta');
    });
//comentario
    /**Reportes */
    Route::controller(ReportController::class)->group(function(){
        Route::get('/reporte/{report}', 'generate')->name('report');
        Route::get('/reporte/semanal/{semana}/{user?}', 'semanal')->name('reporte.semanal');
    });

    Route::resource('empresas', EmpresasController::class);
    Route::get('/search_empresa', [EmpresasController::class, 'search'])->name('search_empresa'); //Deberiamos separar esta ruta de la clase de Encuestas20
    Route::post('/modal_store_empresa', [EmpresasController::class, 'modal_store'])->name('empresas.modal_store'); //Deberiamos separar esta ruta de la clase de Encuestas20
    
    //Rutas para encuesta fast
    Route::controller(FastPollController::class)->group(function(){
        Route::get('/fast_show/{registro}/{reactivo}/{type}','show')->name('fast.show');
        Route::get('/fast_begin','begin')->name('fast.begin');
        Route::get('/fast/find_next/{registro}/{type}','find_next')->name('fast.find');
        Route::post('/fast_check_cuenta','check_cuenta')->name('fast.check');
        Route::post('/fast_check_store/{registro}/{reactivo}/{type}','store')->name('fast.store');
    });
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Estos se pudieran cambiar para que utilizen el método __invoke que es utilizado cuando el controlador tiene un único método//
    
    /**Dark Mode */
    Route::get('/switch', [ConfigController::class, 'switch_mode'])->name('switch_mode');

    /** Reactivos, Opciones y Llamadas */
    Route::post('/reactivos_update/{id}', [ReactivosController::class, 'update'])->name('reactivos.update_re');
    Route::post('/opciones_update/{id}', [OpcionesController::class, 'update'])->name('options.update_re');
    Route::get('/encuestas/llamar/{gen}/{id}/{carrera}', [LlamadasController::class, 'llamar'])->name('llamar');
    Route::get('/encuestas/llamar_posgrado/{id}/{plan}/{programa}', [LlamadasController::class, 'llamar_egresadosPosgrado'])->name('llamar_posgrado');
    Route::get('/actualizar/{cuenta}/{carrera}/{gen}/{telefono_id?}', [LlamadasController::class, 'act_data'])->name('act_data'); //Deberiamos separar esta ruta de la clase de Encuestas20
    Route::get('/actualizar_posgrado/{cuenta}/{programa}/{plan}/{telefono_id?}', [LlamadasController::class, 'act_data_posgrado'])->name('act_data_posgrado'); 

    Route::controller(UserController::class)->group(function(){
        Route::get('/users/give/{id}/{permission}', 'give_permission')->name('users.give');
        Route::get('/users/revoke/{id}/{permission}', 'revoke_permission')->name('users.revoke');
    });
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Rutas para la encuesta de posgrado
    Route::controller(PosgradoController::class)->group(function(){
       Route::get('/encuesta_posgrado/{section}/{id}', 'show')->name('posgrado.show');
       Route::post('/update_posgrado/{section}/{id}', 'update')->name('posgrado.update');
       Route::get('posgrado_completar_encuesta/{id}','completar_encuesta')->name('completar_encuesta_posgrado');
        Route::get('encuesta_posgrado/terminar/{id}', 'terminar')->name('terminar');
        Route::get('encuesta_posgrado/{correo}/{cuenta}/{programa}', 'comenzar')->name('comenzar_encuesta_posgrado');
    });
    

});