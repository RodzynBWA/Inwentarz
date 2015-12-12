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
            $haslo = md5($haslo);
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $sprawdzanie = "SELECT * FROM uzytkownicy WHERE login = '$login' AND haslo = '$haslo' LIMIT 1 ";
                $logowanie = mysqli_query($polaczenie, $sprawdzanie);
                $user_id = mysqli_fetch_assoc($logowanie);
                if($user_id == 0) {
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
                    $aktualny_czas_query = "UPDATE `Inwentarz`.`uzytkownicy` SET `last_logged` = NOW() WHERE `uzytkownicy`.`id` = '$id'";
                    $zalogowany_czas = mysqli_query($polaczenie, $aktualny_czas_query);

                    header("refresh:3; url=panel.php");

                    echo '<div class="containera">
                            <section class="notif notif-notice">
                                <h6 class="notif-title">Zalogowano!</h6>
                                <p>Zalogowano pomyślnie! W ciagu <span id="sekundy"></span> sekund zostaniesz przeniesiony do inwentarza!</p>
                            </section>
                        </div>';
                }
            }
            $polaczenie->close();
        }
    }
    public function nazwaSzkoly() {
        require('dbconnect.php');
        $szkola_nazwa = "SELECT * FROM ustawienia";
        $ustaw_znaki = $polaczenie->query('SET NAMES utf8');
        $nazwa = $polaczenie->query($szkola_nazwa);
        while($szkola = $nazwa->fetch_assoc()) {
            echo $szkola["nazwa-szkoly"];
        }
        $polaczenie->close();
    }
    public function rolaUsera() {
        ob_start();
        session_start();
        require('dbconnect.php');
        $inwentarz = new Inwentarz();
        $rola = $inwentarz->daneZalogowanego();
        if($rola['id'] == 1) {
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
            unset($_SESSION['zalogowany']);
            unset($_SESSION['uzytkownik_id']);

            require('dbconnect.php');
            $update_logowania = "UPDATE uzytkownicy SET `pre_last_logged`= `last_logged`";
            $wykonaj = mysqli_query($polaczenie, $update_logowania);

            session_destroy();
            header("Location: http://".$_SERVER['HTTP_HOST']."".dirname($_SERVER['PHP_SELF'])."/index.php");
        }
    }
    public function wersjaAplikacji() {
        require('dbconnect.php');
        $wersja_apki = "SELECT * FROM ustawienia";
        $nazwa = $polaczenie->query($wersja_apki);
        while($wersja = $nazwa->fetch_assoc()) {
            echo $wersja["wersja-apki"];
        }
        $polaczenie->close();
    }
    public function dataAktualizacji() {
        require('dbconnect.php');
        $data_aktualizacji = "SELECT * FROM ustawienia";
        $nazwa = $polaczenie->query($data_aktualizacji);
        while($data = $nazwa->fetch_assoc()) {
            echo $data["data-aktualizacji"];
        }
        $polaczenie->close();
    }
    public function daneZalogowanego($user_id = -1) {
        session_start();
        require('dbconnect.php');
        if($user_id == -1) {
            $user_id = $_SESSION['uzytkownik_id'];
        }
        $informacje = "SELECT * FROM uzytkownicy WHERE id = '$user_id' LIMIT 1";
        $pobierz_info = mysqli_query($polaczenie, $informacje);
        return mysqli_fetch_assoc($pobierz_info);
        $polaczenie->close();
    }

    public function changelog() {
        require('dbconnect.php');
        $data = $polaczenie->query('SELECT * FROM changelog');

        $changes = [];
        foreach ($data as $row) {
            $changes[$row['wersja']][] = $row;
        }

        print_r($changes['0.1']);
    }
}
?>