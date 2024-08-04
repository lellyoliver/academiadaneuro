<?php

require_once plugin_dir_path(__FILE__) . './services/DashboardService.php';
require_once plugin_dir_path(__FILE__) . './services/UserRelatedService.php';
require_once plugin_dir_path(__FILE__) . './services/UserService.php';

class NotificationUser
{
    private $dashboardService;
    private $userRelatedService;
    private $userService;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
        $this->userRelatedService = new UserRelatedService();
        $this->userService = new UserService();

        // add_action('init', array($this, 'getLastExpiredUserRelatedNotification'));
    }
/**
 * Message 1
 */
    public function getLastUserRelatedNotification()
    {
        $notifications = array();
        $progressData = $this->dashboardService->getTotalProgress();
        $patientsList = $this->dashboardService->getListRelated();

        foreach ($patientsList as $patient) {
            if (isset($progressData[$patient->ID])) {
                $progressDate = strtotime($progressData[$patient->ID]['updateProgress']);
                $futureDate = strtotime('+3 days', $progressDate);
                $currentDate = time();
                $userName = $patient->nickname ?? 'Usuário Desconhecido';

                if ($futureDate <= $currentDate) {
                    $message = 'Converse com o(a) paciente ' . $userName . ' fazem alguns dias que ela(e) não faz as TECs.';
                    $notifications[] = $message;
                }
            }
        }

        return $notifications;
    }

    /**
     * Message 2
     */

    public function getLastExpiredUserRelatedNotification()
    {
        $expireds = $this->userRelatedService->userExpiredData();
        $notifications = array();

        if (!empty($expireds)) {
            foreach ($expireds as $expired) {
                $username = get_userdata($expired['user_id'])->nickname ?? 'Usuário Desconhecido';

                if (!$expired['status']) {
                    $message = "A assinatura de $username está vencida!";
                    $notifications[] = $message;
                }
            }
        }

        return $notifications;
    }

    /**
     * Message 3
     */
    public function getLastExpiredUserTrainingNotification()
    {
        $expireds = $this->userService->userExpiredData();
        $notifications = array();

        if (!empty($expireds)) {
            foreach ($expireds as $expired) {
                $username = get_userdata($expired['user_id'])->nickname ?? 'Usuário Desconhecido';

                if (!$expired['status']) {
                    $message = "Sua assinatura não está ativa!";
                    $notifications = $message;
                }
            }
        }

        return $notifications;
    }

    public function getEmailConfirmation()
    {
        $user_id = get_current_user_id();
        $meta_exist = get_user_meta($user_id, 'confirmation_token', true);
        if ($meta_exist) {
            return 'Seu e-mail não foi confirmado!';
        }
    }

    public function getPeriodTest()
    {
        $expireds = $this->userService->getUserExpired();

        if (!empty($expireds)) {
            foreach ($expireds as $expired) {
                if (isset($expired->product_id) && !empty($expired->product_id)) {
                    $message = 'Você está em período de teste';
                    return $message;
                }
            }
            return false;
        } else {
            return false;
        }
    }

    public function updateNotification()
    {
        $notifications = [
            'message_1' => $this->getLastUserRelatedNotification(),
            'message_2' => $this->getLastExpiredUserRelatedNotification(),
            'message_3' => $this->getLastExpiredUserTrainingNotification(),
            'message_4' => $this->getEmailConfirmation(),
            'message_5' => $this->getPeriodTest(),
        ];

        return $notifications;
    }

}

new NotificationUser;
