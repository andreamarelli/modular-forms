<?php

return [

    'admin_page'    =>  'panel de administración',

    'add_item'          => 'añadir elemento',
    'add_entity'        => 'añadir entidad',
    'add'               => 'añadir',
    'add_all'           => 'añadir todo',
    'add_if_not_found'  => 'añadir un nuevo elemento si no se encuentra',
    'apply_filters'     => 'aplicar un filtro',
    'be_specific_as_possible' => 'Por favor, sea lo más específico posible',

    'edit'              => 'modificar',
    'save'              => 'guardar',
    'confirm_save'      => 'Alguna información ha sido modificada. ¿Desea guardar?',
    'saved_successfully' => 'guardado con éxito',
    'saved_error'       => 'error en la base de datos',
    'saving'            => 'guardando',
    'cancel_modifications' => 'cancelar las modificaciones',
    'create'            => 'crear',
    'delete'            => 'borrar',
    'confirm_deletion'  => '¿confirmar el borrado?',
    'show'              => 'mostrar',
    'reset'             => 'reiniciar',
    'close'             => 'cerrar',

    'csv'               => 'generar CSV',
    'xls'               => 'generar XLS',
    'pdf'               => 'generar PDF',
    'export'            => 'exportar',
    'import'            => 'importar',
    'confirm_select'  => 'confirmar la selección',
    'select_item'       => 'seleccione un elemento',

    'search'            => "buscar",
    'search_item'       => "buscar elemento",
    'type_at_least'     => 'Escriba al menos :num_chars para obtener la lista de resultados correspondientes',
    'initial'     => 'inicial',
    'filters'           => 'filtros',
    'filter_results'    => 'filtrar resultados',
    'record_found'      => 'artículo encontrado|artículos encontrados',
    'no_record_found'   => 'no se encontraron registros',
    'no_data_found'     => 'no se encontraron datos',
    'no_data'           => 'sin datos',
    'data_not_available'=> 'datos no disponibles',

    'page'              => 'página',
    'yes'               => 'si',
    'no'                => 'no',

    'form' => [
        'preload'               => 'Cargar datos de años anteriores',
        'previous_years'        => 'Datos de años anteriores',

        'not_available'         => 'Informacion no disponible',
        'available_years'       => 'Años disponibles',
        'available_tooltip'     => 'Marque la casilla si los datos no están disponibles',

        'applicable'            => 'Indicador no aplicable',
        'not_applicable'        => 'No aplica',
        'applicable_tooltip'    => 'Marque la casilla si este indicador no se aplica a su país',

        'error' => 'algunos datos de este formulario son incorrectos o insuficientes',

        'encoding' => 'codificacion',
        'validation' => 'validación',
        'validated_by'        => 'validar por',
        'nothing_to_validate' => 'Nada que validar',
        'already_validated' => 'Indicador ya validado.',
    ],


    'upload' => [
        'upload_file'       => 'cargar archivo',
        'upload'            => 'cargar',
        'uploaded'          => 'cargado',
        'select_file'       => 'seleccione un archivo',
        'no_file_selected'  => 'no se ha seleccionado ningún archivo',
        'error'             => 'error en la carga de datos',
        'too_big'           => 'Archivo demasiado grande. El tamaño máximo de archivo permitido es de 50Mb.',
        'not_valid_filename'=> 'El nombre del archivo no es válido. Sólo se permiten letras, dígitos, espacios y los siguientes caracteres especiales: -_. & ()',
        'not_valid_format'  => 'El formato del archivo no es válido.',
        'multiple_files_description' => 'Arrastrar y soltar para subir archivos json/zip (máximo 10)',
        'dict_default_message' => 'Arrastrar y soltar para subir archivos json/zip',
        'dict_fallback_message' => 'Su navegador no soporta la carga de archivos mediante arrastrar y soltar',
        'dict_fallback_text' => 'Por favor, utilice el formulario de reserva de abajo para subir sus archivos como en los viejos tiempos',
        'dict_file_too_big' => 'El archivo es demasiado grande ({{filesize}}MiB). Tamaño máximo de archivo: {{maxFilesize}}MiB.',
        'dict_invalid_file_type' => 'No puede subir archivos de este tipo',
        'dict_response_error' => 'El servidor ha respondido con el código {{statusCode}}',
        'dict_cancel_upload' => 'Cancela la subida',
        'dict_upload_canceled' => 'Carga cancelada',
        'dict_cancel_upload_confirmation' => '¿Seguro que quiere cancelar esta subida?',
        'dict_remove_file'  => 'Eliminar archivo',
        'dictMaxFilesExceeded' => 'Has superado el máximo de archivos para subir. Por favor, elimine los archivos para poder subir más',
        'not_all_imported'  => ' ({{filesDidNotUploaded}} de {{totalFiles}} archivos importados)',
        'no_files_found'    => 'No se han encontrado archivos válidos',
        'generic_error'     => 'Se ha producido un error, por favor, compruebe sus archivos',
        'uploading'         => '...subiendo',
        'remove_all'        => 'Eliminar todo',
        'upload_error'      => 'Error de carga: '
    ],

];
