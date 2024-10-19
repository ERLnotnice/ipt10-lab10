<?php 

namespace App\Controllers;

use App\Models\User;

class RegistrationController extends BaseController
{
    public function showRegisterForm() {
        return $this->render('registration-form');
    }

    public function register() {

        $errors = [];
    
        try {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $first_name = $_POST['first_name'] ?? '';
            $last_name = $_POST['last_name'] ?? '';
            $password = $_POST['password'] ?? '';
            $password_confirmation = $_POST['confirm_password'] ?? '';
    
            if (empty($username) || empty($email) || empty($password) || empty($password_confirmation)) {
                $errors[] = "All required fields must be filled out.";
            }
    

            if (strlen($password) < 8) {
                $errors[] = "Password must be at least 8 characters long.";
            }

            if (!preg_match('/[0-9]/', $password)) {
                $errors[] = "Password must contain at least one numeric character.";
            }
 
            if (!preg_match('/[a-zA-Z]/', $password)) {
                $errors[] = "Password must contain at least one non-numeric character.";
            }

            if (!preg_match('/[\W]/', $password)) {
                $errors[] = "Password must contain at least one special character (!@#$%^&*-+).";
            }

            if ($password !== $password_confirmation) {
                $errors[] = "Passwords do not match.";
            }
    

            if (!empty($errors)) {

                $data = [
                    'errors' => $errors, 
                    'username' => $username,
                    'email' => $email,
                    'first_name' => $first_name,
                    'last_name' => $last_name
                ];
    
                return $this->render('registration-form', $data);
            }
    
            $user = new User();
            $save_result = $user->save($username, $email, $first_name, $last_name, $password);
    
            if ($save_result > 0) {
                return $this->render('success'); 
            } else {
                echo "There was an error during registration. Please try again.";
            }
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
