<?php

declare(strict_types=1);

namespace phuongaz\dailyquest\session;

class SessionManager {

    private array $sessions = [];

    public function getSession(string $name) :?Session {
        return $this->sessions[$name] ?? null;
    }

    public function addSession(Session $session) :void {
        $this->sessions[$session->getName()] = $session;
    }

    public function removeSession(string $name) :void {
        unset($this->sessions[$name]);
    }

}