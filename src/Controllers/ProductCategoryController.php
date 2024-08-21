<?php

namespace MiniMarkPlace\Controllers;

use MiniMarkPlace\Models\CategoryModel;
use MiniMarkPlace\Libraries\Request;
use MiniMarkPlace\Libraries\Validator;
use MiniMarkPlace\Exceptions\ValidatorException;

class ProductCategoryController
{
    public function show(Request $request)
    {
        $categoryModel = new CategoryModel();
        $categories    = $categoryModel->findAll();
        require __DIR__ . '/../views/product_category.php';
    }

    public function store(Request $request)
    {
        $validator = new Validator();

        try {
            $data = $request->allInput();
            $validator->validate($data, [
                'name' => 'required|string|min|max',
            ]);

            $categoryModel = new CategoryModel();
            $categoryModel->create($data);
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
        $validator = new Validator();

        try {
            $data = $request->allInput();
            $validator->validate($data, [
                'id'   => 'required|integer',
                'name' => 'required|string|min|max',
            ]);

            $id = $data['id'];
            $categoryModel = new CategoryModel();
            $categoryModel->update($id, ['name' => $data['name']]);
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
        $validator = new Validator();

        try {
            $data = $request->allInput();
            $validator->validate($data, [
                'id' => 'required|integer',
            ]);

            $id = $data['id'];
            $categoryModel = new CategoryModel();
            $categoryModel->delete($id);
            header("Location: /product-category");
            exit();
            
        } catch (ValidatorException $e) {
            $_SESSION['errors'] = $e->getValidationErrors();
            header("Location: /product-category");
            exit();
            
        }
    }
}
