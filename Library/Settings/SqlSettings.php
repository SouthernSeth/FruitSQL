<?php

    class FruitSqlSettings {
        // Change these values to your SQL server
        private $hostname = '127.0.0.1';
        private $username = 'root';
        private $password = '';
        private $database = 'test';

        public function Hostname() {
            return $this->hostname;
        }

        public function Username() {
            return $this->username;
        }

        public function RawPassword() {
            return $this->password;
        }

        public function DatabaseName() {
            return $this->database;
        }
    }

?>