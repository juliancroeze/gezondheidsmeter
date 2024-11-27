<?php
require_once './models/User.php';
require_once './services/OnboardingService.php';
require_once './services/RegistrationService.php';

class AuthController extends Controller {
    private $userModel;
    private $onboardingService;
    private $registrationService;

    public function __construct() {
        $this->userModel = new User();
        $this->onboardingService = new OnboardingService($this->userModel);
        $this->registrationService = new RegistrationService($this->userModel);
    }

    public function showLoginForm() {
        $this->view('auth/login');
    }

    public function showRegisterForm() {
        $this->view('auth/register');
    }

    public function resetAccount() {
    $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        try {
            $userId = $_SESSION['user_id'];
            $this->userModel->resetAccount($userId);
            
            // Reset relevant session variables
            $_SESSION['on_boarding'] = 0;
            
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Er is een fout opgetreden bij het resetten van je account']);
        }
    }

    public function showDashboard() {
        $this->requireAuth();
        
        $userData = $this->userModel->getUserData($_SESSION['user_id']);
        if (!$userData) {
            header('Location: /login');
            exit();
        }
        
        if ($userData['is_admin'] === "1") {
            $this->view('admin_dashboard', ['userData' => $userData]);
        } else {
            $this->view('dashboard', ['userData' => $userData]);
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->view('auth/login');
        }
    
        $result = $this->userModel->login($_POST['email'], $_POST['password']);
        if (!$result) {
            return $this->view('auth/login', [
                'error' => 'Email of wachtwoord is onjuist',
                'old' => ['email' => $_POST['email']]
            ]);
        }
    
        $this->createUserSession($result);
        header('Location: /dashboard');
        exit();
    }

    private function createUserSession($user) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['full_name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['is_admin'];
        $_SESSION['on_boarding'] = $user['onboarding_complete'];
    }


    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->view('auth/register');
        }
    
        try {
            $this->registrationService->register($_POST);
            header('Location: /login');
            exit();
        } catch (Exception $e) {
            return $this->view('auth/register', [
                'error' => $e->getMessage(),
                'old' => $_POST // Preserve form data
            ]);
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /login');
        exit();
    }

    public function showOnboarding() {
        $this->requireAuth();
        $this->view('onboarding');
    }

    public function submitOnboarding() {
        $this->requireAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->onboardingService->processOnboarding($_SESSION['user_id'], $_POST);
            header('Location: /dashboard');
            exit();
        }
    }


    private function requireAuth() {
        session_start();
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
    }
}