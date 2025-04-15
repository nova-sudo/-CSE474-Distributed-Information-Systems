<?php
header('Content-Type: application/json');
require_once '../models/User.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$userModel = new User();

switch ($method) {
    case 'GET':
        echo json_encode($userModel->getAllUsers());
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['name'], $data['email'], $data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            $result = $userModel->createUser($data);
            echo json_encode(['success' => $result]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
        }
        break;
    case 'PUT':
        preg_match('/\/api\/users\/(\d+)/', $uri, $matches);
        if (isset($matches[1])) {
            $id = $matches[1];
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['name'], $data['email'])) {
                $result = $userModel->updateUser($id, $data);
                echo json_encode(['success' => $result]);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid input']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid ID']);
        }
        break;
    case 'DELETE':
        preg_match('/\/api\/users\/(\d+)/', $uri, $matches);
        if (isset($matches[1])) {
            $id = $matches[1];
            $result = $userModel->deleteUser($id);
            echo json_encode(['success' => $result]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid ID']);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
}