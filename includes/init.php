<?php
require_once plugin_dir_path(__FILE__) . 'controllers/AuthController.php';
require_once plugin_dir_path(__FILE__) . 'controllers/DashboardController.php';
require_once plugin_dir_path(__FILE__) . 'controllers/MyTrainingController.php';
require_once plugin_dir_path(__FILE__) . 'controllers/TrainingController.php';
require_once plugin_dir_path(__FILE__) . 'controllers/UserController.php';
require_once plugin_dir_path(__FILE__) . 'controllers/UserRelatedController.php';
require_once plugin_dir_path(__FILE__) . 'controllers/CustomerSupportController.php';



/**
 * Controllers
 */

$authController = new AuthController();
$dashboardController = new DashboardController();
$myTrainingController = new MyTrainingController();
$trainingController = new TrainingController();
$userController = new UserController();
$userRelatedController = new UserRelatedController();
$customerSupportController = new CustomerSupportController();

/**
 * Routes API
 */

add_action('rest_api_init', function () use ($authController) {
    register_rest_route('adn-plugin/v1', 'auth/email-confirmation', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($authController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $authController->processEmail($request);
        },
        'permission_callback' => '__return_true',
    ));
});

add_action('rest_api_init', function () use ($authController) {
    register_rest_route('adn-plugin/v1', 'auth/forgot-password', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($authController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $authController->processForgotPassword($request);
        },
        'permission_callback' => '__return_true',
    ));
});

add_action('rest_api_init', function () use ($userController) {
    register_rest_route('adn-plugin/v1', '/users', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($userController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $userController->create($request);
        },
        'permission_callback' => '__return_true',
    ));
});

add_action('rest_api_init', function () use ($userController) {
    register_rest_route('adn-plugin/v1', '/users/update', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($userController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $userController->update($request);
        },
        'permission_callback' => '__return_true',
    ));
});

add_action('rest_api_init', function () use ($userController) {
    register_rest_route('adn-plugin/v1', '/users/view/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => function (WP_REST_Request $request) use ($userController) {
            $id = $request->get_param('id');
            $user = $userController->getUserId($id);
            return new WP_REST_Response($user, 200);
        },
        'permission_callback' => '__return_true',
    ));
});

add_action('rest_api_init', function () use ($userController) {
    register_rest_route('adn-plugin/v1', '/users/refunded', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($userController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $userController->orderRefunded($request);
        },
        'permission_callback' => '__return_true',
    ));
});


add_action('rest_api_init', function () use ($userController) {
    register_rest_route('adn-plugin/v1', '/userNewOrder/update', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($userController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $userController->update($request);
        },
        'permission_callback' => '__return_true',
    ));
});

add_action('rest_api_init', function () use ($userRelatedController) {
    register_rest_route('adn-plugin/v1', '/users-related', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($userRelatedController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $userRelatedController->create($request);
        },
        'permission_callback' => '__return_true',
    ));
});

add_action('rest_api_init', function () use ($userRelatedController) {
    register_rest_route('adn-plugin/v1', '/users-related/update', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($userRelatedController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $userRelatedController->update($request);
        },
        'permission_callback' => '__return_true',
    ));
});

add_action('rest_api_init', function () use ($userRelatedController) {
    register_rest_route('adn-plugin/v1', '/users-related/view/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => function (WP_REST_Request $request) use ($userRelatedController) {
            $id = $request->get_param('id');
            $user = $userRelatedController->getUserId($id);
            return new WP_REST_Response($user, 200);
        },
        'permission_callback' => '__return_true',
    ));
});

add_action('rest_api_init', function () use ($userRelatedController) {
    register_rest_route('adn-plugin/v1', '/users-related/delete/userDelete=(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => function (WP_REST_Request $request) use ($userRelatedController) {
            $id = $request->get_param('id');
            $delete = $userRelatedController->delete($id);
            return new WP_REST_Response($delete, 200);
        },
        'permission_callback' => '__return_true',
    ));
});

add_action('rest_api_init', function () use ($dashboardController) {
    register_rest_route('adn-plugin/v1', '/dashboard', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($dashboardController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $dashboardController->getMetaTrainings($id);
        },
        'permission_callback' => '__return_true',
    ));
});

add_action('rest_api_init', function () use ($dashboardController) {
    register_rest_route('adn-plugin/v1', '/dashboard/replies/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => function (WP_REST_Request $request) use ($dashboardController) {
            $id = $request->get_param('id');
            $replies = $dashboardController->getReplies($id);
            return new WP_REST_Response($replies, 200);
        },
        'permission_callback' => '__return_true',
    ));
});



add_action('rest_api_init', function () use ($trainingController) {
    register_rest_route('adn-plugin/v1', '/training', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($trainingController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $trainingController->create($request);
        },
        'permission_callback' => '__return_true',
    ));
});

add_action('rest_api_init', function () use ($trainingController) {
    register_rest_route('adn-plugin/v1', '/trainingChoice', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($trainingController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $trainingController->createChoice($request);
        },
        'permission_callback' => '__return_true',
    ));
});

add_action('rest_api_init', function () use ($myTrainingController) {
    register_rest_route('adn-plugin/v1', '/myTrainingProgress', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($myTrainingController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $myTrainingController->saveTrainingProgress($request);
        },
        'permission_callback' => '__return_true',
    ));
});

add_action('rest_api_init', function () use ($myTrainingController) {
    register_rest_route('adn-plugin/v1', '/myTraining/view/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => function (WP_REST_Request $request) use ($myTrainingController) {
            $post_id = $request->get_param('id');
            $training = $myTrainingController->getMetaTrainings($post_id);
            return new WP_REST_Response($training, 200);
        },
        'permission_callback' => '__return_true',
    ));
});

add_action('rest_api_init', function () use ($customerSupportController) {
    register_rest_route('adn-plugin/v1', '/customerSupport', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) use ($customerSupportController) {
            if ($request->get_method() !== 'POST') {
                return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
            }
            return $customerSupportController->create($request);
        },
        'permission_callback' => '__return_true',
    ));
});

add_shortcode('auth-email', array($authController, 'emailShow'));
add_shortcode('auth-forgot-password', array($authController, 'forgotPasswordShow'));
add_shortcode('auth-login', array($authController, 'show'));
add_shortcode('user-perfil', array($userController, 'show'));
add_shortcode('user-create', array($userController, 'signinUserShow'));
add_shortcode('user-new-order', array($userController, 'newOrderUserShow'));
add_shortcode('user-create-related', array($userRelatedController, 'show'));
add_shortcode('user-training', array($trainingController, 'show'));
add_shortcode('user-training-choice', array($trainingController, 'choiceShow'));
add_shortcode('user-myTraining', array($myTrainingController, 'show'));
add_shortcode('dashboard', array($dashboardController, 'show'));
add_shortcode('customer-support', array($customerSupportController, 'show'));