<?php
namespace MiniMarkPlace\Controllers;

use MiniMarkPlace\Models\CategoryModel;
use MiniMarkPlace\Libraries\Request;
use MiniMarkPlace\Libraries\Validator;
use MiniMarkPlace\Exceptions\ValidatorException;

class ProductCategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function show(Request $request)
    {
        $categories = $this->categoryModel->findAll();
        require __DIR__ . '/../views/product_category.php';
    }

    public function store(Request $request)
    {
        try {
            $data = $request->allInput();
            Validator::validate($data, [
                'name' => 'required|string|min:3|max:25',
            ]);

            $this->categoryModel->create($data);
            header("Location: /product-category");
            exit();
            
        } catch (ValidatorException $e) {
            $_SESSION['errors'] = $e->getValidationErrors();
            header("Location: /product-category");
            exit();
        }
    }

    public function update(Request $request)
    {
        try {
            $data = $request->allInput();
            Validator::validate($data, [
                'id'   => 'required|integer',
                'name' => 'required|string|min:3|max:25',
            ]);

            $id = $data['id'];
            $this->categoryModel->update($id, ['name' => $data['name']]);
            header("Location: /product-category");
            exit();

        } catch (ValidatorException $e) {
            $_SESSION['errors'] = $e->getValidationErrors();
            header("Location: /product-category");
            exit();
        }
    }

    public function delete(Request $request)
    {
        try {
            $data = $request->allInput();
            Validator::validate($data, [
                'id' => 'required|integer',
            ]);

            $id = $data['id'];
            $this->categoryModel->delete($id);
            header("Location: /product-category");
            exit();

        } catch (ValidatorException $e) {
            $_SESSION['errors'] = $e->getValidationErrors();
            header("Location: /product-category");
            exit();
        }
    }
}

