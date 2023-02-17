<?php

return [

    'admin_page'    =>  'panneau d\'administration',

    'add_item'          => 'ajouter un élément',
    'add_entity'        => 'ajouter une entité',
    'add'               => 'ajouter',
    'add_all'           => 'ajouter tous les éléments',
    'add_if_not_found'  => 'ajouter un nouvel élément s\'il n\'est pas trouvé',
    'apply'             => 'appliquer',
    'apply_filters'     => 'appliquer les critères',
    'be_specific_as_possible' => 'S\'il vous plaît être le plus précis que possible',

    'edit'              => 'modifier',
    'save'              => 'enregistrer',
    'confirm_save'      => 'certaines informations ont été modifiées. Voulez-vous l\'enregistrer?',
    'saved_successfully'=> 'données enregistrées avec succès',
    'saved_error'       => 'erreur de la base de données',
    'saving'            => 'enregistrer la modification',
    'cancel'            => 'annuler',
    'cancel_modifications' => 'annuler les modifications',
    'confirm'           => 'confirmer',
    'create'            => 'créer',
    'delete'            => 'supprimer',
    'confirm_deletion'  => 'confirmer la suppression?',
    'show'              => 'visualiser',
    'view_all'          => 'voir tous',
    'reset'             => 'réinitialiser',
    'close'             => 'fermer',
    'go_back'           => 'retourner',
    'hide'              => 'cacher',
    'merge'             => 'combiner',
    'print'             => 'imprimer',

    'csv'               => 'générer CSV',
    'xls'               => 'générer XLS',
    'pdf'               => 'générer PDF',
    'export'            => 'exporter',
    'import'            => 'importer',
    'confirm_select'  => 'confirmer la sélection',
    'select_item'       => 'sélectionner un élément',

    'search'            => "rechercher",
    'search_item'       => "rechercher un élément",
    'type_at_least'   => 'Entrer un mot clé d\'au moins :num_chars lettres pour obtenir la liste des résultats correspondants',
    'initial'     => 'initiale',
    'filters'           => 'Critères de recherche',
    'filter_results'    => 'filtrer les résultats',
    'record_found'      => 'élément trouvé|éléments trouvés',
    'no_record_found'   => 'aucun résultat trouvé',
    'no_data_found'     => 'aucune donnée trouvée',
    'no_data'           => 'aucune donnée',
    'no_differences'    => 'aucune différence',
    'data_not_available'=> 'données non disponibles',

    'page'              => 'page',
    'yes'               => 'oui',
    'no'                => 'non',

    'form' => [
        'preload'               => 'Charger les données des années précédentes',
        'previous_years'        => 'Données des années précédentes',

        'not_available'         => 'Données non disponibles',
        'available_years'       => 'Années disponibles',
        'available_tooltip'     => 'Cochez la case si les données sont non disponibles',

        'applicable'            => 'Indicateur non applicable',
        'not_applicable'        => 'Pas applicable',
        'applicable_tooltip'    => 'Cochez la case si cet indicateur ne concerne pas votre pays',

        'global_errors' => 'ce formulaire contient des informations incorrectes ou manquantes. Ces informations sont indispensables pour que vos données soient prises en compte :',
        'error' => 'ce formulaire contient des informations incorrectes ou manquantes',

        'encoding' => 'encodage',
        'validation' => 'validation',
        'validated_by'        => 'valider par',
        'nothing_to_validate' => 'Rien à valider',
        'already_validated' => 'Indicateur déjà validé.',
    ],


    'upload' => [
        'upload_file'       => 'charger un fichier',
        'upload'            => 'charger',
        'uploaded'          => 'chargé',
        'select_file'       => 'sélectionner un fichier',
        'no_file_selected'  => 'aucun fichier sélectionné',
        'error'             => 'erreur de téléchargement',
        'too_big'           => 'Fichier trop large. La taille maximale du fichier est de __maxFileSize__MiB.',
        'not_valid_filename'=> 'Le nom de fichier n\'est pas valide; seules les lettres, les chiffres, les espaces et les caractères spéciaux suivants sont autorisés: -_. & ()',
        'not_valid_format'  => 'Le format du fichier est invalide',
        'multiple_files_description' => 'Glisser-déposer pour télécharger des fichiers json/zip (maximum 10)',
        'dict_default_message' => 'Glisser-déposer pour télécharger des fichiers json/zip',
        'dict_fallback_message' => 'Votre navigateur ne prend pas en charge le téléchargement de fichiers par l\'opération glisser-déposer.',
        'dict_fallback_text' => 'Veuillez utiliser le formulaire alternatif ci-dessous pour télécharger vos fichiers comme avant',
        'dict_file_too_big' => 'Le fichier est trop volumineux ({{filesize}}MiB). Taille maximale du fichier : {{maxFilesize}}MiB.',
        'dict_invalid_file_type' => 'Vous ne pouvez pas télécharger de fichiers de ce type.',
        'dict_response_error' => 'Le serveur a répondu avec le code {{statusCode}}.',
        'dict_cancel_upload' => 'Annuler le téléchargement',
        'dict_upload_canceled' => 'téléchargement annulé',
        'dict_cancel_upload_confirmation' => 'Êtes-vous sûr de vouloir annuler ce téléchargement ?',
        'dict_remove_file'  => 'Supprimer le fichier',
        'dictMaxFilesExceeded' => 'Vous avez dépassé le nombre maximum de fichiers pour le téléchargement. Veuillez supprimer des fichiers afin d\'en télécharger d\'autres',
        'not_all_imported'  => ' ({{filesDidNotUploaded}} de {{totalFiles}} fichiers importés)',
        'no_files_found'    => 'Aucun fichier valide n\'a été trouvé',
        'generic_error'     => 'Une erreur s\'est produite, veuillez vérifier vos fichiers',
        'uploading'         => '...téléchargement',
        'remove_all'        => 'Supprimer tout',
        'upload_error'      => 'Erreur de téléchargement : ',
    ],

];
