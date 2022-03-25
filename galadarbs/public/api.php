<?php
define('PRIVATE_DIR', __DIR__ . '/../private/');
include PRIVATE_DIR . 'bootstrap.php';

use Database\Subscribers;
use Database\BlogPosts;
header('Content-type: application/json');

$output = ['status' => false];

if (isset($_GET['name']) && is_string($_GET['name'])) {
    switch ($_GET['name']) {
        case 'getBlogPosts':
            $blog_manager = new BlogPosts();
            $output['blog_posts'] = $blog_manager->getAll();
            $output['status'] = true;
            break;
        case 'getSubscribers':
            $output['status'] = true;
            $subscribers = new Subscribers();
            $output['subscribers'] = $subscribers->getAll();
            break;
        case 'getSingleSubscriber':
            if (isset($_GET['id']) && is_string($_GET['id'])) {
                $id = (int) $_GET['id'];
                $output['status'] = true;
                $subscribers = new Subscribers();
                $output['entity'] = $subscribers->get($id);
            }
echo 'tet';
            break;
            case 'subscribe':
                if (
                    isset($_POST['name']) && is_string($_POST['name']) &&
                    isset($_POST['email']) && is_string($_POST['email'])&&
                    isset($_POST['telephone']) && is_string($_POST['telephone'])&&
                    isset($_POST['subject']) && is_string($_POST['subject'])&&
                    isset($_POST['message']) && is_string($_POST['message'])
                ) {
                    $subscribers = new Subscribers();
    
                    $entity = [
                        'name' => $_POST['name'],
                        'email' => $_POST['email'],
                        'telephone' => $_POST['telephone'],
                        'subject' => $_POST['subject'],
                        'message' => $_POST['message']
                    ];
    
                    $entity = $subscribers->addEntity($entity);
                    if (is_array($entity)) {
                        $output['status'] = true;
                        $output['entity'] = $entity;
                        $output['message'] = 'New Entry added!';
                    }
                    else {
                        $output['message'] = 'There is an error!';
                        if (DEBUG_MODE) {
                            $output['message'] .= ' ' . $subscribers->getError();
                        }
                    }
                }
    
                break; 
        case 'update_subscribe':
            if (
                isset($_POST['id']) && is_string($_POST['id']) &&
                isset($_POST['name']) && is_string($_POST['name']) &&
                isset($_POST['email']) && is_string($_POST['email'])
            ) {
                
                $subscribers = new Subscribers();
                $entity = [
                    'id' => (int) $_POST['id'],
                    'name' => $_POST['name'],
                    'email' => $_POST['email']
                ];
                $output['status'] = $subscribers->updateEntity($entity);
            }
            break;
        case 'delete':
            if (
                isset($_POST['id']) && is_string($_POST['id'])
            ) {
                $id = (int) $_POST['id'];
                $subscribers = new Subscribers();
                if ($subscribers->delete($id)) {
                    $output['status'] = true;
                    $output['message'] = "element $id deleted";
                }
                else {
                    $output['message'] = "Deletion failed";
                }
            }
            break;
    }
}

echo json_encode($output, JSON_PRETTY_PRINT);