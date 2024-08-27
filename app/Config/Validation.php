<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
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
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // Regras globais de validação de estudantes
    public $student = [
        'fullName' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|max_length[100]',
        'cpf' => 'required|exact_length[11]|is_unique[student.cpf,id,{id}]',
        'phone' => 'required|min_length[10]|max_length[15]',
        'street' => 'required|max_length[255]',
        'city' => 'required|max_length[100]',
        'state' => 'required|exact_length[2]',
        'cep' => 'required|exact_length[8]',
        'address_number' => 'required|max_length[10]',
        'extra' => 'permit_empty|max_length[255]',
        'photo' => 'uploaded[photo]|max_size[photo,1024]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
    ];

    // Mensagens de erro personalizadas students
    public $student_errors = [
        'fullName' => [
            'required' => 'O campo nome completo é obrigatório.',
            'min_length' => 'O nome completo deve ter no mínimo 3 caracteres.',
            'max_length' => 'O nome completo deve ter no máximo 100 caracteres.',
        ],
        'email' => [
            'required' => 'O campo e-mail é obrigatório.',
            'valid_email' => 'O e-mail deve ser válido.',
            'max_length' => 'O e-mail deve ter no máximo 100 caracteres.',
        ],
        'cpf' => [
            'required' => 'O CPF é obrigatório.',
            'exact_length' => 'O CPF deve ter exatamente 11 dígitos.',
            'is_unique' => 'O CPF já está cadastrado.',
        ],
        'phone' => [
            'required' => 'O telefone é obrigatório.',
            'min_length' => 'O telefone deve ter no mínimo 10 dígitos.',
            'max_length' => 'O telefone deve ter no máximo 15 dígitos.',
        ],
        'photo' => [
            'uploaded' => 'A foto é obrigatória.',
            'max_size' => 'A foto não pode ter mais de 1MB.',
            'is_image' => 'O arquivo deve ser uma imagem.',
            'mime_in' => 'A imagem deve estar no formato jpg, jpeg ou png.',
        ],
        'street' => [
            'required' => 'O campo rua é obrigatório.',
            'max_length' => 'A rua deve ter no máximo 255 caracteres.',
        ],
        'city' => [
            'required' => 'O campo cidade é obrigatório.',
            'max_length' => 'A cidade deve ter no máximo 100 caracteres.',
        ],
        'state' => [
            'required' => 'O campo estado é obrigatório.',
            'exact_length' => 'O estado deve ter exatamente 2 caracteres.',
        ],
        'cep' => [
            'required' => 'O campo CEP é obrigatório.',
            'exact_length' => 'O CEP deve ter exatamente 8 dígitos.',
        ],
        'address_number' => [
            'required' => 'O número é obrigatório.',
            'max_length' => 'O número deve ter no máximo 10 caracteres.',
        ]
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
}
