<?php

    class Admin
    {
        public function Sprawdz() {
            ob_start();
            session_start();

            if(isset($_SESSION['zalogowany']) != "1" || isset($_SESSION['admin']) != "1") {
                return false;
            } else {
                $this->WyswietlPanel();
            }
        }

        public function WyswietlPanel() {
            echo("
                    <div class=\"container oddziel\">
                        <div class=\"row odstep\">
                            <div class=\"col-md-12\">
                                <div class=\"pracownie kafelek czerwony\">
                                    <p>Panel administatora</p>
                                </div>
                            </div>
                        </div>
                        <div class=\"row odstep\">
                            <div class=\"col-md-4\">
                                <div class=\"kafelek brazowy\">
                                    <a href=\"admin/pracownie.php\">
                                        <p>Zarządzaj pracowniami</p>
                                    </a>
                                </div>
                            </div>
                            <div class=\"col-md-4\">
                                <div class=\"kafelek czerwony\">
                                    <a href=\"admin/uzytkownicy.php\">
                                        <p>Zarządzaj użytkownikami</p>
                                    </a>
                                </div>
                            </div>
                            <div class=\"col-md-4\">
                                <div class=\"kafelek bialy\">
                                    <a href=\"admin/logi.php\">
                                        <p>Zarządzaj logami</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
            ");
        }
    }