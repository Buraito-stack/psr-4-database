<?php

namespace MiniMarkPlace\Controllers;

use MiniMarkPlace\Models\CategoryModel;
use MiniMarkPlace\Libraries\Request;
use MiniMarkPlace\Exceptions\ValidatorException;

class ProductCategoryController
{
    protected $categoryModel;
    protected $request;

    public function __construct()
    {
        $this->categoryModel = (new CategoryModel);
        $this->request       = (new Request); 
    }

    public function show()
    {
        $categories = $this->categoryModel->findAll();
        require __DIR__ . '/../views/product_category.php'; 
    }

    public function store()
    {
        try {
            $data = $this->request->allInput();
            $this->request->validate($data, ['name' => 'required|string|min|max']);

            $this->categoryModel->create($data);
            header("Location: /product-category"); 
            exit();
        } catch (ValidatorException $e) {
            $_SESSION['errors'] = $e->formatErrors();
            header("Location: /product-category"); 
            exit();
        }
    }

    public function update()
    {
        try {
            $data = $this->request->allInput();
            $this->request->validate($data, ['id' => 'required|integer', 'name' => 'required|string|min|max']);

            $id = $data['id'];
            $this->categoryModel->update($id, ['name' => $data['name']]);
            header("Location: /product-category"); 
            exit();
        } catch (ValidatorException $e) {
            $_SESSION['errors'] = $e->formatErrors();
            header("Location: /product-category"); 
            exit();
        }
    }

    public function delete()
    {
        try {
            $data = $this->request->allInput();
            $this->request->validate($data, ['id' => 'required|integer']);

            $id = $data['id'];
            $this->categoryModel->delete($id);
            header("Location: /product-category"); 
            exit();
        } catch (ValidatorException $e) {
            $_SESSION['errors'] = $e->formatErrors();
            header("Location: /product-category"); 
            exit();
        }
    }

}
?>
