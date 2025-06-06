<?php

require_once __DIR__ . '/../models/Category.php';

class CategoryController {
    public function index() 
    {
        $categoryModel = new Category();
        $categories = $categoryModel->get_all_category();

        return $categories;
    }

    public function get_category_by_id($id)
    {
        $categoryModel = new Category();
        $category = $categoryModel->getById($id);

        return $category;
    }

    public function create() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category = trim(htmlspecialchars($_POST['category']));
           
            $categoryModel = new Category();
            $categoryModel->add_category($category);

            header('Location: views/admin/category/create.php?success=1');
            exit;
        } else {
            require 'views/admin/category/create.php';
        
        }
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_id = $_GET['id'];
            $category = trim(htmlspecialchars($_POST['category']));
           
            $categoryModel = new Category();
            $categoryModel->update_category($category_id , $category);

            header('Location: views/admin/category/index.php');
            // header('Location: views/admin/category/update.php?success=1');
            exit;
        } else {
            require 'views/admin/category/update.php';
        
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_id = $_GET['id'];

            $categoryModel = new Category();
            $categoryModel->delete_category($category_id);

            header('Location: views/admin/category/index.php');
            exit;
        } else {
            require 'views/admin/category/index.php';
        }
    }

    
}
