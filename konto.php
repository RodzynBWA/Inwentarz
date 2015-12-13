<?php
    require('header.php');
?>
    <div id="konto" class="container oddziel">
        <div class="row odstep">
            <div class="col-md-12">
                <div class="konto kafelek czerwony">
                    <p>Twoje konto</p>
                </div>
            </div>
        </div>
        <div class="row odstep">
            <div class="col-md-6">
                <div class="dane-osobowe kafelek brazowy">
                    <p>Imię i nazwisko:</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="dane-osobowe kafelek bialy">
                    <p><?php echo $dane_usera['imie']; ?> <?php echo $dane_usera['nazwisko'];?></p>
                </div>
            </div>
        </div>
        <div class="row odstep">
            <div class="col-md-6">
                <div class="dane-osobowe kafelek brazowy">
                    <p>Płeć:</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="dane-osobowe kafelek bialy">
                    <p><?php
                            if($dane_usera['plec'] == 0) {
                                echo ("Kobieta");
                            } else {
                                echo ("Mężczyzna");
                            }?></p>
                </div>
            </div>
        </div>
        <?php if ($dane_usera['klasa'] == null) {} else { ?>
            <div class="row odstep">
                <div class="col-md-6">
                    <div class="dane-osobowe kafelek brazowy">
                        <p>Klasa:</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dane-osobowe kafelek bialy">
                        <p><?php echo $dane_usera['klasa']; ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="row odstep">
            <div class="col-md-6">
                <div class="dane-osobowe kafelek brazowy">
                    <p>Ostatnie logowanie:</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="dane-osobowe kafelek bialy">
                    <p><?php echo $dane_usera['pre_last_logged']; ?></p>
                </div>
            </div>
        </div>
        <div class="row odstep">
            <div class="col-md-6">
                <div class="dane-osobowe kafelek brazowy">
                    <p>Rola:</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="dane-osobowe kafelek bialy">
                    <p><?php $inwentarz->rolaUsera();?></p>
                </div>
            </div>
        </div>
        <div class="row odstep">
            <div class="col-md-12">
                <div class="admin-inwentarza kafelek czerwony">
                    <p>W razie zmiany informacji zawartych w twoim profilu, należy skontaktować się z administatorem inwentarza <br>p.
                        <?php
                            echo $inwentarz->admin_inwentarza();
                        ?></p>
                </div>
            </div>
        </div>
    </div>

    </acticle>
    <?php include_once('footer.php');?>
</body>
</html>
