<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class StudentController extends BaseController
{
    use ResponseTrait;

    protected $studentModel;


    public function __construct()
    {
        $this->studentModel = new StudentModel();
        //remove CORS

    }

    public function index()
    {
        $perPage = $this->request->getGet('perPage') ?? 10;
        $page = $this->request->getGet('page') ?? 1;
        $students = $this->studentModel->findAll();
        //faz um paginate
        $pager = service('pager');
        //search e paginate
        $students = $this->studentModel->paginate($perPage,'default',$page);
        //retorna os dados e o paginate
        $data = [
            'students' => $students,
            'total' => $this->studentModel->countAll(),
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => $pager->getPageCount(),
        ];

        return $this->respond($data);
    }

    /**
     * @return
     */
    public function show($id = null)
    {
        $student = $this->studentModel->find($id);
        //no photo passa o caminho da imagem

        if ($student) {
            //pega foto e transforma em base64
            return $this->respond($student);
        } else {
            return $this->failNotFound('Estudante não encontrado');
        }
    }

    public function create()
    {

        // Carregar as regras globais do arquivo de configuração
        $validationRules = config('Validation')->student;
        $validationMessages = config('Validation')->student_errors;
        // Validar a entrada de dados
        if (!$this->validate($validationRules, $validationMessages)) {
            // Retorna os erros de validação
            return $this->failValidationErrors(['errors' => $this->validator->getErrors()]);
        }

        $photo = $this->request->getFile('photo');
        //transforma a foto em base64
        $base64 = base64_encode(file_get_contents($photo));
        // Se a validação passar, processe os dados
        $data = [
            'fullName' => $this->request->getPost('fullName'),
            'email' => $this->request->getPost('email'),
            'cpf' => $this->request->getPost('cpf'),
            'phone' => $this->request->getPost('phone'),
            'street' => $this->request->getPost('street'),
            'city' => $this->request->getPost('city'),
            'state' => $this->request->getPost('state'),
            'cep' => $this->request->getPost('cep'),
            'address_number' => $this->request->getPost('address_number'),
            'extra' => $this->request->getPost('extra'),
            'photo' => $base64
        ];

        $this->studentModel->save($data);
        return $this->respondCreated($data);
    }

    // PUT para atualizar os dados de um estudante
    public function update($id = null)
    {
        $student = $this->studentModel->find($id);
        if ($student) {
            // Carregar as regras globais do arquivo de configuração
            $validationRules = config('Validation')->student;
            $validationRules['cpf'] = 'required|exact_length[11]|is_unique[student.cpf,id,' . $id . ']';
            $validationRules['photo'] = 'if_exist|uploaded[photo]|max_size[photo,1024]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]';
            $validationMessages = config('Validation')->student_errors;
            // Validar a entrada de dados
            if (!$this->validate($validationRules, $validationMessages)) {
                // Retorna os erros de validação
                return $this->failValidationErrors(['errors' => $this->validator->getErrors()]);
            }
            if($this->request->getFile('photo')) {
                $photo = $this->request->getFile('photo');
                //transforma a foto em base64
                $base64 = base64_encode(file_get_contents($photo));
            }
            else{
                $base64 = $student->photo;
            }

            // Se a validação passar, processe os dados
            $data = [
                'fullName' => $this->request->getPost('fullName'),
                'email' => $this->request->getPost('email'),
                'cpf' => $this->request->getPost('cpf'),
                'phone' => $this->request->getPost('phone'),
                'street' => $this->request->getPost('street'),
                'city' => $this->request->getPost('city'),
                'state' => $this->request->getPost('state'),
                'cep' => $this->request->getPost('cep'),
                'address_number' => $this->request->getPost('address_number'),
                'extra' => $this->request->getPost('extra'),
                'photo' => $base64
            ];

            $this->studentModel->update($id, $data);
            return $this->respond($data);
        } else {
            return $this->failNotFound('Estudante não encontrado');
        }
    }

    //DELETE para excluir um estudante
    public function delete($id = null)
    {
        $student = $this->studentModel->find($id);
        if ($student) {
            $this->studentModel->delete($id);
            return $this->respondDeleted($student);
        } else {
            return $this->failNotFound('Estudante não encontrado');
        }
    }


}
