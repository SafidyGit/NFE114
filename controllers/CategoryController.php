<?php

require_once __DIR__ . '/../models/Category.php';

class CategoryController {

    private Category $categoryModel;

    public function __construct(Category $categoryModel)
    {
        $this->categoryModel = $categoryModel;
    }

    public function index() 
    {
        $categories = $this->categoryModel->get_all_category();

        require __DIR__ . '/../views/admin/category/index.php';
    }

    public function get_category_by_id($id)
    {
        $category = $this->categoryModel->getById($id);

        return $category;
    }

    public function create()
    {
        require __DIR__ . '/../views/admin/category/create.php';
    }

    public function store() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if($_POST['category'] == !null){
                $category = trim(htmlspecialchars($_POST['category']));
                
                $this->categoryModel->add_category($category);

                header('Location: views/admin/category/create.php?success=1');
                exit;
            } else{
                echo 'Champs obligatoire';
            }
            
        } else {
            require 'views/admin/category/create.php';
        
        }
    }

    public function edit()
    {
        $id = $_GET['id'];
        $category = $this->get_category_by_id($id);

        require __DIR__ . '/../views/admin/category/update.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_id = $_GET['id'];
            $category = trim(htmlspecialchars($_POST['category']));
           
            $this->categoryModel->update_category($category_id , $category);

            header('Location: index.php?action=category_list');
            exit;
        } else {
            require __DIR__ . '/../index.php?action=category_list';
        
        }
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_id = $_GET['id'];

            $this->categoryModel->delete_category($category_id);

            header('Location: index.php?action=category_list');
            exit;
        } else {
            require __DIR__ . '/../index.php?action=category_list';
        }
    }
    
}
