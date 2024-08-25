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
    }

    public function index()
    {
        $students = $this->studentModel->findAll();
        return $this->respond($students);
    }

    /**
     * @return
     */
    public function show($id = null)
    {
        $student = $this->studentModel->find($id);
        if ($student) {
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
            return $this->response->setJSON(['errors' => $this->validator->getErrors()]);
        }

        $photo = $this->request->getFile('photo');
        $photoName = $photo->getRandomName(); // Gera um nome aleatório
        $photo->move(WRITEPATH . 'uploads', $photoName); // Salva a imagem no diretório 'writable/uploads'
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
            'photo' => $photoName
        ];

        $this->studentModel->save($data);
        return $this->respondCreated($data);
    }

    // PUT para atualizar os dados de um estudante
    public function update($id = null)
    {
        // Carregar as regras globais do arquivo de configuração
        $validationRules = config('Validation')->student;
        $validationMessages = config('Validation')->student_errors;

        // Validar a entrada de dados
        if (!$this->validate($validationRules, $validationMessages)) {
            // Retorna os erros de validação
            return $this->response->setJSON(['errors' => $this->validator->getErrors()]);
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
        ];

        // Se uma nova foto for enviada, processe o upload
        if ($this->request->getFile('photo')->isValid()) {
            $photo = $this->request->getFile('photo');
            $photoName = $photo->getRandomName(); // Gera um nome aleatório
            $photo->move(WRITEPATH . 'uploads', $photoName); // Salva a imagem no diretório 'writable/uploads'
            $data['photo'] = $photoName;
        }

        // Atualizar os dados usando o model
        $studentModel = $this->studentModel;

        // Verifica se o registro existe
        if ($studentModel->find($id)) {
            $studentModel->update($id, $data);
            return $this->respondUpdated('Sucesso em atualizar');
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
