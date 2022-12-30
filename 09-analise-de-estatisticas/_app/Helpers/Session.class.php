<?php

/**
 * Description of Session
 * Responsible for statistics, sessions and system traffic updates.
 * 
 * @author Klethônio Ferreira
 */
class Session
{
    private $date;
    private $cache;
    private $traffic;
    private $browser;

    public function __construct($cache = 20) {
        session_start();
        $this->date = date('Y-m-d');
        $this->cache = ((int) $cache) ?? 20;
        $this->checkSession();
    }

    //Checks and executes all methods of the class.
    private function checkSession(): void
    {
        $this->getTraffic();
        // $_SESSION['user']['online_endview'] = date('Y-m-d H:i:s', strtotime("-{$this->cache}minutes"));
        $endView = $_SESSION['user']['online_endview'] ?? date('Y-m-d H:i:s');
        // Service::debug($endView);

        if (empty($_SESSION['user']) || $endView < date('Y-m-d H:i:s')) {
            session_regenerate_id();
            $this->setTraffic();
            $this->setSession();
            $this->setBrowser();
            $this->setUser();
            $this->updateBrowser();
        } else {
            $this->updateTraffic();
            $this->updateSession();
            $this->setBrowser();
            $this->updateUser();
        }
    }

    //Get data from table
    private function getTraffic(): void
    {
        $readSiteViews = new Read;
        $readSiteViews->exeRead('ws_siteviews', 'WHERE siteviews_date = :date', ['date' => $this->date]);
        $this->traffic = $readSiteViews->first();
    }

    //Verifies and inserts the traffic in the table
    private function setTraffic(): void
    {
        if (!$this->traffic) {
            $arrSiteViews = ['siteviews_date' => $this->date, 'siteviews_users' => 1, 'siteviews_views' => 1, 'siteviews_pages' => 1];
            $creadSiteViews = new Create;
            $creadSiteViews->exeCreate('ws_siteviews', $arrSiteViews);
        } else {
            if (!$this->setCookie()) {
                $arrSiteViews = ['siteviews_users' => $this->traffic['siteviews_users'] + 1, 'siteviews_views' => $this->traffic['siteviews_views'] + 1, 'siteviews_pages' => $this->traffic['siteviews_pages'] + 1];
            } else {
                $arrSiteViews = ['siteviews_views' => $this->traffic['siteviews_views'] + 1, 'siteviews_pages' => $this->traffic['siteviews_pages'] + 1];
            }

            $updateSiteViews = new Update;
            $updateSiteViews->exeUpdate('ws_siteviews', $arrSiteViews, 'WHERE siteviews_date = :date', ['date' => $this->date]);
        }
        $this->traffic = null;
    }

    //Checks and updates pageviews
    private function updateTraffic(): void
    {
        $arrSiteViews = ['siteviews_pages' => $this->traffic['siteviews_pages'] + 1];
        $updateSiteViews = new Update;
        $updateSiteViews->exeUpdate('ws_siteviews', $arrSiteViews, 'WHERE siteviews_date = :date', ['date' => $this->date]);
        $this->traffic = null;
    }

    //Checks, creates and updates the user's cookie
    private function setCookie(): bool
    {
        $cookie = filter_input(INPUT_COOKIE, 'user', FILTER_DEFAULT);
        setcookie("user", base64_encode('wsphp'), time() + 86400);

        return $cookie ? true : false;
    }

    //Starts user session
    private function setSession(): void
    {
        $_SESSION['user'] = [
            'online_session' => session_id(),
            'online_startview' => date('Y-m-d H:i:s'),
            'online_endview' => date('Y-m-d H:i:s', strtotime("+{$this->cache}minutes")),
            'online_ip' => filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP),
            'online_url' => filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT),
            'online_agent' => filter_input(INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_DEFAULT)
        ];
    }

    //Updates user session
    private function updateSession(): void
    {
        $_SESSION['user']['online_endview'] = date('Y-m-d H:i:s', strtotime("+{$this->cache}minutes"));
        $_SESSION['user']['online_url'] = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT);
    }

    //Identifies browser
    private function setBrowser(): void
    {
        $this->browser = $_SESSION['user']['online_agent'];

        if (strpos($this->browser, 'Chrome')) {
            $this->browser = 'Chrome';
        } elseif (strpos($this->browser, 'Firefox')) {
            $this->browser = 'Firefox';
        } elseif (strpos($this->browser, 'Edg')) {
            $this->browser = 'Edge';
        } else {
            $this->browser = 'Other';
        }
    }

    //Updates table with data from browsers
    private function updateBrowser(): void
    {
        $readAgent = new Read;
        $readAgent->exeRead('ws_siteviews_agent', 'WHERE agent_name = :agent', ['agent' => $this->browser]);

        if (!$readAgent->getResult()) {
            $arrAgent = ['agent_name' => $this->browser, 'agent_views' => 1];
            $createAgent = new Create;
            $createAgent->exeCreate('ws_siteviews_agent', $arrAgent);
        } else {
            $arrAgent = ['agent_views' => $readAgent->first()['agent_views'] + 1];
            $updateAgent = new Update;
            $updateAgent->exeUpdate('ws_siteviews_agent', $arrAgent, 'WHERE agent_name = :agent', ['agent' => $this->browser]);
        }
    }

    //Registers user online in the table
    private function setUser(): void
    {
        $arrOnline = $_SESSION['user'];
        $arrOnline['agent_name'] = $this->browser;
        $createUser = new Create;
        $createUser->exeCreate('ws_siteviews_online', $arrOnline);
    }

    //Updates online user navigation
    private function updateUser(): void
    {
        $arrOnline = ['online_endview' => $_SESSION['user']['online_endview'], 'online_url' => $_SESSION['user']['online_url']];
        $updateUser = new Update;
        $updateUser->exeUpdate('ws_siteviews_online', $arrOnline, 'WHERE online_session = :session', ['session' => $_SESSION['user']['online_session']]);

        if (!$updateUser->count()) {
            $readSession = new Read;
            $readSession->exeRead('ws_siteviews_online', 'WHERE online_session = :session', ['session' => $_SESSION['user']['online_session']]);

            if (!$readSession->getResult()) {
                $this->setUser();
            }
        }
    }

}
