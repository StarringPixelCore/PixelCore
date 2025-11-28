<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;
use App\Validation\UserRules;

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
        UserRules::class,
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

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public array $login = [
        'id_number' => [
            'label' => 'ID Number',
            'rules' => 'required|id_number_exists',
            'errors' => [
                'required' => 'Please enter your ID number.',
                'id_number_exists' => 'The ID number you entered is not connected to an account.'
            ]
        ],

        'password' => [
            'label' => 'Password',
            'rules' => 'required|valid_password[id_number]',
            'errors' => [
                'required' => 'Please enter your password.',
                'valid_password' => 'Your password is incorrect.'
            ]
        ]
    ];

    public array $signup = [
        'id_number' => [
            'label' => 'ID Number',
            'rules' => 'required|min_length[3]|max_length[50]|is_unique[tblusers.id_number]',
            'errors' => [
                'required' => 'Please enter an ID number.',
                'min_length' => 'ID number must be at least 8 characters long.',
                'max_length' => 'ID number must not exceed 50 characters.',
                'is_unique' => 'This ID number is already registered. Please use a different one.'
            ]
        ],
        
        'firstname' => [
            'label' => 'First Name',
            'rules' => 'required|min_length[2]|max_length[100]|regex_match[/^[A-Z][a-zA-Z.\'\- ]*$/]',
            'errors' => [
                'required' => 'Please enter your first name.',
                'min_length' => 'Your first name must be at least 2 characters long.',
                'max_length' => 'Your first name must not exceed 100 characters.',
                'regex_match' => 'First name must start with a capital letter and can only contain letters, spaces, periods, dashes, and apostrophes.'
            ]
        ],

        'lastname' => [
            'label' => 'Last Name',
            'rules' => 'required|min_length[2]|max_length[100]|regex_match[/^[A-Z][a-zA-Z.\'\- ]*$/]',
            'errors' => [
                'required' => 'Please enter your last name.',
                'min_length' => 'Your last name must be at least 2 characters long.',
                'max_length' => 'Your last name must not exceed 100 characters.',
                'regex_match' => 'Last name must start with a capital letter and can only contain letters, spaces, periods, dashes, and apostrophes.'
            ]
        ],

        'email' => [
            'label' => 'Email',
            'rules' => 'required|valid_email|is_unique[tblusers.email]',
            'errors' => [
                'required' => 'Please enter your email address.',
                'valid_email' => 'Please enter a valid email address.',
                'is_unique' => 'This email address is already registered. Please use a different one.'
            ]
        ],

        'password' => [
            'label' => 'Password',
            'rules' => 'required|min_length[8]|max_length[50]',
            'errors' => [
                'required'   => 'Please enter a password.',
                'min_length' => 'Your password must be at least 8 characters long.',
                'max_length' => 'Your password must not exceed 50 characters.'
            ]
        ],

        'confirmpassword' => [
            'label' => 'Confirm Password',
            'rules' => 'required|matches[password]',
            'errors' => [
                'required' => 'Please confirm your password.',
                'matches' => 'Your passwords do not match. Please try again.'
            ]
        ],

        'role' => [
            'label' => 'Role',
            'rules' => 'required|in_list[USER,ITSO PERSONNEL,STUDENT,ASSOCIATE]',
            'errors' => [
                'required' => 'Please select a role.',
                'in_list' => 'Please select a valid role.'
            ]
        ]
    ];

    public array $editAccount = [
        'id_number' => [
            'label' => 'ID Number',
            'rules' => 'required|min_length[3]|max_length[50]',
            'errors' => [
                'required' => 'Please enter your ID number.',
                'min_length' => 'Your ID number must be at least 8 characters long.',
                'max_length' => 'Your ID number must not exceed 50 characters.'
            ]
        ],
        
        'firstname' => [
            'label' => 'First Name',
            'rules' => 'required|min_length[2]|max_length[100]|regex_match[/^[A-Z][a-zA-Z.\'\- ]*$/]',
            'errors' => [
                'required' => 'Please enter your first name.',
                'min_length' => 'Your first name must be at least 2 characters long.',
                'max_length' => 'Your first name must not exceed 100 characters.',
                'regex_match' => 'First name must start with a capital letter and can only contain letters, spaces, periods, dashes, and apostrophes.'
            ]
        ],

        'lastname' => [
            'label' => 'Last Name',
            'rules' => 'required|min_length[2]|max_length[100]|regex_match[/^[A-Z][a-zA-Z.\'\- ]*$/]',
            'errors' => [
                'required' => 'Please enter your last name.',
                'min_length' => 'Your last name must be at least 2 characters long.',
                'max_length' => 'Your last name must not exceed 100 characters.',
                'regex_match' => 'Last name must start with a capital letter and can only contain letters, spaces, periods, dashes, and apostrophes.'
            ]
        ],

        'email' => [
            'label' => 'Email',
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'Please enter your email address.',
                'valid_email' => 'Please enter a valid email address.'
            ]
        ],

        'password' => [
            'label' => 'Password',
            'rules' => 'permit_empty|min_length[8]|max_length[50]',
            'errors' => [
                'min_length' => 'Your password must be at least 8 characters long.',
                'max_length' => 'Your password must not exceed 50 characters.'
            ]
        ],

        'confirmpassword' => [
            'label' => 'Confirm Password',
            'rules' => 'permit_empty|matches[password]',
            'errors' => [
                'matches' => 'Your passwords do not match. Please check again.'
            ]
        ],

        'role' => [
            'label' => 'Role',
            'rules' => 'required|in_list[USER,ITSO PERSONNEL,STUDENT,ASSOCIATE]',
            'errors' => [
                'required' => 'Please select a role.',
                'in_list' => 'Please select a valid role.'
            ]
        ]
    ];

    public array $resetPassword = [
        'password' => [
            'label' => 'Password',
            'rules' => 'required|min_length[8]|max_length[50]',
            'errors' => [
                'required' => 'Please enter a new password.',
                'min_length' => 'Your password must be at least 8 characters long.',
                'max_length' => 'Your password must not exceed 50 characters.'
            ]
        ],

        'confirmpassword' => [
            'label' => 'Confirm Password',
            'rules' => 'required|matches[password]',
            'errors' => [
                'required' => 'Please confirm your password.',
                'matches' => 'Your passwords do not match. Please try again.'
            ]
        ]
    ];

    public array $equipment = [
        'equipment_name' => [
            'label' => 'Equipment Name',
            'rules' => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required' => 'Please enter the equipment name.',
                'min_length' => 'Equipment name must be at least 3 characters long.',
                'max_length' => 'Equipment name must not exceed 255 characters.'
            ]
        ],

        'category' => [
            'label' => 'Category',
            'rules' => 'required|in_list[Laptop,DLP,Cable,Remote Control,Keyboard/Mouse,Drawing Tablet,Speaker Set,Webcam,Extension Cord,Crimping Tool,Cable Tester,Lab Room Key,Other]',
            'errors' => [
                'required' => 'Please select a category.',
                'in_list' => 'Please select a valid category.'
            ]
        ],

        'quantity' => [
            'label' => 'Quantity',
            'rules' => 'required|integer|greater_than[0]',
            'errors' => [
                'required' => 'Please enter the quantity.',
                'integer' => 'Quantity must be a whole number.',
                'greater_than' => 'Quantity must be greater than 0.'
            ]
        ]
    ];

    public array $equipmentEdit = [
        'equipment_name' => [
            'label' => 'Equipment Name',
            'rules' => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required' => 'Please enter the equipment name.',
                'min_length' => 'Equipment name must be at least 3 characters long.',
                'max_length' => 'Equipment name must not exceed 255 characters.'
            ]
        ],

        'category' => [
            'label' => 'Category',
            'rules' => 'required|in_list[Laptop,DLP,Cable,Remote Control,Keyboard/Mouse,Drawing Tablet,Speaker Set,Webcam,Extension Cord,Crimping Tool,Cable Tester,Lab Room Key,Other]',
            'errors' => [
                'required' => 'Please select a category.',
                'in_list' => 'Please select a valid category.'
            ]
        ],

        'quantity' => [
            'label' => 'Quantity',
            'rules' => 'required|integer|greater_than[0]',
            'errors' => [
                'required' => 'Please enter the quantity.',
                'integer' => 'Quantity must be a whole number.',
                'greater_than' => 'Quantity must be greater than 0.'
            ]
        ],

        'available_count' => [
            'label' => 'Available Count',
            'rules' => 'required|integer|greater_than_equal_to[0]',
            'errors' => [
                'required' => 'Please enter the available count.',
                'integer' => 'Available count must be a whole number.',
                'greater_than_equal_to' => 'Available count must be 0 or greater.'
            ]
        ]
    ];
}