<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Student extends ResourceController
{
    protected $modelName = 'App\Models\StudentModel';
    protected $format = 'json';
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $data = $this->model->findAll();
        if (! is_null($data)) {
            $response = [
                'status' => true,
                'message' => 'Data retrieved successfully',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => true,
                'message' => 'Failed to retrieve data',
                'data' => null
            ];
        }
        return $this->respond($response);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (! is_null($data)) {
            $response = [
                'status' => true,
                'message' => 'Data '.$id.' successfully retrieved',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => true,
                'message' => 'Failed to retrieve data',
                'data' => null
            ];
        }
        return $this->respond($response);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create() {
        $data = [
            'name' => $this->request->getPost('name'), 'email' => $this->request->getPost('email'),
            'mykad' => $this->request->getPost('mykad'), 'phone' => $this->request->getPost('phone'),
        ];
        $rules = [
            'name' => ['required'], 'email' => ['required', 'valid_email', 'is_unique[students.email]'],
            'mykad' => ['required', 'is_natural', 'exact_length[12]', 'is_unique[students.mykad]'], 'phone' => ['max_length[12]'],
        ];

        if (! $this->validateData($data, $rules)) {
            $response = [ 'status' => false, 'message' => $this->validator->getErrors(), 'data' => []];
        } else {
            $imageFile = $this->request->getFile('img');
            if (isset($imageFile) && ! is_null($imageFile)) {
                $imgRule = [
                    'img' => [
                        'label' => 'Image File',
                        'rules' => [
                            'uploaded[img]', 'is_image[img]', 'mime_in[img,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                            'max_size[img,100]', 'max_dims[img,1024,768]',
                        ]
                    ]
                ];

                if (! $this->validateData([], $imgRule)) {
                    $imgRuleStatus = false;
                } else {
                    $imageName = $imageFile->getName();
                    $tempFile = explode('.', $imageName);
                    $fileExtension = end($tempFile);

                    $newImageName = $this->request->getPost('mykad').'.'.$fileExtension;
                    if ($imageFile->isValid() && ! $imageFile->hasMoved()) {
                        $imageFile->move(WRITEPATH . 'uploads/images/', $newImageName, true);
                        $data = [
                            'name' => $data['name'], 'email' => $data['email'], 'mykad' => $data['mykad'],
                            'phone' => $data['phone'], 'img' => $newImageName,
                        ];
                    } else {
                        $response = [
                            'status' => false, 'message' => 'Failed to upload image', 'data' => []
                        ];
                    }
                }
            }

            $imgRuleStatus = $imgRuleStatus ?? true;
            if ($imgRuleStatus) {
                if ($this->model->insert($data)) {
                    $response = [
                        'status' => true, 'message' => 'Data inserted successfully', 'data' => $data
                    ];
                } else {
                    $response = [
                        'status' => false, 'message' => 'Failed to insert data', 'data' => null
                    ];
                }
            } else {
                $response = [
                    'status' => false, 'message' => $this->validator->getErrors(), 'data' => []
                ];
            }
        }

        return $this->respond($response);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $name = $this->request->getVar('name');
        // $data = json_decode(file_get_contents("php://input"));
        $updateData = [
            'name' => $name,
        ];

        if (! $this->model->update($id, $updateData)) {
            $response = [
                'status' => false,
                'message' => $this->validator->getErrors(),
                'data' => [],
            ];
        } else {
            $response = [
                'status' => true,
                'message' => 'Data updated successfully',
                'data' => []
            ];
        }

        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
