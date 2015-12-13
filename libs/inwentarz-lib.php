<?php
    class Inwentarz {
        public function logowanie()
        {
            ob_start();
            session_start();
            require('dbconnect.php');

            if(isset($_SESSION['zalogowany']) == "1") {
                header("Location: panel.php");
            }
            if (isset($_POST['zaloguj'])) {
                $login = $_POST['login'];
                $haslo = $_POST['haslo'];

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $query = $baza->prepare('SELECT * FROM `uzytkownicy` WHERE login=:login LIMIT 1');
                    $query->bindParam(':login', $login);
                    $query->execute();

                    $hash = $query->fetch()['haslo'];

                    $haslo = password_verify($haslo, $hash);
                    $user_id = $query->fetch();

                    if($haslo != TRUE) {
                        echo '<div class="containera">
                                <section class="notif notif-alert">
                                    <h6 class="notif-title">Błąd logowania!</h6>
                                    <p>Wystąpił błąd podczas logowania do inwentarza! Sprawdź poprawność swojego loginu i hasła!</p>
                                </section>
                            </div>';
                    } else {
                        $_SESSION['uzytkownik_id'] = $user_id['id'];
                        $_SESSION['zalogowany'] = true;
                        $id = $user_id['id'];
                        $query = $baza->prepare('UPDATE `Inwentarz`.`uzytkownicy` SET `last_logged` = NOW() WHERE `uzytkownicy`.`id`=:id');
                        $query->bindParam(':id', $id);
                        $query->execute();
                        header("refresh:3; url=panel.php");
                        echo '<div class="containera">
                                <section class="notif notif-notice">
                                    <h6 class="notif-title">Zalogowano!</h6>
                                    <p>Zalogowano pomyślnie! W ciagu <span id="sekundy"></span> sekund zostaniesz przeniesiony do inwentarza!</p>
                                </section>
                            </div>';
                    }
                }
            }
        }


        public function nazwaSzkoly() {
            require('dbconnect.php');

            $nazwa = $baza->query('SELECT * FROM `ustawienia`');
            foreach ($nazwa as $szkola) {
                echo $szkola['nazwa-szkoly'];
            }
        }

        public function wersjaAplikacji() {
            require('dbconnect.php');

            $wersja = $baza->query('SELECT * FROM `ustawienia`');
            foreach ($wersja as $apka) {
                echo $apka['wersja-apki'];
            }
        }

        public function dataAktualizacji() {
            require('dbconnect.php');

            $aktualizacja = $baza->query('SELECT * FROM `ustawienia`');
            foreach ($aktualizacja as $data) {
                echo $data['data-aktualizacji'];
            }
        }

        public function rolaUsera() {
            require('dbconnect.php');
            $inwentarz = new Inwentarz();

            $rola = $inwentarz->daneZalogowanego();

            if($rola['admin'] == 1) {
                $_SESSION['admin'] = 1;
                echo 'Administrator';
            } else {
                echo 'Użytkownik';
            }
        }

        public function admin_inwentarza() {
            $id_admina_inwentarza = 0;

            require('dbconnect.php');
            $admin_prowadzacy = "SELECT * FROM `ustawienia`";
            $admin = $polaczenie->query($admin_prowadzacy);
            while($id_admina = $admin->fetch_assoc()) {
                $id_admina_inwentarza = $id_admina['uzytkownik_admin'];
            }

            $nazwa_admina = $this->daneZalogowanego($id_admina_inwentarza);
                echo $nazwa_admina['imie'].' '.$nazwa_admina['nazwisko'];
            $polaczenie->close();
        }

        public function wyloguj() {
            if($_GET['id'] == 'wyloguj')
            {
                session_start();
                require('dbconnect.php');
                $id_uzytkownika = $_SESSION['uzytkownik_id'];
                $update_logowania = "UPDATE uzytkownicy SET `pre_last_logged`= `last_logged` WHERE `id` = '$id_uzytkownika'";
                $wykonaj = mysqli_query($polaczenie, $update_logowania);


                unset($_SESSION['zalogowany']);
                unset($_SESSION['uzytkownik_id']);

                session_destroy();
                header("Location: http://".$_SERVER['HTTP_HOST']."".dirname($_SERVER['PHP_SELF'])."/index.php");
            }
        }


        public function daneZalogowanego($user_id = -1) {
            require('dbconnect.php');

            if($user_id == -1) {
                $user_id = $_SESSION['uzytkownik_id'];
            }

            $query = $baza->prepare('SELECT * FROM `uzytkownicy` WHERE `id`=:id LIMIT 1');
            $query->bindParam(':id', $user_id, PDO::PARAM_INT);
            return $query->execute();
        }

        public function changelog() {
            require('dbconnect.php');
            $data = $polaczenie->query('SELECT * FROM changelog ORDER BY `changelog`.`wersja` DESC');

            $changes = [];

            foreach ($data as $row) {
                $changes[$row['wersja']][] = $row;
            }

            foreach ($changes as $version => $features) {
                echo '
                        <div class="row odstep">
                            <div class="col-md-6">
                                <div class="wersja-changelogu kafelek brazowy">
                                    <p>Wersja: ' . $version . '</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="wpis-changelogu kafelek bialy">';

                foreach ($features as $row) {
                    echo '<p> - ' . $row['opis'] . '</p> ';
                }

                echo '</div></div></div>';
            }
        }
    }
?>