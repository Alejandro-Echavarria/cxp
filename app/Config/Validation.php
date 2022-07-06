<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];
    
    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------
    
    public $cedula = [
        'cedula' => [
            'rules' => 'required|is_unique[proveedores.cedula,id,{id}]|max_length[11]|min_length[11]',
            'errors' => [
                'required' => 'El campo cédula es obligatorio.',
                'is_unique' => 'Ya existe un proveedor con esta cédula, favor dígita otra.',
                'max_length' => 'Cédula invalida, excede el límite.',
                'min_length' => 'Cédula invalida, le faltan dígitos.'
            ]
        ],
        'nombre' => [
            'rules' => 'required|is_unique[proveedores.nombre,nombre,{nombre}]',
            'errors' => [
                'required' => 'El campo nombre es obligatorio.',
                'is_unique' => 'Ya existe un proveedor con este nombre.'
            ]
        ]
    ];
}
